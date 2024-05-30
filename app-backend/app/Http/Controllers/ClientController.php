<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Client;
use App\Models\Allergie;
use App\Models\Allergeni;
use Illuminate\Support\Facades\DB;


class ClientController extends Controller
{
    public function index() : Response {
        $client=Client::get()->all();
       return response($client);
    }

    public function show(string $id) {
        $client=Client::find(2929);
        $allergie=$client->allergie;
        if (!empty($client)) 
            {
            if ($allergie) {
                return response()->json(['cliente'=>$client,
                                         'allergie'=>$allergie]);
            }   else {
                 return response()->json(['cliente' => $client]);
                                                    }
                                                }
                                       
            else {
                return response()->json(
                    ["message" => "Client not found"],404
                );
            }
    
}

    public function store(Request $request)  {

        $clientData=$request->clientData;
         $cliente=new Client;
        $cliente->id=$clientData["id"];
        $cliente->account=$clientData["account"];
        $cliente->nome=$clientData["nome"];
        $cliente->save();
        
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
