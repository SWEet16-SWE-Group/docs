<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use DatabaseSeeder;
use DateTime;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;

require_once __DIR__ . '/../../database/seeds/DatabaseSeeder.php' ;

class NotificheControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * notifiche cliente
     *
     * @return void
     */
    public function test_notifiche_cliente()
    {
        (new DatabaseSeeder())->run();
        Sanctum::actingAs(User::where('id', 1)->first());

        $response = $this->getJson('/api/notifiche_info/cliente/1');

        $response->assertStatus(200);
    }

    /**
     * notifiche ristoratore
     *
     * @return void
     */
    public function test_notifiche_ristoratore()
    {
        (new DatabaseSeeder())->run();
        Sanctum::actingAs(User::where('id', 1)->first());

        $response = $this->getJson('/api/notifiche_info/ristoratore/1');

        $response->assertStatus(200);
    }

    /**
     * count cliente
     *
     * @return void
     */
    public function test_count_cliente()
    {
        (new DatabaseSeeder())->run();
        Sanctum::actingAs(User::where('id', 1)->first());

        $response = $this->getJson('/api/notifiche_count/cliente/1');

        $response->assertStatus(200);
    }

    /**
     * count ristoratore
     *
     * @return void
     */
    public function test_count_ristoratore()
    {
        (new DatabaseSeeder())->run();
        Sanctum::actingAs(User::where('id', 1)->first());

        $response = $this->getJson('/api/notifiche_count/ristoratore/1');

        $response->assertStatus(200);
    }
}
