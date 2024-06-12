<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use DatabaseSeeder;

require_once __DIR__ . '/../../database/seeds/DatabaseSeeder.php' ;


class ProfileControllerTest extends TestCase
{

    use RefreshDatabase;

    /**
     * getall
     *
     * @return void
     */
    public function test_getall()
    {
        (new DatabaseSeeder())->run();
        Sanctum::actingAs(User::where('id',1)->first());

        $response = $this->post('/api/profiles',[]);
        $response->assertStatus(201);
    }

    /**
     * select cliente
     *
     * @return void
     */
    public function test_select_cliente()
    {
        (new DatabaseSeeder())->run();
        Sanctum::actingAs(User::where('id',1)->first());

        $data = [
            'id' => 1,
            'profileType' => 'Cliente',
        ];
        $response = $this->post('/api/selectprofile',$data);
        $response->assertStatus(200);
    }

    /**
     * select ristoratore
     *
     * @return void
     */
    public function test_select_ristoratore()
    {
        (new DatabaseSeeder())->run();
        Sanctum::actingAs(User::where('id',1)->first());

        $data = [
            'id' => 1,
            'profileType' => 'Ristoratore',
        ];
        $response = $this->post('/api/selectprofile',$data);
        $response->assertStatus(200);
    }

    /**
     * select sbagliato
     *
     * @return void
     */
    public function test_select_sbagliato()
    {
        (new DatabaseSeeder())->run();
        Sanctum::actingAs(User::where('id',1)->first());

        $data = [
            'id' => 1,
            'profileType' => 'aaaaaaaa',
        ];
        $response = $this->post('/api/selectprofile',$data);
        $response->assertStatus(422);
    }
}
