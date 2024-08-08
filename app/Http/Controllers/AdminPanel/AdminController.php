<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminPanel\AdminCreateRequest;
use App\Http\Requests\AdminPanel\AdminUpdateRequest;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:View Admins|Add Admin|Edit Admin|Delete Admin', ['only' => ['index', 'store']]);
        $this->middleware('permission:Create Admins', ['only' => ['create', 'store']]);
        $this->middleware('permission:Edit Admins', ['only' => ['edit', 'update']]);
        $this->middleware('permission:Delete Admins', ['only' => ['destroy']]);
    }

    public function index()
    {
        $admins = User::all();
        return view('AdminPanel.admins.index', get_defined_vars());
    }

    public function create()
    {
        $roles = Role::where('id', '!=', 1)->get();
        return view('AdminPanel.admins.create', get_defined_vars());
    }

    public function store(AdminCreateRequest  $request)
    {
        try {
            $admin = User::create($request->input());
            $admin->assignRole($request->input('role'));
            return redirect()->route('admins.index')->with('success', __('lang.created'));
        } catch (\Exception $ex) {
            return redirect()->back()->with('warning', __('lang.warning'));
        }
    }

    public function edit($id)
    {
        if ($id == 1 && !auth()->user()->hasRole('superadmin')) {
            abort(404);
        }
        $roles = Role::where('id', '!=', 1)->get();
        $admin = User::findOrFail($id);
        return view('AdminPanel.admins.edit', get_defined_vars());
    }

    public function update(AdminUpdateRequest $request, $id)
    {
        try {
            $admin = User::findOrFail($id);
            if ($admin->id == 1 && !auth()->user()->hasRole('superadmin')) {
                abort(404);
            }
            $request['password'] = $request->password ?? $admin->password;
            $admin->update($request->input());
            $admin->syncRoles($request->role);
            return redirect()->route('admins.index')->with('success', __('lang.updated'));
        } catch (\Exception $ex) {
            return redirect()->back()->with('warning', __('lang.warning'));
        }
    }

    public function destroy($id)
    {
        if ($id != 1) {
            User::findOrFail($id)->delete();
            return redirect()->back()->with('error_message', __('lang.deleted'));
        } else {
            return redirect()->back()->with('warning', __('lang.warning'));
        }
    }
}
