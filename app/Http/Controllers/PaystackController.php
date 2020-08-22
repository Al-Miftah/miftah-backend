<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;
use Yabacon\Paystack\Exception\ApiException;

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
        $plans = Plan::get(['id', 'name', 'paystack_plan_code', 'description']);
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

        try {
            $transaction = paystack()->transaction->verify([
                'reference' => $reference
            ]);
        } catch (ApiException $e) {
            //e->getResponseObject()
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ], 402);
        }
        paystack()->transaction->verify([
            'reference' => $reference
        ]);

        if ('success' == $transaction->data->status) {
            return response()->json([
                'data' => [
                    'error' => false,
                    'message' => 'Transaction verification successful'
                ]
            ]);
        }
    }
}
