<?php

namespace Modules\Configuration\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

use Modules\Configuration\Entities\BusinessPartnerCategory;

class BussinesPartnerCategoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(BusinessPartnerCategory::query())
                ->editColumn('created_at', function ($row) {
                    return $row->created_at ? with(new Carbon($row->created_at))->isoFormat('dddd, D MMMM Y') : '';
                })
                ->addColumn('tools', function ($row) {

                    $btn = '<button 
                                onclick="ModalAddEdit(this)"  
                                type="button"
                                data-cmd="edit" 
                                data-id="' . $row->id . '"
                                data-code="' . $row->code . '" 
                                data-name="' . $row->name . '" 
                                data-action="' . route('bp_category.update') . '" 
                                class="btn btn-sm btn-icon icon-left btn-danger">
                                <i class="far fa-edit"></i>
                            </button>';

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

        return view('configuration::bussines_partner.category.index');
    }

    public function store(Request $request)
    {
        $rules = [
            'bp_category_code'  => 'required|string|max:25|unique:c_business_partner_categories,code',
            'name'  => 'required|string|max:25|unique:c_business_partner_categories,name',
        ];
        $msg = "";

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ]);

        try {

            $bpCategory = new BusinessPartnerCategory();
            $bpCategory->code = strtoupper($request->bp_category_code);
            $bpCategory->name = ucfirst($request->name);

            if ($bpCategory->save()) {
                return response()->json([
                    'success'   => true,
                    'message'   => 'succes created Bussines Partner Category',
                ]);
            } else {
                return response()->json([
                    'success'   => false,
                    'message'   => 'failed created Bussines Partner Category',
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success'   => false,
                'message'   => $e->getMessage(),
            ]);
        }
    }

    public function update(Request $request)
    {
        $rules = [
            'bp_category_code'  => 'required|string|max:25|unique:c_business_partner_categories,code,' . $request->bp_category_id,
            'name'  => 'required|string|max:25|unique:c_business_partner_categories,name,' . $request->bp_category_id,
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ]);

        try {
            if (!is_null($request->bp_category_id)) {

                $bpCategory = BusinessPartnerCategory::find($request->bp_category_id);
                $bpCategory->code = strtoupper($request->bp_category_code);
                $bpCategory->name = ucfirst($request->name);

                if ($bpCategory->save()) {
                    return response()->json([
                        'success'   => true,
                        'message'   => 'succes updated Bussines Partner Category',
                    ]);
                } else {
                    return response()->json([
                        'success'   => false,
                        'message'   => 'failed updated Bussines Partner Category',
                    ]);
                }
            } else {
                return response()->json([
                    'success'   => false,
                    'message'   => 'failed updated Bussines Partner Category, please check params',
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success'   => false,
                'message'   => $e->getMessage(),
            ]);
        }
    }

    public function delete(Request $request)
    {
        try {
            if (!is_null($request->id)) {
                if (BusinessPartnerCategory::find($request->id)) {
                    BusinessPartnerCategory::destroy($request->id);
                    return response()->json([
                        'success'   => true,
                        'message'   => 'succes delete Bussines Partner Category',
                    ]);
                } else {
                    return response()->json([
                        'success'   => true,
                        'message'   => 'failed delete Bussines Partner Category',
                    ]);
                }
            } else {
                return response()->json([
                    'success'   => false,
                    'message'   => 'failed delete Bussines Partner Category, please check params',
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success'   => false,
                'message'   => $e->getMessage(),
            ]);
        }
    }
}
