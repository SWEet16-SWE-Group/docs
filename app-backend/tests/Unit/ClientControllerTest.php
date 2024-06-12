<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use DatabaseSeeder;

require_once __DIR__ . '/../../database/seeds/DatabaseSeeder.php' ;


class ClientControllerTest extends TestCase
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

        $response = $this->getJson('/api/client/1');

        $response->assertStatus(200);
        $response->assertJsonFragment(['id' => 1]);
    }

    /**
     * store
     *
     * @return void
     */
    public function test_store()
    {
        (new DatabaseSeeder())->run();
        $data =[
            'user' => 1,
            'nome' => 'c',
            'allergie' => [
                1,
            ],
        ];
        $response = $this->post('/api/client',$data);

        unset($data['allergie']);

        $response->assertStatus(201);
        $this->assertDatabaseHas('clients',$data);
        $this->assertDatabaseHas('allergeni_client',['allergeni_id' => 1, 'client_id' => $response['cliente']['id']]);
    }

    /**
     * index
     *
     * @return void
     */
    public function test_index()
    {
        (new DatabaseSeeder())->run();

        $response = $this->getJson('/api/account/');

        $response->assertStatus(200);
    }

    /**
     * update
     *
     * @return void
     */
    public function test_update()
    {
        $this->assertTrue(true);
    }

    /**
     * destroy
     *
     * @return void
     */
    public function test_destroy()
    {
        $this->assertTrue(true);
    }
}
