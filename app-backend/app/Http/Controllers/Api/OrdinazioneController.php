<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrdinazioneRequest;
use App\Models\Ordinazione;
use Illuminate\Http\Request;

class OrdinazioneController extends Controller
{
    public function store(OrdinazioneRequest $request) {
        $validatedData = $request->validated();
        $ordinazione = Ordinazione::create($validatedData);
        return response()->json($ordinazione, 201);
    }
}
