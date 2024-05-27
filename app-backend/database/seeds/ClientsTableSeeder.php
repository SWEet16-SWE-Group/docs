<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Client;

class ClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker=\Faker\Factory::create();

        for ($i=0; $i < 10; $i++) {
            Client::create([
                'nome' => $faker->name
            ]);
        }
    }
}
