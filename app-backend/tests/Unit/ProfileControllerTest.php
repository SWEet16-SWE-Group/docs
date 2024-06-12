<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use DatabaseSeeder;

require_once __DIR__ . '/../../database/seeds/DatabaseSeeder.php' ;


class ProfileControllerTest extends TestCase
{

    use RefreshDatabase;

    /**
     * getall
     *
     * @return void
     */
    public function test_getall()
    {
        (new DatabaseSeeder())->run();
        Sanctum::actingAs(User::where('id',1)->first());

        $responce = $this->getJson('/api/profiles');
        $responce->assertStatus(201);
    }

    /**
     * select
     *
     * @return void
     */
    public function test_select()
    {
        $this->assertTrue(false);
    }
}
