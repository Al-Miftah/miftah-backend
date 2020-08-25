<?php

namespace App\Http\Middleware;

use Closure;

/**
 * @author Ibrahim Samad <naatogma@gmail.com>
 */
class VerifyPaystackWebhookSignature
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //Valid IPs from Paystack: 52.31.139.75, 52.49.173.169, 52.214.14.220
        if (!$request->headers->has('x-paystack-signature')) 
            abort(403);

        // validate event do all at once to avoid timing attack
        if($request->header('x-paystack-signature') !== $this->sign($request->getContent(), config('services.paystack.secret_key')))   
            abort(403);

        return $next($request);
    }

    /**
     * Sign request
     *
     * @param string $payload
     * @param string $secret
     * @return string
     */
    private function sign($payload, $secret)
    {
        return hash_hmac('sha512', $payload, $secret);
    }
}
