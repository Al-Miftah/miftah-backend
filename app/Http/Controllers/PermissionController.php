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
     * Assign permissions to a user
     *
     * @param Request $request
     * @param User $user
     * @return void
     */
    public function assign(Request $request, User $user)
    {
        //
    }
}
