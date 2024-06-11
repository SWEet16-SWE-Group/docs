<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use DatabaseSeeder;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;

require_once __DIR__ . '/../../database/seeds/DatabaseSeeder.php' ;

class InvitiTest extends TestCase
{


    use RefreshDatabase;
    /**
     * crea
     *
     * @return void
     */
    public function test_crea()
    {
        (new DatabaseSeeder())->run();
        Sanctum::actingAs(User::where('id', 1)->first());

        $data = [
            'prenotazione' => 1,
            'cliente' => 2,
        ];
        $response = $this->post('/api/crea-invito/',$data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('inviti',$data);
    }

    /**
     * paga
     *
     * @return void
     */
    public function test_paga()
    {
        (new DatabaseSeeder())->run();
        Sanctum::actingAs(User::where('id', 1)->first());

        $response = $this->post('/api/paga_invito/1');

        $response->assertStatus(200);
        $this->assertDatabaseHas('inviti',['id' => 1, 'pagamento' => 'PAGATO',]);
    }

    /**
     * get
     *
     * @return void
     */
    public function test_get()
    {
        (new DatabaseSeeder())->run();
        Sanctum::actingAs(User::where('id', 1)->first());

        $response = $this->getJson('/api/get-invito-by-prenotazione-cliente/1/1');

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'id' => 1,
            'prenotazione' => 1,
            'cliente' => 1,
            'pagamento' => 'NON PAGATO',
        ]);
    }
}
