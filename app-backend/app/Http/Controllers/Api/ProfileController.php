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

        $restaurants = Ristoratore::where('user',$request->id)->get(['id','nome','user']);

       return response([
           'clienti' => $clients,
           'ristoratori' => $restaurants,
       ],201);
    }


    public function selectProfile(Request $request)
    {
        if($request['profileType'] === 'Cliente') {
            /** @var Client $client */
            $client = Client::where(['id' => $request->profileId, 'user' => $request->userId])->first();

            if(!$client)
                return response([
                        'notification' => 'Errore nella selezione del profilo!',
                        'status' => 'failure'
                    ]
                );

            return response([
                'profile' => $client,
                'role' => 'CLIENTE',
                'notification' => 'Profilo cliente selezionato con successo',
                'status' => 'success'
            ]);

        } elseif ($request['profileType'] === 'Ristoratore') {
            /** @var Ristoratore $restaurant */
            $restaurant = Ristoratore::where(['id' => $request->profileId, 'user' => $request->userId])->first();

            if(!$restaurant)
                return response([
                    'notification' => 'Errore nella selezione del profilo!',
                    'status' => 'failure'
                    ]
                );

            return response([
                'profile' => $restaurant,
                'role' => 'RISTORATORE',
                'notification' => 'Profilo ristoratore selezionato con successo',
                'status' => 'success'
            ]);

        } else {
            return response([
                    'notification' => 'Errore nella selezione del profilo!',
                    'status' => 'failure'
                ]
            );
        }
    }
}
