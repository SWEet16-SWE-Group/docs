<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Pietanza;
use App\Models\User;
use App\Models\Ristoratore;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use DatabaseSeeder;

require_once __DIR__ . '/../../database/seeds/DatabaseSeeder.php' ;

class PietanzaControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $ristoratore;
    protected $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->ristoratore = Ristoratore::factory()->create(['user' => $this->user->id]);
        Sanctum::actingAs($this->user);
    }
    /** @test */
    public function it_can_index_ristoratore()
    {
        $pietanza1 = Pietanza::factory()->create(['ristoratore' => $this->ristoratore->id]);
        $pietanza2 = Pietanza::factory()->create(['ristoratore' => $this->ristoratore->id]);

        $response = $this->getJson("/api/pietanze/{$this->ristoratore->id}");

        $response->assertStatus(200)
                 ->assertJsonCount(2)
                 ->assertJsonFragment(['nome' => $pietanza1->nome])
                 ->assertJsonFragment(['nome' => $pietanza2->nome]);
    }
    /** @test */
    public function it_can_store()
    {
        $data = Pietanza::factory()->make(['ristoratore' => $this->ristoratore->id])->toArray();

        $response = $this->postJson('/api/pietanze', $data);

        $response->assertStatus(201)
                 ->assertJsonFragment(['nome' => $data['nome']]);

        $this->assertDatabaseHas('pietanze', ['nome' => $data['nome']]);
    }
    /** @test */
    public function it_can_show()
    {
        $pietanza = Pietanza::factory()->create(['ristoratore' => $this->ristoratore->id]);

        $response = $this->getJson("/api/pietanze/{$pietanza->id}");

        $response->assertStatus(200)
                 ->assertJsonFragment(['nome' => $pietanza->nome]);
    }
    /** @test */
    public function it_can_update()
    {
        $pietanza = Pietanza::factory()->create(['ristoratore' => $this->ristoratore->id]);
        $newData = Pietanza::factory()->make(['ristoratore' => $this->ristoratore->id])->toArray();

        $response = $this->putJson("/api/pietanze/{$pietanza->id}", $newData);

        $response->assertStatus(200)
                 ->assertJsonFragment(['nome' => $newData['nome']]);

        $this->assertDatabaseHas('pietanze', ['id' => $pietanza->id, 'nome' => $newData['nome']]);
    }
    /** @test */
    public function it_can_destroy()
    {
        $pietanza = Pietanza::factory()->create(['ristoratore' => $this->ristoratore->id]);

        $response = $this->deleteJson("/api/pietanze/{$pietanza->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('pietanze', ['id' => $pietanza->id]);
    }
    /** @test */
    public function it_cannot_update()
    {
        $invalidId = 9999;
        $newData = Pietanza::factory()->make(['ristoratore' => $this->ristoratore->id])->toArray();

        $response = $this->putJson("/api/pietanze/{$invalidId}", $newData);

        $response->assertStatus(404)
                 ->assertJson(['message' => 'Pietanza non trovata']);
    }
    /** @test */
    public function it_cannot_destroy()
    {
        $invalidId = 9999;

        $response = $this->deleteJson("/api/pietanze/{$invalidId}");

        $response->assertStatus(404)
                 ->assertJson(['message' => 'Pietanza non trovata']);
    }

    /**
     * dettagli
     *
     * @return void
     */
    public function test_dettagli()
    {
        //(new DatabaseSeeder())->run();
        //Sanctum::actingAs(User::where('id', 1)->first());
        $response = $this->getJson('/api/pietanza_dettagli/1');
        $response->assertStatus(200);
    }
}
