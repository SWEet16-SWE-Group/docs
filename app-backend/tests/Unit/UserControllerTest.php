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

        $response = $this->post('/api/user/',$data);

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
        (new DatabaseSeeder())->run();
        $u = User::where('id', 1)->first();
        $oldpassword = $u->password;
        Sanctum::actingAs($u);

        $data = [
            'id' => 1,
            'password' => 'b',
        ];
        $response = $this->put('/api/userpassword',[...$data, 'password_confirmation' => $data['password']]);

        $response->assertStatus(204);
        $this->assertDatabaseHas('users',['id' => 1]);
        $this->assertDatabaseMissing('users',['id' => 1, 'password' => $oldpassword]);
    }

    /**
     * update mail
     *
     * @return void
     */
    public function test_update_mail()
    {
        (new DatabaseSeeder())->run();
        $u = User::where('id', 1)->first();
        Sanctum::actingAs($u);

        $data = [
            'id' => 1,
            'email' => 'b@b.com',
        ];
        $response = $this->put('/api/useremail',$data);

        $response->assertStatus(204);
        $this->assertDatabaseHas('users',$data);
    }

    /**
     * delete
     *
     * @return void
     */
    public function test_delete()
    {
        (new DatabaseSeeder())->run();
        $u = User::where('id', 1)->first();
        Sanctum::actingAs($u);

        $data = [
            'id' => 1,
        ];
        $response = $this->delete('/api/user',$data);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('users',$data);
    }
}
