<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Ristoratore;
use Laravel\Sanctum\Sanctum;
use DatabaseSeeder;

require_once __DIR__ . '/../../database/seeds/DatabaseSeeder.php' ;

class RistoratoreControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * index
     *
     * @return void
     */
    public function test_index()
    {
        (new DatabaseSeeder())->run();

        $response = $this->getJson('/api/ristoranti/');

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_list_all_ristoratori()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $ristoratore = Ristoratore::factory()->create(['user' => $user->id]);

        $response = $this->getJson('/api/ristoratori/' . $user->id);

        $response->assertStatus(200);
        $response->assertJsonFragment(['id' => $ristoratore->id]);
    }

    /** @test */
    public function it_can_create_a_ristoratore()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $data = [
            'user' => $user->id,
            'nome' => 'Ristoratore Test',
            'indirizzo' => 'Via Test 123',
            'cucina' => 'Italiana',
            'telefono' => '1234567890',
            'capienza' => 50,
            'orario' => '19:30 - 20:30'
        ];

        $response = $this->post('/api/crea-ristoratore', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('ristoratori', $data);
    }

    /** @test */
    public function it_can_show_a_single_ristoratore() {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $ristoratore = Ristoratore::factory()->create(['user' => $user->id]);

        $response = $this->get("/api/get-ristoratore/{$ristoratore->id}");

        $response->assertStatus(200);
        $response->assertJsonFragment(['id' => $ristoratore->id]);
    }

    /** @test */
    public function it_can_update_a_ristoratore()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $ristoratore = Ristoratore::factory()->create(['user' => $user->id]);

        $data = [
            'nome' => 'Ristorante Modificato',
            'indirizzo' => 'Via Modificato 456',
            'telefono' => '1234567890',
            'capienza' => 100,
            'orario' => '18:00 - 23:00'
        ];

        $response = $this->put("/api/modifica-ristoratore/{$ristoratore->id}", $data);

        $response->assertStatus(202);
        $this->assertDatabaseHas('ristoratori', $data);
    }

    /** @test */
    public function it_can_delete_a_ristoratore()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $ristoratore = Ristoratore::factory()->create(['user' => $user->id]);

        $response = $this->delete("/api/elimina-ristoratore/{$ristoratore->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('ristoratori', ['id' => $ristoratore->id]);
    }

    /** @test */
    public function it_can_list_ristoratori_by_user()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $ristoratore = Ristoratore::factory()->create(['user' => $user->id]);

        $response = $this->get("/api/ristoratori/{$user->id}");

        $response->assertStatus(200);
        $response->assertJsonFragment(['id' => $ristoratore->id]);
    }

    /** @test */
    public function it_requires_authentication()
    {
        $response = $this->post('/api/crea-ristoratore', []);
        $response->assertStatus(500);
    }

    /** @test */
    public function it_returns_not_found_for_non_existent_ristoratore()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->get('/api/get-ristoratore/999');

        $response->assertStatus(404);
    }
}
