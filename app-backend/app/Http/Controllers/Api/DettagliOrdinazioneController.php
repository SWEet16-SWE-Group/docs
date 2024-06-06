<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DettagliOrdinazioneRequest;
use App\Models\DettagliOrdinazione;
use Illuminate\Http\Request;

class DettagliOrdinazioneController extends Controller
{
    public function store(DettagliOrdinazioneRequest $request) {
        $validatedData = $request->validated();
        $ordinazione = DettagliOrdinazione::create($validatedData);
        return response()->json($ordinazione, 201);
    }
}
