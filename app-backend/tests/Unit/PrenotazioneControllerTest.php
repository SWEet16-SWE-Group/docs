<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use DatabaseSeeder;
use DateTime;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;

require_once __DIR__ . '/../../database/seeds/DatabaseSeeder.php' ;

class PrenotazioneControllerTest extends TestCase
{


    use RefreshDatabase;
    /**
     * Prenotazione store
     *
     * @return void
     */
    public function test_store()
    {
        (new DatabaseSeeder())->run();
        Sanctum::actingAs(User::where('id', 1)->first());

        $data = [
            'ristoratore' => 1,
            'orario' => (new DateTime())->format('Y-m-d'),
            'numero_inviti' => 8,
        ];
        $response = $this->post('/api/crea-prenotazione/',$data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('prenotazioni',$data);
    }

    /**
     * Prenotazione updatestatus
     *
     * @return void
     */
    public function test_updatestatus()
    {
        (new DatabaseSeeder())->run();
        Sanctum::actingAs(User::where('id', 1)->first());

        $response = $this->put("/api/update-prenotazioni/1", ['stato' => 'Accettata']);

        $response->assertStatus(200);
        $this->assertDatabaseHas('prenotazioni',['id' => 1, 'stato' => 'Accettata']);
    }

    /**
     * Prenotazione updatestatus
     *
     * @return void
     */
    public function test_setdivisioneconto()
    {
        (new DatabaseSeeder())->run();
        Sanctum::actingAs(User::where('id', 1)->first());

        $data = ['divisione_conto' => 'Equo'];
        $response = $this->post("/api/set_divisioneconto/1", $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('prenotazioni',['id' => 1, ...$data]);
    }

    /**
     * Prenotazione show
     *
     * @return void
     */
    public function test_show()
    {
        (new DatabaseSeeder())->run();

        Sanctum::actingAs(User::where('id', 1)->first());
        $prenotazione = (object)['id' => 1];
        $response = $this->getJson('/api/prenotazioni/' . $prenotazione->id);

        $response->assertStatus(200);
        $response->assertJsonFragment(['id' => 1]);
    }

    /**
     * Prenotazione dashboard_c
     *
     * @return void
     */
    public function test_dashboard_c()
    {
        (new DatabaseSeeder())->run();

        Sanctum::actingAs(User::where('id', 1)->first());
        $prenotazione = (object)['id' => 1];
        $response = $this->getJson('/api/dashboard_c/' . $prenotazione->id);

        $response->assertStatus(200);
    }

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

    /**
     * Prenotazione dettagli
     *
     * @return void
     */
    public function test_prenotazione_dettagli()
    {
        (new DatabaseSeeder())->run();

        Sanctum::actingAs(User::where('id', 1)->first());
        $prenotazione = (object)['id' => 1];
        $response = $this->getJson('/api/prenotazione_dettagli/' . $prenotazione->id);

        $response->assertStatus(200);
    }

    /**
     * Prenotazione pagamenti ordinazioni
     *
     * @return void
     */
    public function test_prenotazione_pagamenti_ordinazioni()
    {
        (new DatabaseSeeder())->run();

        Sanctum::actingAs(User::where('id', 1)->first());
        $prenotazione = (object)['id' => 1];
        $response = $this->getJson('/api/pagamenti_ordinazioni/' . $prenotazione->id);

        $response->assertStatus(200);
    }

    /**
     * Prenotazione pagamenti inviti
     *
     * @return void
     */
    public function test_prenotazione_pagamenti_inviti()
    {
        (new DatabaseSeeder())->run();

        Sanctum::actingAs(User::where('id', 1)->first());
        $prenotazione = (object)['id' => 1];
        $response = $this->getJson('/api/pagamenti_inviti/' . $prenotazione->id);

        $response->assertStatus(200);
    }

    /**
     * ingredienti quantità
     *
     * @return void
     */
    public function test_ingredienti_quantita()
    {
        (new DatabaseSeeder())->run();
        Sanctum::actingAs(User::where('id', 1)->first());

        $prenotazione = (object)['id' => 1];
        $response = $this->getJson('/api/prenotazione_i/' . $prenotazione->id);

        $response->assertStatus(200);
    }
}
