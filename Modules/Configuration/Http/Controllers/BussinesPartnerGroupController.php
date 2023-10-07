<?php

namespace Modules\Configuration\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

use Modules\Configuration\Entities\BussinesPartnerGroup;

class BussinesPartnerGroupController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(BussinesPartnerGroup::query())
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
                                data-action="' . route('bp_group.update') . '" 
                                class="btn btn-sm btn-icon icon-left btn-danger">
                                <i class="far fa-edit"></i>
                            </button>';

                    $btn = $btn . "&nbsp;";

                    $btn = $btn . '<button 
                                onclick="ModalDelete(this)"  
                                data-id="' . $row->id . '" 
                                data-name="' . $row->name . '" 
                                data-token="' . csrf_token() . '"
                                data-action="' . route('bp_group.delete') . '" 
                                class="btn btn-sm btn-icon icon-left btn-secondary">
                                <i class="fas fa-trash"></i>
                            </button>';

                    return $btn;
                })
                ->rawColumns(['tools'])
                ->make(true);
        }

        return view('configuration::bussines_partner.group.index');
    }

    public function store(Request $request)
    {
        $rules = [
            'name'  => 'required|string|max:25|unique:c_business_partner_groups,name',
        ];
        $msg = "";

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ]);

        try {
            $bpGroup = new BussinesPartnerGroup();
            $bpGroup->name = ucfirst($request->name);

            if ($bpGroup->save()) {
                return response()->json([
                    'success'   => true,
                    'message'   => 'succes created Group Bussines Partner',
                ]);
            } else {
                return response()->json([
                    'success'   => false,
                    'message'   => 'failed created Group Bussines Partner',
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
            'name'  => 'required|string|max:25|unique:c_business_partner_groups,name,' . $request->bp_group_id,
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ]);

        try {
            if (!is_null($request->bp_group_id)) {

                $bpGroup = BussinesPartnerGroup::find($request->bp_group_id);
                $bpGroup->name = ucfirst($request->name);

                if ($bpGroup->save()) {
                    return response()->json([
                        'success'   => true,
                        'message'   => 'succes updated Group Bussines Partner',
                    ]);
                } else {
                    return response()->json([
                        'success'   => false,
                        'message'   => 'failed updated Group Bussines Partner',
                    ]);
                }
            } else {
                return response()->json([
                    'success'   => false,
                    'message'   => 'failed updated Bussines Partner Group, please check params',
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
                if (BussinesPartnerGroup::find($request->id)) {
                    BussinesPartnerGroup::destroy($request->id);
                    return response()->json([
                        'success'   => true,
                        'message'   => 'succes delete Group Bussines Partner',
                    ]);
                } else {
                    return response()->json([
                        'success'   => true,
                        'message'   => 'failed delete Group Bussines Partner',
                    ]);
                }
            } else {
                return response()->json([
                    'success'   => false,
                    'message'   => 'failed delete Group Bussines Partner, please check params',
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
