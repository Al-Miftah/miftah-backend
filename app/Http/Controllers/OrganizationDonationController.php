<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\Request;
use App\Http\Resources\DonationCollection;

/**
 * @author Ibrahim Samad <naatogma@gmai.com>
 */
class OrganizationDonationController extends Controller
{
    
    /**
     * List donations made for an organizations
     *
     * @param Request $request
     * @return DonationCollection
     */
    public function index(Request $request, Organization $organization)
    {
        $donations = $organization->donations()->paginate(30);
        return new DonationCollection($donations);
    }
}
