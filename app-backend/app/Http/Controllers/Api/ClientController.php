<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\ClientRequest;
use App\Models\Client;
use App\Models\Allergeni;


class ClientController extends Controller
{
    public function index() : Response {
        $client=Client::get()->all();
       return response($client);
    }

    public function show($id) {

        /** @var Client $client */
        $client = Client::where('id',$id)->first();
        if (!empty($client))
            {
                 return response()->json([
                     'id' => $client['id'],
                     'nome' => $client['nome'],
                     'user' => $client['user'],
                 ]);
                                                    }
            else {
                return response([
                    "notification" => "Cliente non trovato!",
                    'status' => "failure",
                ],404);
            }

}

    public function store(ClientRequest $request)  {

        $data= $request->validated();

         $cliente = Client::create(['nome'=>$data['nome'],
                                   'user'=>$data['user']]);

        if ($request -> allergie) {
            $allergies = $request->allergie;
            foreach($allergies as $key => $value) {
                $allergene=Allergeni::find($value);
                $cliente->allergie()->attach($allergene);
            }
        }

        return response([
            'notification' => "Profilo cliente creato con successo",
            'status' => "success"
        ],201);
}

public function update(ClientRequest $request) {

    $data = $request->validated();

    if (Client::where('id',$data -> id) -> exists()) {
        $client= Client::find($data->id);
        $client->nome = is_null($data->nome) ? $client->nome : $data->nome;
        $client-> user = is_null($data->user) ? $client->user : $data->user;
        $client->save();
        return response([
            'notification' => "Profilo cliente aggiornato con successo",
            'status' => "success"
        ],202);
    }
        else {
            return response([
                "notification" => "Errore nell'aggiornamento del cliente!",
                'status' => "failure",
        ],404);
        }
}

    public function destroy(string $id) {
        if (Client::where('id',$id)) {
            $client = Client::find($id);
            $client -> delete();
            return response([
                'notification' => "Profilo cliente eliminato con successo",
                'status' => "success"
            ],202);
        }
            else {
                return response([
                    "notification" => "Errore nell'eliminazione del cliente!",
                    'status' => "failure",
                ],404);
            }
    }
}
