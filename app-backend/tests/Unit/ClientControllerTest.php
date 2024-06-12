<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use DatabaseSeeder;

require_once __DIR__ . '/../../database/seeds/DatabaseSeeder.php' ;


class ClientControllerTest extends TestCase
{

    use RefreshDatabase;

    /**
     * show
     *
     * @return void
     */
    public function test_show()
    {
        $this->assertTrue(true);
    }

    /**
     * store
     *
     * @return void
     */
    public function test_store()
    {
        $this->assertTrue(true);
    }

    /**
     * index
     *
     * @return void
     */
    public function test_index()
    {
        (new DatabaseSeeder())->run();

        $response = $this->getJson('/api/account/');

        $response->assertStatus(200);
    }

    /**
     * update
     *
     * @return void
     */
    public function test_update()
    {
        $this->assertTrue(true);
    }

    /**
     * destroy
     *
     * @return void
     */
    public function test_destroy()
    {
        $this->assertTrue(true);
    }
}
