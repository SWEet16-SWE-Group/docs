<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use DatabaseSeeder;

require_once __DIR__ . '/../../database/seeds/DatabaseSeeder.php' ;


class UserControllerTest extends TestCase
{
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
     * update password
     *
     * @return void
     */
    public function test_update_password()
    {
        $this->assertTrue(true);
    }

    /**
     * update mail
     *
     * @return void
     */
    public function test_update_mail()
    {
        $this->assertTrue(true);
    }

    /**
     * delete
     *
     * @return void
     */
    public function test_delete()
    {
        $this->assertTrue(true);
    }
}
