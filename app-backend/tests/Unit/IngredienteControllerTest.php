<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Ristoratore;
use App\Models\Ingrediente;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IngredienteControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $ristoratore;
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->ristoratore = Ristoratore::factory()->create(['user' => $this->user->id]);
        Sanctum::actingAs($this->user);
    }
    /** @test */
    public function it_can_index()
    {
        $ingredienti = Ingrediente::factory()->count(3)->create(['ristoratore' => $this->ristoratore->id]);

        $response = $this->getJson("/api/ingredienti/{$this->ristoratore->id}");

        $response->assertStatus(200);
        $response->assertJsonCount(3);
    }
    /** @test */
    public function it_can_show()
    {
        $ingrediente = Ingrediente::factory()->create(['ristoratore' => $this->ristoratore->id]);

        $response = $this->getJson("/api/ingredienti/{$ingrediente->id}");

        $response->assertStatus(200);
        $response->assertJsonFragment(['id' => $ingrediente->id]);
    }
    /** @test */
    public function it_can_store()
    {
        $data = Ingrediente::factory()->make(['ristoratore' => $this->ristoratore->id])->toArray();

        $response = $this->postJson('/api/ingredienti', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('ingredienti', $data);
    }
    /** @test */
    public function it_can_update()
    {
        $ingrediente = Ingrediente::factory()->create(['ristoratore' => $this->ristoratore->id]);
        $data = Ingrediente::factory()->make()->toArray();

        $response = $this->putJson("/api/ingredienti/{$ingrediente->id}", $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('ingredienti', $data);
    }
    /** @test */
    public function it_cannot_update()
    {
        $data = Ingrediente::factory()->make()->toArray();

        $response = $this->putJson("/api/ingredienti/999", $data);

        $response->assertStatus(404);
        $response->assertJson(['message' => 'Ingrediente non trovato']);
    }
    /** @test */
    public function it_can_destroy()
    {
        $ingrediente = Ingrediente::factory()->create(['ristoratore' => $this->ristoratore->id]);

        $response = $this->deleteJson("/api/ingredienti/{$ingrediente->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('ingredienti', ['id' => $ingrediente->id]);
    }
    /** @test */
    public function it_cannot_destroy()
    {
        $response = $this->deleteJson("/api/ingredienti/999");

        $response->assertStatus(404);
        $response->assertJson(['message' => 'Ingrediente non trovato']);
    }
}
