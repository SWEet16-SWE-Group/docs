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
        return response('Ciao','204');
        // $clients = Client::where('account',$request->id)->orderBy('id','desc')->paginate();
        // $restaurants = Ristoratore::where('user',$request->id)->orderBy('id','desc')->paginate();

        /** @var Client $clients */
        $clients = Client::where('account',1)->first();

        /** @var Ristoratore $restaurants */
        $restaurants = Ristoratore::where('user',1)->orderBy('id','desc');

        if(!$clients && !$restaurants)
            return response('',422);

        if(!$restaurants) {
            //$clients->type = "Cliente";
            return response($clients,204);
        }

        if(!$clients) {
            //$restaurants->type = "Ristoratore";
            return response($restaurants,204);
        }

        //$clients->type = "Cliente";
        //$restaurants->type = "Ristoratore";

        return response($clients, '204');

    }

}
