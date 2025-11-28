<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\RoleResource;
use App\Http\Resources\PermissionResource;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\CreateRoleRequest;


use App\Models\Notification;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {

        return Inertia::render('Admin/Roles/RoleIndex',[
            'notifications' =>Notification::get(),
            'contnitification' =>Notification::count(),
            'roles' =>RoleResource::collection(Role::all())

        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create():Response
    {

        return Inertia::render('Admin/Roles/Create',[

            'permissions' =>PermissionResource::collection(Permission::all())

            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRoleRequest $request)
    {
        $role = Role::create(['name'=>$request->name]);
        if($request->has('permissions')){
            $role->syncPermissions($request->input('permissions.*.name'));
        }
        return to_route('roles.index')->with('success','¡El rol ha sido creado con éxito!');
    }

    /**
     * Display the specified resource.
     */
    public function show(none $none)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $role =Role::findByID($id);
        $role->load('permissions');
        return Inertia::render("Admin/Roles/Edit",[
        'role' => new RoleResource($role),
        'permissions' =>PermissionResource::collection(Permission::all())
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CreateRoleRequest $request, Role $role)
    {
        $role -> update([
            'name' => $request->name
        ]);
        $role->syncPermissions($request->input('permissions.*.name'));
        return to_route('roles.index')->with('success','¡La información del rol ha sido actualizada con éxito!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = Role::findByID($id);
        $role->delete();
        return back()->with('dsuccess','បានលុបព័ត៌មានតួនាទីជោគជ័យ!');

    }
}
