<?php

namespace Modules\Configuration\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Configuration\Entities\IdentityCard;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;

class IdentityCardController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(IdentityCard::query())
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
                                data-description="' . $row->description . '" 
                                data-action="' . route('identitycard.update') . '" 
                                class="btn btn-sm btn-icon icon-left btn-danger">
                                <i class="far fa-edit"></i>
                            </button>';

                    $btn = $btn . "&nbsp;";

                    $btn = $btn . '<button 
                                onclick="ModalDelete(this)"  
                                data-id="' . $row->id . '" 
                                data-name="' . $row->name . '" 
                                data-token="' . csrf_token() . '"
                                data-action="' . route('identitycard.delete') . '" 
                                class="btn btn-sm btn-icon icon-left btn-secondary">
                                <i class="fas fa-trash"></i>
                            </button>';

                    return $btn;
                })
                ->rawColumns(['tools'])
                ->make(true);
        }

        return view('configuration::identitycard.index');
    }

    public function store(Request $request)
    {
        $rules = [
            'code'  => 'required|string|max:25|unique:c_identity_cards,code',
            'name'  => 'required|string|max:25|unique:c_identity_cards,name',
        ];
        $msg = "";

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
            return response()->json([
                'success' => false,
                'message'   => 'failed updated Identity Card, please check params',
                'errors' => $validator->errors()
            ]);

        try {

            $IdentityCard = new IdentityCard();
            $IdentityCard->code = strtoupper($request->code);
            $IdentityCard->name = ucfirst($request->name);
            $IdentityCard->description = $request->description;

            if ($IdentityCard->save()) {
                return response()->json([
                    'success'   => true,
                    'message'   => 'succes created Identity Card',
                ]);
            } else {
                return response()->json([
                    'success'   => false,
                    'message'   => 'failed created Identity Card',
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
            'code'  => 'required|string|max:25|unique:c_identity_cards,code,' . $request->identitycard_id,
            'name'  => 'required|string|max:25|unique:c_identity_cards,name,' . $request->identitycard_id,
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
            return response()->json([
                'success' => false,
                'message'   => 'failed updated Identity Card, please check params',
                'errors' => $validator->errors()
            ]);

        try {
            if (!is_null($request->identitycard_id)) {

                $IdentityCard = IdentityCard::find($request->identitycard_id);
                $IdentityCard->code = strtoupper($request->code);
                $IdentityCard->name = ucfirst($request->name);
                $IdentityCard->description = $request->description;

                if ($IdentityCard->save()) {
                    return response()->json([
                        'success'   => true,
                        'message'   => 'succes updated Identity Card',
                    ]);
                } else {
                    return response()->json([
                        'success'   => false,
                        'message'   => 'failed updated Identity Card',
                    ]);
                }
            } else {
                return response()->json([
                    'success'   => false,
                    'message'   => 'failed updated Identity Card, please check params',
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
                if (IdentityCard::find($request->id)) {
                    IdentityCard::destroy($request->id);
                    return response()->json([
                        'success'   => true,
                        'message'   => 'succes delete Identity Card',
                    ]);
                } else {
                    return response()->json([
                        'success'   => true,
                        'message'   => 'failed delete Identity Card',
                    ]);
                }
            } else {
                return response()->json([
                    'success'   => false,
                    'message'   => 'failed delete Identity Card, please check params',
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
