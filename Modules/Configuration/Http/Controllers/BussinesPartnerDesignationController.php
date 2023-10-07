<?php

namespace Modules\Configuration\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Modules\Configuration\Entities\BussinesPartnerDesignation;
use Yajra\DataTables\DataTables;

class BussinesPartnerDesignationController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(BussinesPartnerDesignation::query())
                ->editColumn('created_at', function ($row) {
                    return $row->created_at ? with(new Carbon($row->created_at))->isoFormat('dddd, D MMMM Y') : '';
                })
                ->addColumn('tools', function ($row) {

                    $btn = '<button 
                                    onclick="ModalAddEdit(this)"  
                                    type="button"
                                    data-cmd="edit" 
                                    data-id="' . $row->id . '"
                                    data-name="' . $row->name . '" 
                                    data-action="' . route('bp_designation.update') . '" 
                                    class="btn btn-sm btn-icon icon-left btn-danger">
                                    <i class="far fa-edit"></i>
                                </button>';

                    $btn = $btn . "&nbsp;";

                    $btn = $btn . '<button 
                                    onclick="ModalDelete(this)"  
                                    data-id="' . $row->id . '" 
                                    data-name="' . $row->name . '" 
                                    data-token="' . csrf_token() . '"
                                    data-action="' . route('bp_designation.delete') . '" 
                                    class="btn btn-sm btn-icon icon-left btn-secondary">
                                    <i class="fas fa-trash"></i>
                                </button>';

                    return $btn;
                })
                ->rawColumns(['tools'])
                ->make(true);
        }

        return view('configuration::bussines_partner.designation.index');
    }

    public function store(Request $request)
    {
        $rules = [
            'name'  => 'required|string|max:25|unique:c_designation,name',
        ];
        $msg = "";

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ]);

        try {

            $bpDesignation = new BussinesPartnerDesignation();
            $bpDesignation->name = ucfirst($request->name);

            if ($bpDesignation->save()) {
                return response()->json([
                    'success'   => true,
                    'message'   => 'succes created Designation',
                ]);
            } else {
                return response()->json([
                    'success'   => false,
                    'message'   => 'failed created Designation',
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
            'name'  => 'required|string|max:25|unique:c_designation,name,' . $request->designation_id,
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
            return response()->json([
                'success' => false,
                'message'   => 'failed updated Designation, please check params',
                'errors' => $validator->errors()
            ]);

        try {
            if (!is_null($request->designation_id)) {

                $bpDesignation = BussinesPartnerDesignation::find($request->designation_id);
                $bpDesignation->name = ucfirst($request->name);

                if ($bpDesignation->save()) {
                    return response()->json([
                        'success'   => true,
                        'message'   => 'Success Updated Designation',
                    ]);
                } else {
                    return response()->json([
                        'success'   => false,
                        'message'   => 'failed updated Designation',
                    ]);
                }
            } else {
                return response()->json([
                    'success'   => false,
                    'message'   => 'failed updated Designation, please check params',
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
                if (BussinesPartnerDesignation::find($request->id)) {
                    BussinesPartnerDesignation::destroy($request->id);
                    return response()->json([
                        'success'   => true,
                        'message'   => 'succes delete BuDesignation',
                    ]);
                } else {
                    return response()->json([
                        'success'   => true,
                        'message'   => 'failed delete Designation',
                    ]);
                }
            } else {
                return response()->json([
                    'success'   => false,
                    'message'   => 'failed delete Designation, please check params',
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
