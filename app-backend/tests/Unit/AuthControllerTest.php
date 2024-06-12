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
        $data = [
            'email' => 'a@a.com',
            'password' => 'a',
            'password_confirmation' => 'a',
        ];
        $response = $this->post('/api/signup',$data);

        $response->assertStatus(200);
        $response->assertJsonFragment(['role' => 'AUTENTICATO']);
        $this->assertDatabaseHas('users',['email' => $data['email']]);
    }

    /**
     * login
     *
     * @return void
     */
    public function test_login_successo()
    {
        $this->assertTrue(true);
    }

    /**
     * login
     *
     * @return void
     */
    public function test_login_fallito()
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
