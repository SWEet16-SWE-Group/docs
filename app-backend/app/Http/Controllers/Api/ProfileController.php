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


    public function selectProfile(Request $request)
    {
        if($request['profileType'] === 'cliente') {
            /** @var Client $client */
            $client = Client::where(['id' => $request->profileId, 'user' => $request->userId])->first();

            if(!$client)
                return response('',204);

            return response([
                'profile' => $client,
                'role' => 'CLIENTE'
            ]);

        } elseif ($request['profileType'] === 'ristoratore') {
            /** @var Ristoratore $restaurant */
            $restaurant = Ristoratore::where(['id' => $request->profileId, 'user' => $request->userId])->first();

            if(!$restaurant)
                return response('',204);

            return response([
                'profile' => $restaurant,
                'role' => 'RISTORATORE'
            ]);

        } else {
            return response('', 422);
        }
    }
}
