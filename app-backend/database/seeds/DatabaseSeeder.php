<?php

use Illuminate\Database\Seeder;
use DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        DB::insert("insert into users(id, email, password) values(1, 'a@a.com','\$2y\$10\$k99Wav18aOivqAy1JJRN9.jJqsbcxdX/.H2DUgnKop71j/Lc26J1W');");
        DB::insert("insert into clients(id, user, nome) values(1,1,'a');");
        DB::insert("insert into clients(id, user, nome) values(2,1,'b');");
        DB::insert("insert into ristoratori(id, user, nome, indirizzo, telefono, capienza, orario, updated_at, created_at) values(1,1,'apizzaaaaa', 'a', '4444444444', 44, '19:30 - 20:30', CURRENT_TIME, CURRENT_TIME);");
        DB::insert("insert into allergeni(id,nome) values (1,'glutine');");
        DB::insert("insert into ingredienti(id, ristoratore, nome) values (1,1,'pasta');");
        DB::insert("insert into allergeniingredienti(ingrediente,allergene) values(1,1);");
        DB::insert("insert into ingredienti(id, ristoratore, nome) values (2,1,'pomodoro');");
        DB::insert("insert into ingredienti(id, ristoratore, nome) values (3,1,'mozzarella');");
        DB::insert("insert into ingredienti(id, ristoratore, nome) values (4,1,'patatine');");
        DB::insert("insert into ingredienti(id, ristoratore, nome) values (5,1,'brie');");
        DB::insert("insert into ingredienti(id, ristoratore, nome) values (6,1,'chiodini');");
        DB::insert("insert into ingredienti(id, ristoratore, nome) values (7,1,'prosciutto');");
        DB::insert("insert into ingredienti(id, ristoratore, nome) values (8,1,'ananas');");
        DB::insert("insert into pietanze(id,ristoratore, nome) values (1,1, 'pizza margherita');");
        DB::insert("insert into pietanze(id,ristoratore, nome) values (2,1, 'pizza patatosa');");
        DB::insert("insert into pietanze(id,ristoratore, nome) values (3,1, 'pizza hawaiiana');");
        DB::insert("insert into pietanze(id,ristoratore, nome) values (4,1, 'pizza funghi');");
        DB::insert("insert into ricette(pietanza, ingrediente) values (1,1);");
        DB::insert("insert into ricette(pietanza, ingrediente) values (1,2);");
        DB::insert("insert into ricette(pietanza, ingrediente) values (1,3);");
        DB::insert("insert into ricette(pietanza, ingrediente) values (2,1);");
        DB::insert("insert into ricette(pietanza, ingrediente) values (2,2);");
        DB::insert("insert into ricette(pietanza, ingrediente) values (2,3);");
        DB::insert("insert into ricette(pietanza, ingrediente) values (2,4);");
        DB::insert("insert into ricette(pietanza, ingrediente) values (3,1);");
        DB::insert("insert into ricette(pietanza, ingrediente) values (3,2);");
        DB::insert("insert into ricette(pietanza, ingrediente) values (3,3);");
        DB::insert("insert into ricette(pietanza, ingrediente) values (3,7);");
        DB::insert("insert into ricette(pietanza, ingrediente) values (3,8);");
        DB::insert("insert into ricette(pietanza, ingrediente) values (4,1);");
        DB::insert("insert into ricette(pietanza, ingrediente) values (4,2);");
        DB::insert("insert into ricette(pietanza, ingrediente) values (4,3);");
        DB::insert("insert into ricette(pietanza, ingrediente) values (4,5);");
        DB::insert("insert into ricette(pietanza, ingrediente) values (4,6);");
        DB::insert("insert into prenotazioni(id, ristoratore, orario, numero_inviti) values(1, 1, '2024-06-28', 8);");
        DB::insert("insert into inviti(id, prenotazione, cliente) values(1, 1, 1);");
        DB::insert("insert into ordinazioni(id, invito, pietanza) values(1, 1, 3);");
    }
}
