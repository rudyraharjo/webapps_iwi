<?php

namespace Modules\HumanResource\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\HumanResource\Entities\Employee;
use Yajra\DataTables\DataTables;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            return DataTables::of(Employee::query())
                ->editColumn('created_at', function ($row) {
                    // return $row->created_at ? with(new Carbon($row->created_at))->diffForHumans() : '';
                    return $row->created_at ? with(new Carbon($row->created_at))->isoFormat('dddd, D MMMM Y') : '';
                })
                ->addColumn('tools', function ($row) {

                    $btn = '<button 
                        onclick="ModalAddEdit(this)"
                        data-cmd="edit" 
                        data-id="' . $row->id . '"
                        data-name="' . $row->name . '" 
                        data-nik="' . $row->nik . '" 
                        data-fullname="' . $row->fullname . '" 
                        data-action="' . route('user.update') . '" 
                        class="btn btn-sm btn-icon icon-left btn-danger">
                        <i class="far fa-edit"></i>
                    </button>';

                    $btn = $btn . "&nbsp;";

                    $btn = $btn . '<button 
                            onclick="ModalDeleteUser(this)"
                            data-id="' . $row->id . '" 
                            data-name="' . $row->name . '" 
                            data-nik="' . $row->nik . '" 
                            data-fullname="' . $row->fullname . '" 
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

        $teams = DB::table('teams')->get();

        return view('humanresource::employee.index', compact('teams'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('humanresource::employee.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('humanresource::employee.show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('humanresource::employee.edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
