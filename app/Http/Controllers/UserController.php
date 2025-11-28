<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Resources\UserResource;
use App\Http\Controllers\Controller;

use Inertia\Response;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

use App\Http\Resources\RoleResource;
use App\Http\Resources\PermissionResource;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Illuminate\Support\Facades\DB;

use App\Models\Notification;



class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $users = User::with(['roles', 'permissions', 'userInfor'])->paginate(10);
        $users = User::with(['roles', 'permissions', 'userInfor'])->get();

        return Inertia::render('Admin/Users/UserIndex', [
            'notifications' => Notification::get(),
            'contnitification' => Notification::count(),
            'users' => UserResource::collection($users),
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Users/Create',[
            'roles'=> RoleResource::collection(Role::all()),
            'permissions' =>PermissionResource::collection(Permission::all())
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request):RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $user->syncRoles($request->input('roles.*.name'));
        $user->syncPermissions($request->input('permissions.*.name'));

        return to_route('users.index')->with('success','¡El usuario ha sido creado con éxito!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user):Response
    {
        $user->load(['roles','permissions']);
        return Inertia::render('Admin/Users/Edit',[
            'user'=> new UserResource($user),
            'roles'=> RoleResource::collection(Role::all()),
            'permissions' =>PermissionResource::collection(Permission::all())
            ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255',
            'roles' => ['sometimes','array'],
            'permissions' => ['sometimes','array']

        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        $user->syncRoles($request->input('roles.*.name'));
        $user->syncPermissions($request->input('permissions.*.name'));

        return to_route('users.index')->with('success','¡El usuario ha sido actualizado con éxito!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        DB::transaction(function () use ($user) {
            // Set related addresses' user_id to NULL
            $user->user_address()->update(['user_id' => NULL]);
            // Delete the user
            $user->delete();
        });

        return to_route('users.index')->with('dsuccess','¡La información del usuario ha sido eliminada con éxito!');;
    }
}
