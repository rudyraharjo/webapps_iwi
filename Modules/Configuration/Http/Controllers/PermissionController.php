<?php

namespace Modules\Configuration\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Yajra\DataTables\DataTables;
use App\Models\Permission;
use Illuminate\Support\Facades\Validator;

class PermissionController extends Controller
{
    
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(Permission::query())
                ->editColumn('created_at', function ($row) {
                    return $row->created_at ? with(new Carbon($row->created_at))->isoFormat('dddd, D MMMM Y') : '';
                })
                ->addColumn('tools', function ($row) {

                    $description = $row->description ? $row->description : "";
                    $btn = '<button 
                                onclick="ModalPermissionAddEdit(this)"  
                                type="button"
                                data-cmd="editPermission" 
                                data-id="' . $row->id . '"
                                data-name="' . $row->name . '" 
                                data-display_name="' . $row->display_name . '" 
                                data-description="' . $description . '" 
                                data-action="' . route('permission.update') . '" 
                                class="btn btn-sm btn-icon icon-left btn-danger">
                                <i class="far fa-edit"></i>
                            </button>';

                    $btn = $btn . "&nbsp;";

                    $btn = $btn . '<button 
                                onclick="ModalPermissionDelete(this)"  
                                data-id="' . $row->id . '" 
                                data-name="' . $row->name . '" 
                                data-token="' . csrf_token() . '"
                                data-action="' . route('permission.delete') . '" 
                                class="btn btn-sm btn-icon icon-left btn-secondary">
                                <i class="fas fa-trash"></i>
                            </button>';

                    return $btn;
                })
                ->rawColumns(['tools'])
                ->make(true);
        }
        
        return view('configuration::permission.index');
    }

    public function store(Request $request)
    {
        $rules = [
            'name'  => 'required|string|max:25|unique:permissions,name',
        ];
        $msg = "";

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ]);

        try {

            $permission = new Permission();
            $permission->name = strtolower($request->name);
            $permission->display_name = $request->display_name ? Ucfirst($request->display_name) : Ucfirst($request->name);
            $permission->description = Ucfirst($request->description);
            if ($permission->save()) {
                return response()->json([
                    'success'   => true,
                    'message'   => 'succes created permission',
                ]);
            } else {
                return response()->json([
                    'success'   => false,
                    'message'   => 'failed created permission',
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
            'name'  => 'required|string|max:25|unique:permissions,name,' . $request->permission_id,
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ]);

        try {
            if (!is_null($request->permission_id)) {
                $permission = Permission::find($request->permission_id);
                $permission->name = $request->name;
                $permission->display_name = $request->display_name ? Ucfirst($request->display_name) : Ucfirst($request->name);
                $permission->description = Ucfirst($request->description);

                if ($permission->save()) {
                    return response()->json([
                        'success'   => true,
                        'message'   => 'succes updated permission',
                    ]);
                } else {
                    return response()->json([
                        'success'   => false,
                        'message'   => 'failed updated permission',
                    ]);
                }
            } else {
                return response()->json([
                    'success'   => false,
                    'message'   => 'failed updated permission, please check params',
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

                if (Permission::find($request->id)) {
                    Permission::destroy($request->id);
                    return response()->json([
                        'success'   => true,
                        'message'   => 'succes delete Permission',
                    ]);
                } else {
                    return response()->json([
                        'success'   => true,
                        'message'   => 'failed delete Permission',
                    ]);
                }
            } else {
                return response()->json([
                    'success'   => false,
                    'message'   => 'failed delete Permission, please check params',
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
