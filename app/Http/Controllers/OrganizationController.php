<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Organization;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrganization;
use App\Http\Requests\UpdateOrganization;
use App\Http\Resources\OrganizationCollection;
use App\Http\Resources\Detail\OrganizationResource;

/**
 * @author Ibrahim Samad <naatogma@gmail.com>
 */
class OrganizationController extends Controller
{
    /**
     * List all organizations
     *
     * @param Request $request
     * @return OrganizationCollection
     */
    public function index(Request $request)
    {
        $organizations = Organization::paginate(30);
        return new OrganizationCollection($organizations);
    }

    /**
     * Create a new Organization
     *
     * @param StoreOrganization $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrganization $request)
    {
        $input = $request->only(['name', 'phone_number', 'digital_address', 'about', 'creator_id']);
        $input['creator_id'] = $input['creator_id'] ?? auth('api')->id();
        $organization = Organization::create($input);
        //Add user to organization admins
        $user = User::find($input['creator_id']);
        $organization->admins()->attach($user->id);
        return response()->json([
            'data' => [
                'error' => false,
                'message' => 'Organization created successfully'
            ]
        ]);
    }

    /**
     * View detailed info of an organization
     *
     * @param Organization $organization
     * @return OrganizationResource
     */
    public function show(Organization $organization)
    {
        return new OrganizationResource($organization);
    }

    /**
     * Update info of an organization
     *
     * @param Request $request
     * @param Organization $organization
     * @return OrganizationResource
     */
    public function update(UpdateOrganization $request, Organization $organization)
    {
        $input = $request->only(['name', 'digital_address', 'about', 'phone_number', 'logo_url']);
        $organization->update($input);
        return new OrganizationResource($organization->fresh());
    }

    /**
     * Delete an organization
     *
     * @param Request $request
     * @param Organization $organization
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Organization $organization)
    {
        if ($request->input('permanent') == true) {
            $organization->forceDelete();
        }else {
            $organization->delete();
        }
        return response()->noContent(204);
    }
}
