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

        $roleExists = Role::where("name", strtolower($request->role_name))->first();

        if ($roleExists) {
            return response()->json(["message" => "Rol zaten bulunmakta"], 404);
        }

        $createRole = Role::create([
            "title" => $request->role_name,
            "guard_name" => "web",
            "name" => strtolower($request->role_name)
        ]);

        if (!$createRole) {
            return response()->json(["message" => "Rol oluşturulurken hata oluştu"], 404);
        }

        $givePermissions = $createRole->givePermissionTo($request->permissions);

        if (!$givePermissions) {
            return response()->json(["message" => "Role yetki atanırken hata oluştu"], 404);
        }

        return response()->json(["message" => "Rol başarıyla oluştu", "role" => $createRole], 201);
    }

    public function detail($id)
    {
        $role = Role::with("permissions")->whereId($id)->first();

        return response()->json($role, 200);
    }

    public function update(Request $request, $id)
    {
        $role = Role::with("permissions")->whereId($id)->first();

        $updateRole = $role->update(["title" => $request->role_name, "name" => strtolower($request->role_name)]);

        if (!$updateRole) {
            return response()->json(["message" => "Rol güncellenirken hata oluştu"], 404);
        }

        $syncPermissions = $role->syncPermissions($request->permissions);

        if (!$syncPermissions) {
            return response()->json(["message" => "Rollere yetkiler atanırken hata oluştu"], 404);
        }

        return response()->json(["message" => "Rol ve yetkileri başarıyla güncellendi", "newRoleName" => $request->role_name], 200);
    }

    public function delete($id)
    {
        $role = Role::find($id);

        if (!$role) {
            return response()->json(["message" => "Rol bulunamadı"], 404);
        }

        $deleteRole = $role->delete();

        if (!$deleteRole) {
            return response()->json(["message" => "Rol silinirken hata oluştu"], 404);
        }

        return response()->json(["message" => "Rol başarıyla silindi"], 200);
    }
}
