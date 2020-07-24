<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use Illuminate\Http\Request;
use App\Http\Requests\StoreDonation;
use App\Http\Resources\DonationCollection;
use App\Http\Resources\Detail\DonationResource;

/**
 * @author Ibrahim Samad <naatogma@gmail.com>
 */
class DonationController extends Controller
{
    /**
     * List all donations
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        $filters = $request->only(['gateway', 'channel', 'status', 'transaction_reference']);
        $donations = Donation::where($filters)->paginate(30);
        return new DonationCollection($donations);
    }

    /**
     * Create a new donation
     *
     * @param StoreDonation $request
     * @return void
     */
    public function store(StoreDonation $request)
    {
        $input = $request->only(['transaction_reference', 'amount', 'gateway', 'channel', 'currency', 'additional_information', 'organization_id', 'user_id']);
        Donation::create($input);
        return response()->json([
            'error' => false,
            'message' => 'Donation recorded successfully'
        ]);
    }

    /**
     * View details of a donation
     *
     * @param Donation $donation
     * @return void
     */
    public function show(Donation $donation)
    {
        $item = $donation->load(['organization', 'donor']);
        return new DonationResource($item);
    }

    /**
     * Delete a donation
     *
     * @param Request $request
     * @param Donation $donation
     * @return void
     */
    public function destroy(Request$request, Donation $donation)
    {
        if ($request->input('permanent') == true) {
            $donation->forceDelete();
        }else {
            $donation->delete();
        }
        return response()->noContent(204);
    }
}
