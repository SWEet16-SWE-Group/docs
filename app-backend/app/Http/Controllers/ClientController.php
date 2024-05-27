<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Models\Client;

class ClientController extends Controller
{
    public function index() : Response {
        $client=Client::get()->all();
       return response($client);
    }

    public function show(string $id) {
        $client=Client::where('nome',$id)
                        ->get();
        if (!empty($client)) {
            return response()->json($client);
        }
            else {
                return response()->json(
                    ["message" => "Client not found"],404
                );
            }
    }

    public function store(Request $request)  {

        
        $validatedData = $request->validate([
            'id' => 'required',
            'account' => 'required',
            'nome' => 'required',
        ]);

        $cliente=new Client;
        $cliente->id=$request->id;
        $cliente->account=$request->account;
        $cliente->nome=$request->nome;
        $cliente->save();

        return response()->json(['message' => $request->nome], 201);
}

public function update(Request $request) {


    if (Client::where('id',$request -> id) -> exists()) {
        $client= Client::find($request->id);
        $client->nome = is_null($request->nome) ? $client->name : $request->nome;
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
