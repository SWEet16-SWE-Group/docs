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
        // $clients = Client::where('account',$request->id)->orderBy('id','desc')->paginate();
        // $restaurants = Ristoratore::where('user',$request->id)->orderBy('id','desc')->paginate();


        $clients = Client::where('user',$request->id)->get();
        $clients->tipo = 'Cliente';

        $restaurants = Ristoratore::where('user',$request->id)->get();
        $restaurants->type = "Ristoratore";

        if(!$clients && !$restaurants)
            return response('',204);

       return response([
           'clienti' => $clients,
           'ristoratori' => $restaurants,
       ],201);
    }

}
