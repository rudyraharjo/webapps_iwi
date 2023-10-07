<?php

namespace Modules\Configuration\Http\Controllers;

use App\Models\Role;
use App\Models\Team;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            return DataTables::of(User::with('roles'))
                ->editColumn('created_at', function ($row) {
                    // return $row->created_at ? with(new Carbon($row->created_at))->diffForHumans() : '';
                    return $row->created_at ? with(new Carbon($row->created_at))->isoFormat('dddd, D MMMM Y') : '';
                })
                ->editColumn('email_verified_at', function ($row) {
                    return $row->email_verified_at ? '<span class="badge badge-info">Verify</span>' : '';
                })
                ->addColumn('tools', function ($row) {

                    $roles = null;
                    if (count($row->roles) > 0) {

                        $roles =  $row->roles->map(function ($role) {
                            return $role->id . "," . $role->name;
                        })->implode(',');
                    }

                    $btn = '<button 
                        onclick="ModalAddEdit(this)"
                        data-cmd="edit" 
                        data-id="' . $row->id . '"
                        data-name="' . $row->name . '" 
                        data-email="' . $row->email . '" 
                        data-role="' . $roles . '" 
                        data-action="' . route('user.update') . '" 
                        class="btn btn-sm btn-icon icon-left btn-danger">
                        <i class="far fa-edit"></i>
                    </button>';

                    $btn = $btn . "&nbsp;";

                    $btn = $btn . '<button 
                            onclick="ModalDeleteUser(this)"
                            data-id="' . $row->id . '" 
                            data-name="' . $row->name . '" 
                            data-token="' . csrf_token() . '"
                            data-action="' . route('user.delete') . '" 
                            class="btn btn-sm btn-icon icon-left btn-secondary">
                            <i class="fas fa-trash"></i>
                        </button>';

                    return $btn;
                })
                ->addColumn('role', function ($row) {
                    // return '<span class="badge badge-info">Role Name</span>';
                    return $row->roles->map(function ($role) {
                        return '<span class="badge badge-warning">' . $role->name . '</span>';
                    })->implode(' ');
                })
                ->rawColumns(['tools', 'role', 'email_verified_at'])
                ->make(true);
        }

        $roles = DB::table('roles')->get();
        $teams = DB::table('teams')->get();
        
        return view('configuration::user.index', compact('roles', 'teams'));
    }

    public function store(Request $request)
    {

        $rules = [
            'user_fullname'     => 'required',
            'user_email'        => 'required|string|email|unique:users,email',
            'password'     => 'required|confirmed|string',
            'user_role'         => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ]);

        try {
            $user = new User();
            $user->name = Ucfirst($request->user_fullname);
            $user->email = $request->user_email;
            $user->email_verified_at = date("Y-m-d H:i:s");
            $user->password = bcrypt($request->password_confirmation);

            if ($user->save()) {
                $role = Role::where('id', $request->user_role)->first();
                $team = Team::where('id', $request->user_team)->first();
                $rolePermissions = [];
                foreach ($role->permissions as $permission) {
                    array_push($rolePermissions, $permission->id);
                }
                $user->attachRole($role, $team);
                $user->syncPermissions($rolePermissions);
                return response()->json([
                    'success'   => true,
                    'message'   => "succes created user",
                ]);
            } else {
                return response()->json([
                    'success'   => false,
                    'message'   => 'failed created user',
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
            'user_fullname'    => 'required|string',
            'user_email'        => 'required|string|email|unique:users,email,' . $request->user_id,
            'user_role'         => 'required',
            // 'role_name'  => 'required|string|max:25|unique:roles,name,' . $request->role_id,
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ]);

        try {
            if (!is_null($request->user_id)) {
                $user = User::find($request->user_id);

                $user->name = Ucfirst($request->user_fullname);
                $user->email = $request->user_email;
                if ($request->password_confirmation) {
                    $user->password = bcrypt($request->password_confirmation);
                }

                if ($user->save()) {

                    $role = Role::where('id', $request->user_role)->first();
                    $rolePermissions = [];
                    foreach ($role->permissions as $permission) {
                        array_push($rolePermissions, $permission->id);
                    }
                    $user->attachRole($role);
                    $user->syncPermissions($rolePermissions);

                    return response()->json([
                        'success'   => true,
                        'message'   => 'succes updated user',
                    ]);
                } else {
                    return response()->json([
                        'success'   => false,
                        'message'   => 'failed updated user',
                    ]);
                }
            } else {
                return response()->json([
                    'success'   => false,
                    'message'   => 'failed updated user, please check params',
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

                if ($user = User::find($request->id)) {
                    $user->delete($request->id);
                    return response()->json([
                        'success'   => true,
                        'message'   => 'succes delete User',
                    ]);
                } else {
                    return response()->json([
                        'success'   => true,
                        'message'   => 'failed delete User',
                    ]);
                }
            } else {
                return response()->json([
                    'success'   => false,
                    'message'   => 'failed delete User, please check params',
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
