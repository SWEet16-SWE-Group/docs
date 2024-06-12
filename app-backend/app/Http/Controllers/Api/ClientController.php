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
            'cliente' => $cliente,
            'notification' => "Profilo cliente creato con successo",
            'status' => "success"
        ],201);
}

public function update(UpdateClientRequest $request) {

    $data = $request->validated();

    /** @var Client $client */
    $client = Client::findOrFail($data['id']);

    $client->update(['nome'=>$data['nome']]);
    return response([
        'notification' => "Profilo cliente aggiornato con successo",
        'status' => "success"
    ],202);
}

    public function destroy(string $id) {
        $client = Client::findOrFail($id);
        $client -> delete();
        return response()->json($client, 200);
    }
}
