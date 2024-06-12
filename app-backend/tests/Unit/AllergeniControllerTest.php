<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use DatabaseSeeder;
use DateTime;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;

require_once __DIR__ . '/../../database/seeds/DatabaseSeeder.php' ;

class AllergeniControllerTest extends TestCase
{


    use RefreshDatabase;
    /**
     * index
     *
     * @return void
     */
    public function test_index()
    {
        $response = $this->getJson("/api/allergeni");

        $response->assertStatus(200);
    }
}
