<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Middleware\VerifyWebhookSignature;

class PaystackWebhookController extends Controller
{
    /**
     * Construct
     */
    public function __construct()
    {
        if (config('services.paystack.secret_key')) {
            $this->middleware(VerifyWebhookSignature::class);
        }
    }

    /**
     * Handle incoming webhook request
     *
     * @param Request $request
     * @return void
     */
    public function handleWebhook(Request $request)
    {
        $payload = json_decode($request->getContent(), true);
        info('Event just in: ' . $payload['event']); //TODO: Remove
        $method = 'handle'.Str::studly(str_replace('.', '_', $payload['event']));
        if (method_exists($this, $method)) {
            return $this->{$method}($payload);
        }
        return $this->missingMethod();
    }

    /**
     * Responsd to successful charge event
     *
     * @param [type] $payload
     * @return void
     */
    public function handleChargeSuccess($payload)
    {
        //
    }

    /**
     * Respond to when payment request has been paid
     *
     * @param [type] $payload
     * @return void
     */
    public function handlePaymentrequestSuccess($payload)
    {
        # code...
    }

    /**
     * Respond to successful subscription creation
     *
     * @param array $payload
     * @return void
     */
    public function handleSubscriptionCreate(array $payload)
    {
        //
    }

    /**
     * Respond to when invoice is updated
     *
     * @param array $payload
     * @return void
     */
    public function handleInvoiceUpdate(array $payload)
    {
        # code...
    }

    /**
     * Respond to a disable on user subscription
     *
     * @param array $payload
     * @return void
     */
    public function handleSubscriptionDisable(array $payload)
    {
        //
    }

    /**
     * Respond to failed invoice
     *
     * @param array $payload
     * @return void
     */
    public function handleInvoiceFailed(array $payload)
    {
        # code...
    }

    /**
     * Handle calls to missing methods on the controller
     *
     * @param array $parameters
     * @return \Symfony\Component\HttpFoundation
     */
    protected function missingMethod($parameters = [])
    {
        return new Response;
    }
}
