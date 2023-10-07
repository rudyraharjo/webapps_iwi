<?php

namespace Modules\Configuration\Http\Controllers;

// use App\Models\City;
// use App\Models\Province;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Modules\Configuration\Entities\City;
use Modules\Configuration\Entities\Province;
use Yajra\DataTables\DataTables;

class CityController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(City::with('province'))
                ->editColumn('created_at', function ($row) {
                    return $row->created_at ? with(new Carbon($row->created_at))->isoFormat('dddd, D MMMM Y') : '';
                })
                ->addColumn('tools', function ($row) {

                    $btn = '<button 
                                onclick="ModalCityAddEdit(this)"  
                                type="button"
                                data-cmd="editCity" 
                                data-id="' . $row->id . '"
                                data-province_id="' . $row->province_id . '" 
                                data-name="' . $row->name . '" 
                                data-action="' . route('city.update') . '" 
                                class="btn btn-sm btn-icon icon-left btn-danger">
                                <i class="far fa-edit"></i>
                            </button>';

                    $btn = $btn . "&nbsp;";

                    $btn = $btn . '<button 
                                onclick="ModalCityDelete(this)"  
                                data-id="' . $row->id . '" 
                                data-name="' . $row->name . '" 
                                data-token="' . csrf_token() . '"
                                data-action="' . route('city.delete') . '" 
                                class="btn btn-sm btn-icon icon-left btn-secondary">
                                <i class="fas fa-trash"></i>
                            </button>';

                    return $btn;
                })
                ->addColumn('province', function ($row) {
                    // return '<span class="badge badge-info">Role Name</span>';
                    return $row->province->name;
                })
                ->rawColumns(['tools'])
                ->make(true);
        }
        $provinces = Province::all('name', 'id');
        return view('configuration::city.index', compact('provinces'));
    }

    public function store(Request $request)
    {
        $rules = [
            'name'  => 'required|string|max:25|unique:cities,name',
        ];
        $msg = "";

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ]);

        try {

            $city = new City();
            $city->province_id = $request->province_id;
            $city->name = ucfirst($request->name);

            if ($city->save()) {
                return response()->json([
                    'success'   => true,
                    'message'   => 'succes created City',
                ]);
            } else {
                return response()->json([
                    'success'   => false,
                    'message'   => 'failed created City',
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
            'name'  => 'required|string|max:25|unique:cities,name,' . $request->city_id,
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ]);

        try {
            if (!is_null($request->city_id)) {
                $city = City::find($request->city_id);
                $city->province_id = $request->province_id;
                $city->name = ucfirst($request->name);

                if ($city->save()) {
                    return response()->json([
                        'success'   => true,
                        'message'   => 'succes updated City',
                    ]);
                } else {
                    return response()->json([
                        'success'   => false,
                        'message'   => 'failed updated City',
                    ]);
                }
            } else {
                return response()->json([
                    'success'   => false,
                    'message'   => 'failed updated City, please check params',
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

                if (City::find($request->id)) {
                    City::destroy($request->id);
                    return response()->json([
                        'success'   => true,
                        'message'   => 'succes delete City',
                    ]);
                } else {
                    return response()->json([
                        'success'   => true,
                        'message'   => 'failed delete City',
                    ]);
                }
            } else {
                return response()->json([
                    'success'   => false,
                    'message'   => 'failed delete City, please check params',
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
