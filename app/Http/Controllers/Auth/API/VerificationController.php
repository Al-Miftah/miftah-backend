<?php

namespace App\Http\Controllers\Auth\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\VerifiesEmails;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    //protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api')->only('resend');
        $this->middleware('signed.api')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    /**
     * Show the email verification notice.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        //
    }

    /**
     * Mark the authenticated user's email address as verified.
     *
     * Overriden
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function verify(Request $request)
    {
        $user = User::findOrFail($request->route('id'));
        if (! hash_equals((string) $request->route('id'), (string) $user->getKey())) {
            return view('auth.verify-error', [
                'message' => 'Unauthorized! ID mismatch'
            ]);
        }
        if (! hash_equals((string) $request->query('hash'), sha1($user->getEmailForVerification()))) {
            return view('auth.verify-error', [
                'message' => 'Unauthorized! Hash mismatch'
            ]);
        }
        if ($user->hasVerifiedEmail()) {
            return view('auth.verify-error', [
                'message' => 'Your email address has already been verified!'
            ]);
        }
        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }
        return view('auth.verify-success', [
            'message' => 'Your email address has been verified successfully!'
        ]);
    }

    /**
     * Resend the email verification notification.
     *
     * Overriden
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function resend(Request $request)
    {
        $user = $request->user();
        if ($user->hasVerifiedEmail()) {
            return response()->json([
                'data' => [
                    'error' => true,
                    'message' => 'User email has already been verified!'
                ]
            ], 401);
        }
        $user->sendEmailVerificationNotification();
        
        return response()->json([
            'data' => [
                'error' => false,
                'message'   => 'Verification email resent successfully!'
            ]
        ]);
    }
}
