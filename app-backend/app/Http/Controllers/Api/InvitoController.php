<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\InvitoRequest;
use App\Models\Invito;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InvitoController extends Controller {

    public function store(InvitoRequest $request) {
        $validatedData = $request->validated();
        $invito = Invito::create($validatedData);

        if ($invito) {
            return response([
                "notification" => "Cliente invitato alla prenotazione.",
                'status' => "success",
            ], 201);
        } else {
            return response([
                "notification" => "Errore nell'invito del cliente.",
                'status' => "failure",
            ], 404);
        }
    }
}
