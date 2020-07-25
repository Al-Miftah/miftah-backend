<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\Request;

/**
 * @author Ibrahim Samad <naatogma@gmail.com>
 */
class OrganizationStatsController extends Controller
{
    /**
     * Display stats of an organization
     *
     * @param Organization $organization
     * @return \Illuminate\Http\Response
     */
    public function index(Organization $organization)
    {
        $data = $organization->loadCount(['donations', 'admins']);
        $donationSum = $organization->donationSum();
        return response()->json([
            'data' => [
                'admins_count' => (int)$data->admins_count,
                'donations_count' => (int)$data->donations_count,
                'donations_sum' => lower_denomination($donationSum),
            ]
        ]);
    }
}
