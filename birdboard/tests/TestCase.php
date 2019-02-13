<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function signIn($user = null)
    {
        $newUser = $this->actingAs(factory('App\User')->create());

        return $user ?: $newUser;
    }
}
