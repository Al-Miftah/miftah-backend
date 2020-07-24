<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Passport\Passport;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function authenticate($user = null, $guard = 'api')
    {
        $user = $user ?? factory('App\Models\User')->create();
        Passport::actingAs($user, [], $guard);
        return $user;
    }
}
