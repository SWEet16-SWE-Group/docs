<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use DatabaseSeeder;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;

require_once __DIR__ . '/../../database/seeds/DatabaseSeeder.php' ;

class OrdinazioniTest extends TestCase
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

        $ordinazione = [
            'invito' => 1,
            'pietanza' => 2,
        ];
        $aggiunte = [
            ['ingrediente' => 7],
        ];
        $rimozioni = [
            ['ingrediente' => 1],
        ];
        $response = $this->post('/api/crea-ordinazione/',[...$ordinazione, 'aggiunte' => $aggiunte, 'rimozioni' => $rimozioni]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('ordinazioni',$ordinazione);
        $this->assertDatabaseHas('dettagliordinazione',[...($aggiunte[0]), 'dettaglio' => '+']);
        $this->assertDatabaseHas('dettagliordinazione',[...($rimozioni[0]), 'dettaglio' => '-']);
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

        $response = $this->post('/api/paga_ordinazione/1');

        $response->assertStatus(200);
        $this->assertDatabaseHas('ordinazioni',['id' => 1, 'pagamento' => 'PAGATO',]);
    }
}
