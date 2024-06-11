<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Prenotazione;
use App\Models\Ristoratore;
use App\Models\User;
use DatabaseSeeder;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use DB;

require_once __DIR__ . '/../../database/seeds/DatabaseSeeder.php' ;

class PrenotazioneControllerTest extends TestCase
{


    use RefreshDatabase;

    /**
     * Prenotazione cliente
     *
     * @return void
     */
    public function test_prenotazione_c()
    {
        (new DatabaseSeeder())->run();

        Sanctum::actingAs(User::where('id', 1)->first());
        $prenotazione = (object)['id' => 1];
        $response = $this->getJson('/api/prenotazione_c/' . $prenotazione->id);

        $response->assertStatus(200);
    }

    /**
     * Prenotazione conto
     *
     * @return void
     */
    public function test_prenotazione_conto()
    {
        (new DatabaseSeeder())->run();

        Sanctum::actingAs(User::where('id', 1)->first());
        $prenotazione = (object)['id' => 1];
        $response = $this->getJson('/api/prenotazione_conto/' . $prenotazione->id);

        $response->assertStatus(200);
    }
}
