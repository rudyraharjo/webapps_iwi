<?php

namespace Modules\Configuration\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(Role::with('permissions'))
                ->editColumn('created_at', function ($row) {
                    // return $row->created_at ? with(new Carbon($row->created_at))->diffForHumans() : '';
                    return $row->created_at ? with(new Carbon($row->created_at))->isoFormat('dddd, D MMMM Y') : '';
                    // return $row->created_at ? with(new Carbon($row->created_at))->format('d, M Y H:i') : '';
                })
                ->addColumn('tools', function ($row) {
                    // dd($row->permissions->pluck('name'));
                    $permissions = null;
                    $dataPermissions = null;
                    if (count($row->permissions) > 0) {
                        $permissions =  $row->permissions->map(function ($permission) {
                            return $permission->id;
                        });
                    }
                    if (!is_null($permissions)) {
                        $dataPermissions = 'data-permissions=' . $permissions;
                    }
                    // dd($dataPermissions);
                    $btn = '<button 
                                onclick="ModalAddEdit(this)"
                                type="button"
                                data-cmd="edit" 
                                data-id="' . $row->id . '"
                                data-name="' . $row->name . '" 
                                data-display_name="' . $row->display_name . '" 
                                data-description="' . $row->description . '" 
                                ' . $dataPermissions . '
                                data-action="' . route('role.update') . '" 
                                class="btn btn-sm btn-icon icon-left btn-danger">
                                <i class="far fa-edit"></i>
                            </button>';

                    $btn = $btn . "&nbsp;";

                    $btn = $btn . '<button                                 
                                onclick="ModalDeleteRole(this)"
                                type="button"
                                data-id="' . $row->id . '" 
                                data-name="' . $row->name . '" 
                                data-token="' . csrf_token() . '"
                                data-action="' . route('role.delete') . '" 
                                class="btn btn-sm btn-icon icon-left btn-secondary">
                                <i class="fas fa-trash"></i>
                            </button>';

                    return $btn;
                })
                ->addColumn('permissions', function ($row) {
                    return $row->permissions->map(function ($permission) {
                        return '<span class="badge badge-warning">' . $permission->name . '</span>';
                    })->implode(' ');
                })
                ->rawColumns(['tools', 'permissions'])
                ->make(true);
        }
        $permissions = Permission::all();
        return view('configuration::role.index', compact('permissions'));
    }

    public function store(Request $request)
    {
        $rules = [
            'name'     => 'required|string|max:25|unique:roles,name',
            'permissions'   => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ]);

        try {

            $role = new Role();
            $role->name = $request->name;
            $role->display_name = $request->display_name;
            $role->description = $request->description;

            if ($role->save()) {
                if ($request->has('permissions')) {
                    $role->syncPermissions($request->permissions);
                }
                return response()->json([
                    'success'   => true,
                    'message'   => 'succes created role',
                ]);
            } else {
                return response()->json([
                    'success'   => false,
                    'message'   => 'succes created role',
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
            'name'  => 'required|string|max:25|unique:roles,name,' . $request->role_id,
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ]);

        try {
            if (!is_null($request->role_id)) {
                $role = Role::find($request->role_id);
                $role->name = $request->name;
                $role->display_name = $request->display_name;
                $role->description = $request->description;

                if ($role->save()) {
                    if ($request->has('permissions')) {
                        $role->syncPermissions($request->permissions);
                    }

                    return response()->json([
                        'success'   => true,
                        'message'   => 'succes updated role',
                    ]);
                } else {
                    return response()->json([
                        'success'   => false,
                        'message'   => 'failed updated role',
                    ]);
                }
            } else {
                return response()->json([
                    'success'   => false,
                    'message'   => 'failed updated role, please check params',
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

                if (Role::find($request->id)) {
                    Role::destroy($request->id);
                    return response()->json([
                        'success'   => true,
                        'message'   => 'succes delete Role',
                    ]);
                } else {
                    return response()->json([
                        'success'   => true,
                        'message'   => 'failed delete Role',
                    ]);
                }
            } else {
                return response()->json([
                    'success'   => false,
                    'message'   => 'failed delete Role, please check params',
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
