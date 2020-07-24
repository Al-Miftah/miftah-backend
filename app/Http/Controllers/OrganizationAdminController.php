<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\Request;
use App\Http\Resources\UserCollection;

/**
 * @author Ibrahim Samad <naatogma@gmail.com>
 */
class OrganizationAdminController extends Controller
{
    /**
     * List admins of an organization
     *
     * @param Request $request
     * @return void
     */
    public function index(Organization $organization)
    {
        $admins = $organization->admins;
        return new UserCollection($admins);
    }

    /**
     * Grant admin access of an organization to a user
     *
     * @param Request $request
     * @param Organization $organization
     * @return void
     */
    public function store(Request $request, Organization $organization)
    {
        $ids = $request->input('users');
        $organization->admins()->syncWithoutDetaching($ids);
        return response()->json([
            'error' => false,
            'message' => "User now admin of $organization->name"
        ]);
    }

    /**
     * Revoke admin access of a user to an organization
     *
     * @param Request $request
     * @param Organization $organization
     * @return void
     */
    public function destroy(Request $request, Organization $organization)
    {
        $ids = $request->input('users');
        $organization->admins()->detach($ids);
        return response()->noContent(204);
    }
}
