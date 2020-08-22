<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Config\Repository as Config;

/**
 * @author Ibrahim Samad <naatogma@gmail.com>
 */
class VerifyWebhookSignature
{
    /**
     * The application instance.
     *
     * @var \Illuminate\Contracts\Foundation\Application
     */
    protected $app;
    /**
     * The configuration repository instance.
     *
     * @var \Illuminate\Contracts\Config\Repository
     */
    protected $config;
    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     * @param  \Illuminate\Contracts\Config\Repository  $config
     * @return void
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

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
        if (!$request->headers->has('X-Paystack-Signature')) 
            abort(403);

        // validate event do all at once to avoid timing attack
        if($request->header('X-Paystack-Signature') === $this->sign($request->getContent(), $this->config->get('services.paystack.secret_key'))) 
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
        return hash_hmac('sha256', $payload, $secret);
    }
}
