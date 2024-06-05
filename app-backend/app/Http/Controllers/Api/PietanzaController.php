<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pietanza;
use App\Http\Requests\PietanzaRequest;

class PietanzaController extends Controller
{
    public function index($ristoratoreId)
    {
        $pietanze = Pietanza::where('ristoratore', $ristoratoreId)->get();
        return response()->json($pietanze);
    }

    public function store(PietanzaRequest $request)
    {
        $request->validated();
        $pietanza = Pietanza::create($request->all());
        return response()->json($pietanza, 201);
    }

    public function show($id)
    {
        $pietanza = Pietanza::findOrFail($id);
        return response()->json($pietanza);
    }

    public function update(PietanzaRequest $request, $id)
    {
        $request->validated();
        $pietanza = Pietanza::findOrFail($id);
        if(!$pietanza) {
            return response()->json([
                'message' => 'Pientanza non trovata'
            ], 404);
        }
        $pietanza->update($request->all());
        return response()->json($pietanza);
    }

    public function destroy($id)
    {
        $pietanza = Pietanza::find($id);
        if (!$pietanza) {
            return response()->json(['message' => 'ingrediente non trovato'], 404);
        }
        $pietanza ->delete();
        return response()->json(['message' => 'Pietanza eliminata con successo'], 204);
    }
}