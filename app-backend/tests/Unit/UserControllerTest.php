<?php

namespace Tests\Unit;

use App\Http\Middleware\UserIsAuthenticated;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use DatabaseSeeder;

require_once __DIR__ . '/../../database/seeds/DatabaseSeeder.php' ;


class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * show
     *
     * @return void
     */
    public function test_show()
    {
        (new DatabaseSeeder())->run();
        $u = User::where('id', 1)->first();
        Sanctum::actingAs($u);

        $data = [
            'id' => 1,
        ];

        $response = (new UserIsAuthenticated())->handle(Request::create('/api/user/','POST',$data),fn () => null);

        $response->assertStatus(200);
        $response->assertJsonFragment($data);
    }

    /**
     * update password
     *
     * @return void
     */
    public function test_update_password()
    {
        $this->assertTrue(false);
    }

    /**
     * update mail
     *
     * @return void
     */
    public function test_update_mail()
    {
        $this->assertTrue(false);
    }

    /**
     * delete
     *
     * @return void
     */
    public function test_delete()
    {
        $this->assertTrue(false);
    }
}
