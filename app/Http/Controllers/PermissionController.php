<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    
    /**
     * List all permissins
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        $permissions = Permission::distinct('name')->get(['id', 'name']);
        return response()->json([
            'data' => $permissions
        ]);
    }

    /**
     * Update user permissions list
     *
     * @param Request $request
     * @param User $user
     * @return void
     */
    public function update(Request $request, User $user)
    {
        $admin = auth('api')->user();
        abort_unless($admin->can('Update user permissions', 'api'), 403, 'You are not authorized to perform this action');
        $this->validate($request, [
            'permissions' => 'required|array',
            'permissions.*' => 'string'
        ]);
        $names = $request->input('permissions');
        //Assign permissions for both web and api guard
        $permissions = Permission::whereIn('name', $names)->get();
        $user->syncPermissions($permissions);

        return response()->json([
            'data' => [
                'error' => false,
                'message' => 'User permissions updated successfully'
            ]
        ]);
    }
}
