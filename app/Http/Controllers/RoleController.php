<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $pageConfigs = ['pageHeader' => false,];

        $roles = Role::with("users")->get();
        $permissions = Permission::all();

        return view('live.roles.index', compact('pageConfigs', "roles", "permissions"));
    }

    public function store(Request $request)
    {
        return response()->json($request->all(), 200);
    }
}
