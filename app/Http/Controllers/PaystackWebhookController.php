<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Middleware\VerifyPaystackWebhookSignature;

/**
 * @author Ibrahim Samad <naatogma@gmail.com>
 */
class PaystackWebhookController extends Controller
{
    /**
     * Construct
     */
    public function __construct()
    {
        if (config('services.paystack.secret_key')) {
            $this->middleware(VerifyPaystackWebhookSignature::class);
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
        //Ignore any webhook event that's not triggered by our transactions
        if (!Str::contains($payload['data']['reference'], 'miftah-')) {
            info('Ignoring webhook event with reference: ' .$payload['data']['reference']);
            return;
        }
        $method = 'handle'.Str::studly(str_replace('.', '_', $payload['event']));
        if (method_exists($this, $method)) {
            return $this->{$method}($payload);
        }
        return $this->missingMethod();
    }

    /**
     * Responsd to successful charge event
     *
     * @param array $payload
     * @return void
     */
    public function handleChargeSuccess(array $payload)
    {
        $exists = Donation::where('transaction_reference', $payload['data']['reference'])->exists();
        if (!$exists) {
            $this->recordPayment($payload);
        }
        info('Handled successful charge. Ref: ' . $payload['data']['reference']);
    }

    /**
     * Respond to when payment request has been paid
     *
     * @param array $payload
     * @return void
     */
    public function handlePaymentrequestSuccess(array $payload)
    {
        info('Payment request success Ref: ' . $payload['data']['reference']);
    }

    /**
     * Respond to successful subscription creation
     *
     * @param array $payload
     * @return void
     */
    public function handleSubscriptionCreate(array $payload)
    {
        info('Subscription created Ref: ' . $payload['data']['reference']);
    }

    /**
     * Respond to when invoice is updated
     *
     * @param array $payload
     * @return void
     */
    public function handleInvoiceUpdate(array $payload)
    {
        info('Invoice updated Ref: ' . $payload['data']['reference']);
    }

    /**
     * Respond to a disable on user subscription
     *
     * @param array $payload
     * @return void
     */
    public function handleSubscriptionDisable(array $payload)
    {
        info('Subscription disabled Ref: ' . $payload['data']['reference']);
    }

    /**
     * Respond to failed invoice
     *
     * @param array $payload
     * @return void
     */
    public function handleInvoiceFailed(array $payload)
    {
        info('Invoice failed Ref: ' . $payload['data']['reference']);
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

    /**
     * Extract relevant data
     *
     * @param array $payload
     * @return array
     */
    public function recordPayment(array $payload)
    {
        $donation = new Donation;
        $donation->gateway = 'paystack';
        $donation->transaction_reference = $payload['data']['reference'];
        $donation->amount = $payload['data']['amount'] / 100;
        $donation->currency = $payload['data']['currency'];
        $donation->channel = $payload['data']['channel'];
        $donation->user_id = $payload['data']['metadata']['user_id'] ?? null;
        $donation->plan_id = $payload['data']['metadata']['plan_id'] ?? null;
        $donation->organization_id = $payload['data']['metadata']['organization_id'];
        $donation->payment_type = $payload['data']['metadata']['payment_type'];
        $donation->customer_code = $payload['data']['customer']['customer_code'] ?? null;
        $donation->save();
    }
}
