<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;

/**
 * @author Ibrahim Samad <naatogma@gmail.com>
 */
class PaystackController extends Controller
{
    /**
     * List plans for checkout
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function getPlans(Request $request)
    {
        $plans = Plan::get(['id', 'name', 'plan_code', 'description']);
        return response()->json([
            'data' => $plans
        ]);
    }

    /**
     * Verify a transaction by reference ID
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function verifyTransaction(Request $request)
    {
        $reference = $request->input('reference');
        if (!$reference) {
            return response()->json([
                'data' => [
                    'error' => true,
                    'message' => 'Provide a transaction reference'
                ]
            ]);
        }

        //
    }
}
