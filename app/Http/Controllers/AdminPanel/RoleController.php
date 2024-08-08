<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminPanel\RoleRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:View Roles|Add Role|Edit Role|Delete Role', ['only' => ['index', 'store']]);
        $this->middleware('permission:Create Roles', ['only' => ['create', 'store']]);
        $this->middleware('permission:Update Roles', ['only' => ['edit', 'update']]);
        $this->middleware('permission:Delete Roles', ['only' => ['destroy']]);
    }
    public function index()
    {
        $roles = Role::all();
        return view('AdminPanel.roles.index', get_defined_vars());
    }

    public function create()
    {
        $permessions = Permission::all();
        return view('AdminPanel.roles.create', get_defined_vars());
    }

    public function store(RoleRequest $request)
    {
        $request['permessions'] = array_diff($request->permessions, ['all']);
        $role = Role::create(['name' => $request->input('name'), 'guard_name' => 'web']);

        $role->syncPermissions($request->input('permessions'));

        return redirect('/role')->with('success', __('lang.created'));
    }

    public function edit($id)
    {
        if ($id == 1 && !auth()->user()->hasRole('superadmin')) {
            abort(404);
        }
        $permessions = Permission::all();
        $role = Role::findOrFail($id);
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();
        return view('AdminPanel.roles.edit', get_defined_vars());
    }

    public function update(RoleRequest $request)
    {
        $request['permessions'] = array_diff($request->permessions, ['all']);
        $role = Role::FindOrFail($request->id);
        $role->update(['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permessions'));
        return redirect('/role')->with('success', __('lang.updated'));
    }

    public function destroy($id)
    {
        if ($id == 1) {
            abort(404);
        }
        $role = Role::findOrFail($id);
        $role->delete();
        return redirect('/role')->with('error_message', __('lang.deleted'));
    }
}
