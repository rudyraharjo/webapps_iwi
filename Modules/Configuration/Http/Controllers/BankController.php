<?php

namespace Modules\Configuration\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controller;
use Modules\Configuration\Entities\Bank;
use Yajra\DataTables\DataTables;

class BankController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(Bank::query())
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
                                data-action="' . route('bank.update') . '" 
                                class="btn btn-sm btn-icon icon-left btn-danger">
                                <i class="far fa-edit"></i>
                            </button>';

                    $btn = $btn . "&nbsp;";

                    $btn = $btn . '<button 
                                onclick="ModalDelete(this)"  
                                data-id="' . $row->id . '" 
                                data-name="' . $row->name . '" 
                                data-token="' . csrf_token() . '"
                                data-action="' . route('bank.delete') . '" 
                                class="btn btn-sm btn-icon icon-left btn-secondary">
                                <i class="fas fa-trash"></i>
                            </button>';

                    return $btn;
                })
                ->rawColumns(['tools'])
                ->make(true);
        }

        return view('configuration::bank.index');
    }

    public function store(Request $request)
    {
        $rules = [
            'code'  => 'required|string|max:25|unique:c_banks,code',
            'name'  => 'required|string|max:25|unique:c_banks,name',
        ];
        $msg = "";

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
            return response()->json([
                'success' => false,
                'message'   => 'failed updated Bank, please check params',
                'errors' => $validator->errors()
            ]);

        try {

            $bank = new Bank();
            $bank->code = strtoupper($request->code);
            $bank->name = ucfirst($request->name);
            $bank->description = $request->description;

            if ($bank->save()) {
                return response()->json([
                    'success'   => true,
                    'message'   => 'succes created Bank',
                ]);
            } else {
                return response()->json([
                    'success'   => false,
                    'message'   => 'failed created Bank',
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
            'code'  => 'required|string|max:25|unique:c_banks,code,' . $request->bank_id,
            'name'  => 'required|string|max:25|unique:c_banks,name,' . $request->bank_id,
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
            return response()->json([
                'success' => false,
                'message'   => 'failed updated Bank, please check params',
                'errors' => $validator->errors()
            ]);

        try {
            if (!is_null($request->bank_id)) {

                $bank = Bank::find($request->bank_id);
                $bank->code = strtoupper($request->code);
                $bank->name = ucfirst($request->name);
                $bank->description = $request->description;

                if ($bank->save()) {
                    return response()->json([
                        'success'   => true,
                        'message'   => 'succes updated Bank',
                    ]);
                } else {
                    return response()->json([
                        'success'   => false,
                        'message'   => 'failed updated Bank',
                    ]);
                }
            } else {
                return response()->json([
                    'success'   => false,
                    'message'   => 'failed updated Bank, please check params',
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
                if (Bank::find($request->id)) {
                    Bank::destroy($request->id);
                    return response()->json([
                        'success'   => true,
                        'message'   => 'succes delete Bank',
                    ]);
                } else {
                    return response()->json([
                        'success'   => true,
                        'message'   => 'failed delete Bank',
                    ]);
                }
            } else {
                return response()->json([
                    'success'   => false,
                    'message'   => 'failed delete Bank, please check params',
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
