<?php

namespace App\Http\Controllers;

use App\Http\Resources\RoleCollection;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    
    /**
     * List user roles
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        return new RoleCollection(Role::get());
    }

    /**
     * Update user roles list
     *
     * @param Request $request
     * @param User $user
     * @return void
     */
    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'roles' => 'required|array',
            'roles.*' => 'string'
        ]);
        $admin = auth('api')->user();
        abort_unless($admin->can('Update user permissions'), 403, 'You are not authorized to perform this action');
        $names =  $request->input('roles');
        //Assign for both guards
        $roles = Role::whereIn('name', $names)->get();
        $user->syncRoles($roles);
    }
}
