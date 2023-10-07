<?php

namespace Modules\Configuration\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Modules\Configuration\Entities\City;
use Modules\Configuration\Entities\District;
use Yajra\DataTables\DataTables;

class DistrictController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(District::query())
                ->editColumn('created_at', function ($row) {
                    return $row->created_at ? with(new Carbon($row->created_at))->isoFormat('dddd, D MMMM Y') : '';
                })
                ->addColumn('tools', function ($row) {

                    $btn = '<button 
                                onclick="ModalDistrictAddEdit(this)"  
                                type="button"
                                data-cmd="editDistrict" 
                                data-id="' . $row->id . '"
                                data-city_id="' . $row->city_id . '" 
                                data-name="' . $row->name . '" 
                                data-action="' . route('district.update') . '" 
                                class="btn btn-sm btn-icon icon-left btn-danger">
                                <i class="far fa-edit"></i>
                            </button>';

                    $btn = $btn . "&nbsp;";

                    $btn = $btn . '<button 
                                onclick="ModalDistrictDelete(this)"  
                                data-id="' . $row->id . '" 
                                data-name="' . $row->name . '" 
                                data-token="' . csrf_token() . '"
                                data-action="' . route('district.delete') . '" 
                                class="btn btn-sm btn-icon icon-left btn-secondary">
                                <i class="fas fa-trash"></i>
                            </button>';

                    return $btn;
                })
                ->addColumn('city', function ($row) {
                    // return '<span class="badge badge-info">Role Name</span>';
                    return $row->city->name;
                })
                ->rawColumns(['tools'])
                ->make(true);
        }
        $cities = City::all('name', 'id');
        return view('configuration::district.index', compact('cities'));
    }

    public function store(Request $request)
    {
        $rules = [
            'name'  => 'required|string|max:25|unique:districts,name',
        ];
        $msg = "";

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ]);

        try {

            $district = new District();
            $district->city_id = $request->city_id;
            $district->name = ucfirst($request->name);

            if ($district->save()) {
                return response()->json([
                    'success'   => true,
                    'message'   => 'succes created District',
                ]);
            } else {
                return response()->json([
                    'success'   => false,
                    'message'   => 'failed created District',
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
            'name'  => 'required|string|max:25|unique:districts,name,' . $request->district_id,
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ]);

        // return $request->district_id;
        try {
            if (!is_null($request->district_id)) {

                $district = District::find($request->district_id);

                $district->city_id = $request->city_id;
                $district->name = ucfirst($request->name);

                if ($district->save()) {
                    return response()->json([
                        'success'   => true,
                        'message'   => 'succes updated District',
                    ]);
                } else {
                    return response()->json([
                        'success'   => false,
                        'message'   => 'failed updated District',
                    ]);
                }
            } else {
                return response()->json([
                    'success'   => false,
                    'message'   => 'failed updated District, please check params',
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

                if (District::find($request->id)) {
                    District::destroy($request->id);
                    return response()->json([
                        'success'   => true,
                        'message'   => 'succes delete District',
                    ]);
                } else {
                    return response()->json([
                        'success'   => true,
                        'message'   => 'failed delete District',
                    ]);
                }
            } else {
                return response()->json([
                    'success'   => false,
                    'message'   => 'failed delete District, please check params',
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
