<?php

namespace App\Http\Controllers;

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

    public function show(string $client_name) {
        $client=Client::where('nome',$client_name)->get();
        if (!empty($client)) 
            {
            
                 return response()->json(['cliente' => $client]);
                                                    }
            else {
                return response()->json(
                    ["message" => "Client not found"],404
                );
            }
    
}

    public function store(ClientRequest $request)  {

        $clientData=$request->validated();
        $clientData=$clientData["clientData"];
         $cliente= Client::create(['nome'=>$clientData["nome"],
                                   'account'=>$clientData["account_id"]]);
     //   $cliente->id=$clientData["profile_id"];
               
        if ($request -> allergie) {
            $allergies = $request->allergie;
            foreach($allergies as $key => $value) {
                $allergene=Allergeni::find($value);
                $cliente->allergie()->attach($allergene);
               
                
            }
        }

        return response()->json(['message' => 'New client saved!'], 201);
}

public function update(Request $request) {


    if (Client::where('id',$request -> id) -> exists()) {
        $client= Client::find($request->id);
        $client->nome = is_null($request->nome) ? $client->nome : $request->nome;
        $client-> account = is_null($request->account) ? $client->account : $request->account;
        $client->save();
        return response()->json([
            "message" => "Client updated"
        ],202);
    }
}

    public function destroy(string $id) {
        if (Client::where('id',$id)) {
            $client = Client::find($id);
            $client -> delete();
            return response()->json([
                "message" => "Client deleted."
            ],202);
        }
            else {
                return response()->json([
                    "message" => "Client not found!"
                ],404);
            }
    }
}
