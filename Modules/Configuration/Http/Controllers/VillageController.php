<?php

namespace Modules\Configuration\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Modules\Configuration\Entities\District;
use Modules\Configuration\Entities\Village;
use Yajra\DataTables\DataTables;

class VillageController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(Village::query())
                ->editColumn('created_at', function ($row) {
                    return $row->created_at ? with(new Carbon($row->created_at))->isoFormat('dddd, D MMMM Y') : '';
                })
                ->addColumn('tools', function ($row) {

                    $btn = '<button 
                                onclick="ModalVillageAddEdit(this)"  
                                type="button"
                                data-cmd="editVillage" 
                                data-id="' . $row->id . '"
                                data-district_id="' . $row->district_id . '" 
                                data-name="' . $row->name . '" 
                                data-action="' . route('village.update') . '" 
                                class="btn btn-sm btn-icon icon-left btn-danger">
                                <i class="far fa-edit"></i>
                            </button>';

                    $btn = $btn . "&nbsp;";

                    $btn = $btn . '<button 
                                onclick="ModalVillageDelete(this)"  
                                data-id="' . $row->id . '" 
                                data-name="' . $row->name . '" 
                                data-token="' . csrf_token() . '"
                                data-action="' . route('village.delete') . '" 
                                class="btn btn-sm btn-icon icon-left btn-secondary">
                                <i class="fas fa-trash"></i>
                            </button>';

                    return $btn;
                })
                ->addColumn('district', function ($row) {
                    // return '<span class="badge badge-info">Role Name</span>';
                    return $row->district->name;
                })
                ->rawColumns(['tools'])
                ->make(true);
        }
        $districts = District::all('name', 'id');
        return view('configuration::village.index', compact('districts'));
    }

    public function store(Request $request)
    {
        $rules = [
            'name'  => 'required|string|max:25|unique:villages,name',
        ];
        $msg = "";

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ]);

        try {

            $village = new Village();
            $village->district_id = $request->district_id;
            $village->name = ucfirst($request->name);

            if ($village->save()) {
                return response()->json([
                    'success'   => true,
                    'message'   => 'succes created Village',
                ]);
            } else {
                return response()->json([
                    'success'   => false,
                    'message'   => 'failed created Village',
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
            'name'  => 'required|string|max:25|unique:villages,name,' . $request->village_id,
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ]);

        try {
            if (!is_null($request->village_id)) {

                $village = Village::find($request->village_id);

                $village->district_id = $request->district_id;
                $village->name = ucfirst($request->name);

                if ($village->save()) {
                    return response()->json([
                        'success'   => true,
                        'message'   => 'succes updated village',
                    ]);
                } else {
                    return response()->json([
                        'success'   => false,
                        'message'   => 'failed updated village',
                    ]);
                }
            } else {
                return response()->json([
                    'success'   => false,
                    'message'   => 'failed updated village, please check params',
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

                if (Village::find($request->id)) {
                    Village::destroy($request->id);
                    return response()->json([
                        'success'   => true,
                        'message'   => 'succes delete Village',
                    ]);
                } else {
                    return response()->json([
                        'success'   => true,
                        'message'   => 'failed delete Village',
                    ]);
                }
            } else {
                return response()->json([
                    'success'   => false,
                    'message'   => 'failed delete Village, please check params',
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
