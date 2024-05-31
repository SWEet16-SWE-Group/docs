<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Ristoratore;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function getAllProfiles(Request $request)
    {
        $clients = Client::where('user',$request->id)->get(['id','nome','user']);

        if($clients) {
            foreach ($clients as $client) {
                $client['tipo'] = "cliente";
            }
        }

        $restaurants = Ristoratore::where('user',$request->id)->get(['id','nome','user']);

        if($restaurants) {
            foreach ($restaurants as $restaurant) {
                $restaurant['tipo'] = "ristoratore";
            }
        }

        if(!$clients && !$restaurants)
            return response('',204);

       return response([
           'clienti' => $clients,
           'ristoratori' => $restaurants,
       ],201);
    }

}
