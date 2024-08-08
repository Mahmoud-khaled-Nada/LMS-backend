<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminPanel\PermissionRequest;
use Spatie\Permission\Models\Permission;


class PermessionController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (auth()->user()->hasRole('superadmin')) {
                return $next($request);
            }
            abort(404);
        });
    }


    public function index()
    {
        $permessions = Permission::all();
        return view('AdminPanel.permessions.index', get_defined_vars());
    }


    public function create()
    {
        return view('AdminPanel.permessions.create');
    }


    public function store(PermissionRequest $request)
    {
        try {
            $request['guard_name'] = 'web';
            Permission::create($request->input());
            return redirect()->route('permessions.index')->with('success', __('lang.created'));
        } catch (\Exception $ex) {
            return redirect()->back()->with('warning', __('lang.warning'));
        }
    }


    // public function show($id)
    // {
    //     //
    // }


    public function edit($id)
    {
        $permession = Permission::findOrFail($id);
        return view('AdminPanel.permessions.edit', get_defined_vars());
    }


    public function update(PermissionRequest $request, $id)
    {
        try {
            Permission::findOrFail($request->id)->update($request->input());
            return redirect()->route('permessions.index')->with('success', __('lang.created'));
        } catch (\Exception $ex) {
            return redirect()->back()->with('warning', __('lang.warning'));
        }
    }


    public function destroy($id)
    {
        Permission::findOrFail($id)->delete();
        return redirect()->back()->with('error_message', __('lang.deleted'));
    }
}
