<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use DatabaseSeeder;

require_once __DIR__ . '/../../database/seeds/DatabaseSeeder.php' ;


class AuthControllerTest extends TestCase
{

    use RefreshDatabase;

    /**
     * signup
     *
     * @return void
     */
    public function test_signup()
    {
        $this->assertTrue(true);
    }

    /**
     * login
     *
     * @return void
     */
    public function test_login()
    {
        $this->assertTrue(true);
    }

    /**
     * logout
     *
     * @return void
     */
    public function test_logout()
    {
        $this->assertTrue(true);
    }
}
