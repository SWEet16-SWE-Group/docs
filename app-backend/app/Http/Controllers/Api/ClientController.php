<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateClientRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\ClientRequest;
use App\Models\Client;
use App\Models\Allergeni;


class ClientController extends Controller
{
    public function index() {
        $client=Client::get()->all();
       return response()->json($client,200);
    }

    public function show($id) {
        /** @var Client $client */
        $client = Client::where('id',$id)->first();
         return response()->json([
             'id' => $client['id'],
             'nome' => $client['nome'],
             'user' => $client['user'],
         ]);
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

public function update(UpdateClientRequest $request) {

    $data = $request->validated();

    /** @var Client $client */
    $client = Client::where('id',$data['id'])->first();

    if(!$client) return response(['','422']);

    if(isset($data['nome']) && $data['nome'] != $client['nome']){
        $client->update(['nome'=>$data['nome']]);
        return response([
            'notification' => "Profilo cliente aggiornato con successo",
            'status' => "success"
        ],202);
    } else {
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
