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

        $clientData=$request->validated();
        $clientData=$clientData["clientData"];
         $cliente= Client::create(['nome'=>$clientData["nome"],
                                   'user'=>$clientData["account_id"]]);

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

public function update(Request $request) {


    if (Client::where('id',$request -> id) -> exists()) {
        $client= Client::find($request->id);
        $client->nome = is_null($request->nome) ? $client->nome : $request->nome;
        $client-> user = is_null($request->user) ? $client->user : $request->user;
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
