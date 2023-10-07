<?php

namespace Modules\Configuration\Http\Controllers;

use App\Models\Team;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;

class TeamController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return datatables()::of(Team::query())
                ->editColumn('created_at', function ($row) {
                    return $row->created_at ? with(new Carbon($row->created_at))->isoFormat('dddd, D MMMM Y') : '';
                })
                ->addColumn('tools', function ($row) {

                    $description = $row->description ? $row->description : "";
                    $btn = '<button 
                                onclick="ModalAddEdit(this)"  
                                type="button"
                                data-cmd="editTeam" 
                                data-id="' . $row->id . '"
                                data-name="' . $row->name . '" 
                                data-display_name="' . $row->display_name . '" 
                                data-description="' . $description . '" 
                                data-action="' . route('team.update') . '" 
                                class="btn btn-sm btn-icon icon-left btn-danger">
                                <i class="far fa-edit"></i>
                            </button>';

                    $btn = $btn . "&nbsp;";

                    $btn = $btn . '<button 
                                onclick="ModalDeleteTeam(this)"  
                                data-id="' . $row->id . '" 
                                data-name="' . $row->name . '" 
                                data-token="' . csrf_token() . '"
                                data-action="' . route('team.delete') . '" 
                                class="btn btn-sm btn-icon icon-left btn-secondary">
                                <i class="fas fa-trash"></i>
                            </button>';

                    return $btn;
                })
                ->rawColumns(['tools'])
                ->make(true);
        }
        return view('configuration::team.index');
    }

    public function store(Request $request)
    {
        $rules = [
            'name'     => 'required|string|max:25|unique:teams,name',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ]);

        try {

            $role = new Team();
            $role->name = $request->name;
            $role->display_name = $request->display_name;
            $role->description = $request->description;

            if ($role->save()) {

                return response()->json([
                    'success'   => true,
                    'message'   => 'succes created Team',
                ]);
            } else {
                return response()->json([
                    'success'   => false,
                    'message'   => 'succes created Team',
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
            'name'  => 'required|string|max:25|unique:teams,name,' . $request->team_id,
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ]);

        try {
            if (!is_null($request->team_id)) {
                $role = Team::find($request->team_id);
                $role->name = $request->name;
                $role->display_name = $request->display_name;
                $role->description = $request->description;

                if ($role->save()) {
                    return response()->json([
                        'success'   => true,
                        'message'   => 'succes updated Team',
                    ]);
                } else {
                    return response()->json([
                        'success'   => false,
                        'message'   => 'failed updated Team',
                    ]);
                }
            } else {
                return response()->json([
                    'success'   => false,
                    'message'   => 'failed updated Team, please check params',
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

                if (Team::find($request->id)) {
                    Team::destroy($request->id);
                    return response()->json([
                        'success'   => true,
                        'message'   => 'succes delete Team',
                    ]);
                } else {
                    return response()->json([
                        'success'   => true,
                        'message'   => 'failed delete Team',
                    ]);
                }
            } else {
                return response()->json([
                    'success'   => false,
                    'message'   => 'failed delete Team, please check params',
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
