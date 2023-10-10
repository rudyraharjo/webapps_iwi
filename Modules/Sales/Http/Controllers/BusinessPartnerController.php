<?php

namespace Modules\Sales\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Modules\Configuration\Entities\BusinessPartnerCategory;
use Modules\Configuration\Entities\BusinessPartnerGroup;
use Modules\Configuration\Entities\BussinesPartnerDesignation;
use Modules\Configuration\Entities\Province;
use Modules\Sales\Entities\BusinessPartner;
use Yajra\DataTables\Facades\DataTables;

class BusinessPartnerController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(BusinessPartner::query())
                ->editColumn('created_at', function ($row) {
                    return $row->created_at ? with(new Carbon($row->created_at))->isoFormat('dddd, D MMMM Y') : '';
                })
                ->addColumn('tools', function ($row) {

                    $btn = '<a 
                                href="' . route('business_partner.edit', ['id' => $row->id]) . '"  
                                data-cmd="edit" 
                                data-id="' . $row->id . '"
                                data-code="' . $row->code . '" 
                                data-name="' . $row->name . '" 
                                data-action="' . route('bp_category.update') . '" 
                                class="btn btn-sm btn-icon icon-left btn-danger">
                                <i class="far fa-edit"></i>
                            </a>';

                    $btn = $btn . "&nbsp;";

                    $btn = $btn . '<button 
                                onclick="ModalDelete(this)"  
                                data-id="' . $row->id . '" 
                                data-name="' . $row->name . '" 
                                data-token="' . csrf_token() . '"
                                data-action="' . route('bp_category.delete') . '" 
                                class="btn btn-sm btn-icon icon-left btn-secondary">
                                <i class="fas fa-trash"></i>
                            </button>';

                    return $btn;
                })
                ->rawColumns(['tools'])
                ->make(true);
        }

        return view('sales::business_partner.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $bpcategories = BusinessPartnerCategory::get();
        $bpgroups = BusinessPartnerGroup::get();
        $titles = BussinesPartnerDesignation::get();
        $provinces = Province::get();

        return view('sales::business_partner.create', compact(['bpcategories', 'bpgroups', 'titles', 'provinces']));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'old_code' => 'required|max:25',
                'name'  => 'required|string|max:25|unique:s_business_partners,name',
                'email' => 'required|nullable|email',
                'phone01' => 'required|nullable|numeric|min:0|not_in:0',
                'phone02' => 'nullable|numeric|min:0|not_in:0',
                'handphone' => 'required|nullable|numeric|min:0|not_in:0',
            ],
            [
                'old_code.required' => 'Isian Kode Lama wajib diisi',
                'name.required' => 'Isian Nama Rekan Bisnis wajib diisi',
                'email' => 'Isian Email harus berupa alamat surel yang valid.',
                'phone_01.numeric' => 'Isian Telepon 1 harus berupa angka.',
                'phone_01.not_in' => 'Isian Telepon 1 tidak valid',
                'phone_02.numeric' => 'Isian Telepon 2 harus berupa angka.',
                'phone_02.not_in' => 'Isian Telepon 2 tidak valid.',
                'handphone.numeric' => 'Isian Nomor Handphone harus berupa angka.',
                'handphone.not_in' => 'Isian Nomor Handphone tidak valid.',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $addBp = new BusinessPartner();
            $addBp->code = '-';
            $addBp->old_code = $request->old_code;
            $addBp->category_id = $request->category_id;
            $addBp->designation_id = $request->title_id;
            $addBp->name = $request->name;
            $addBp->business_partner_group_id = $request->business_partner_group_id;
            $addBp->currency_id = $request->currency_id;
            $addBp->shipment_id = $request->shipment_id;
            $addBp->activated_status = true;
            $addBp->periode_start = date("Y-m-d");
            $addBp->periode_end = date("Y-m-d", strtotime('+1 year'));
            $addBp->phone_01 = $request->phone01 ? $request->phone01 : '';
            $addBp->phone_02 = $request->phone02 ? $request->phone02 : '';
            $addBp->handphone = $request->handphone ? $request->handphone : '';
            $addBp->email = $request->email ? $request->email : '';
            $addBp->province_id = $request->province_id;
            $addBp->noted = $request->noted ?? '';
            $addBp->save();
            if ($addBp->save()) {
                $addBp->code = 'RB' . sprintf('%06d', $addBp->id);
                $addBp->update();
                Session::flash('message_success', 'Tambah data berhasil. Silahkan Input Daftar Kontak dan Daftar Alamat.');
                return redirect('/app/business-partner/edit/' . $addBp->id);
            } else {
                throw new ('Failed create new customer');
            }
        } catch (\Exception $e) {
            Session::flash('message_failed', $e->getMessage());
            return redirect('/app/business-partner/create');
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('sales::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $businesspartners = BusinessPartner::find($id);
        $bpcategories = BusinessPartnerCategory::get();
        $bpgroups = BusinessPartnerGroup::get();
        $titles = BussinesPartnerDesignation::get();
        $provinces = Province::get();

        return view('sales::business_partner.edit', compact(['businesspartners', 'bpcategories', 'bpgroups', 'titles', 'provinces']));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'old_code' => 'required|max:25',
                'name'  => 'required|string|max:25',
                'email' => 'required|nullable|email',
                'phone01' => 'required|nullable|numeric|min:0|not_in:0',
                'phone02' => 'nullable|numeric|min:0|not_in:0',
                'handphone' => 'required|nullable|numeric|min:0|not_in:0',
            ],
            [
                'old_code.required' => 'Isian Kode Lama wajib diisi',
                'name.required' => 'Isian Nama Rekan Bisnis wajib diisi',
                'email' => 'Isian Email harus berupa alamat surel yang valid.',
                'phone_01.numeric' => 'Isian Telepon 1 harus berupa angka.',
                'phone_01.not_in' => 'Isian Telepon 1 tidak valid',
                'phone_02.numeric' => 'Isian Telepon 2 harus berupa angka.',
                'phone_02.not_in' => 'Isian Telepon 2 tidak valid.',
                'handphone.numeric' => 'Isian Nomor Handphone harus berupa angka.',
                'handphone.not_in' => 'Isian Nomor Handphone tidak valid.',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {

            $updateBp = BusinessPartner::find($id);
            // dd($updateBp);
            $updateBp->old_code = $request->old_code;
            $updateBp->category_id = $request->category_id;
            $updateBp->designation_id = $request->title_id;
            $updateBp->name = $request->name;
            $updateBp->business_partner_group_id = $request->business_partner_group_id;
            $updateBp->currency_id = $request->currency_id;
            $updateBp->shipment_id = $request->shipment_id;
            $updateBp->activated_status = true;
            $updateBp->periode_start = date("Y-m-d");
            $updateBp->periode_end = date("Y-m-d", strtotime('+1 year'));
            $updateBp->phone_01 = $request->phone01 ? $request->phone01 : '';
            $updateBp->phone_02 = $request->phone02 ? $request->phone02 : '';
            $updateBp->handphone = $request->handphone ? $request->handphone : '';
            $updateBp->email = $request->email ? $request->email : '';
            $updateBp->province_id = $request->province_id;
            $updateBp->noted = $request->noted ?? '';
            $updateBp->save();

            Session::flash('message_success', 'Ubah data berhasil.');
            return redirect('/app/business-partner/edit/' . $updateBp->id);
        } catch (\Exception $e) {
            Session::flash('message_failed', $e->getMessage());
            return redirect('/app/business-partner/create');
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
