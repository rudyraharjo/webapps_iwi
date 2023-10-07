<?php

namespace Modules\Configuration\Http\Controllers;

// use App\Models\Province;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Modules\Configuration\Entities\Province;
use Yajra\DataTables\DataTables;

class ProvinceController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(Province::query())
                ->editColumn('created_at', function ($row) {
                    return $row->created_at ? with(new Carbon($row->created_at))->isoFormat('dddd, D MMMM Y') : '';
                })
                ->addColumn('tools', function ($row) {

                    $btn = '<button 
                                onclick="ModalProvinceAddEdit(this)"  
                                type="button"
                                data-cmd="editProvince" 
                                data-id="' . $row->id . '"
                                data-name="' . $row->name . '" 
                                data-action="' . route('province.update') . '" 
                                class="btn btn-sm btn-icon icon-left btn-danger">
                                <i class="far fa-edit"></i>
                            </button>';

                    $btn = $btn . "&nbsp;";

                    $btn = $btn . '<button 
                                onclick="ModalProvinceDelete(this)"  
                                data-id="' . $row->id . '" 
                                data-name="' . $row->name . '" 
                                data-token="' . csrf_token() . '"
                                data-action="' . route('province.delete') . '" 
                                class="btn btn-sm btn-icon icon-left btn-secondary">
                                <i class="fas fa-trash"></i>
                            </button>';

                    return $btn;
                })
                ->rawColumns(['tools'])
                ->make(true);
        }
        return view('configuration::province.index');
    }

    public function store(Request $request)
    {
        $rules = [
            'name'  => 'required|string|max:25|unique:provinces,name',
        ];
        $msg = "";

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ]);

        try {

            $province = new Province();
            $province->name = strtolower($request->name);

            if ($province->save()) {
                return response()->json([
                    'success'   => true,
                    'message'   => 'succes created Province',
                ]);
            } else {
                return response()->json([
                    'success'   => false,
                    'message'   => 'failed created Province',
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
            'name'  => 'required|string|max:25|unique:provinces,name,' . $request->province_id,
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ]);

        try {
            if (!is_null($request->province_id)) {
                $province = Province::find($request->province_id);
                $province->name = Ucfirst($request->name);

                if ($province->save()) {
                    return response()->json([
                        'success'   => true,
                        'message'   => 'succes updated Province',
                    ]);
                } else {
                    return response()->json([
                        'success'   => false,
                        'message'   => 'failed updated Province',
                    ]);
                }
            } else {
                return response()->json([
                    'success'   => false,
                    'message'   => 'failed updated Province, please check params',
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

                if (Province::find($request->id)) {
                    Province::destroy($request->id);
                    return response()->json([
                        'success'   => true,
                        'message'   => 'succes delete Province',
                    ]);
                } else {
                    return response()->json([
                        'success'   => true,
                        'message'   => 'failed delete Province',
                    ]);
                }
            } else {
                return response()->json([
                    'success'   => false,
                    'message'   => 'failed delete Province, please check params',
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
