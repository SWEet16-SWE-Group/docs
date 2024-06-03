<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Ristoratore;
use App\Models\User;

class RistoratoreTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_ristoratore()
    {
        $user = User::factory()->create();
        
        Ristoratore::create([
            'user' => $user->id,
            'nome' => 'Ristorante Uno',
            'indirizzo' => 'Indirizzo Uno',
            'telefono' => '1234567890',
            'capienza' => 50,
            'orario' => '19:30 - 20:30'
        ]);

        $this->assertDatabaseHas('ristoratori', [
            'user' => $user->id,
            'nome' => 'Ristorante Uno',
            'indirizzo' => 'Indirizzo Uno',
            'telefono' => '1234567890',
            'capienza' => 50,
            'orario' => '19:30 - 20:30'
        ]);
    }

    /** @test */
    public function it_belongs_to_a_user()
    {
        $user = User::factory()->create();

        $ristoratore = Ristoratore::create([
            'user' => $user->id,
            'nome' => 'Ristorante Uno',
            'indirizzo' => 'Indirizzo Uno',
            'telefono' => '1234567890',
            'capienza' => 50,
            'orario' => '19:30 - 20:30'
        ]);

        $this->assertEquals($ristoratore->user, $user->id);
    }
}
