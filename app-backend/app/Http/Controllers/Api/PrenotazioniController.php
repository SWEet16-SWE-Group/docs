<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PrenotazioneRequest;
use App\Models\Client;
use App\Models\Prenotazione;
use Illuminate\Http\Request;

class PrenotazioniController extends Controller
{
    public function index() {
        $prenotazioni = Prenotazione::with('ristoratore')->get();
        return response()->json($prenotazioni);
    }

    public function show ($id) {
        $currentTime = now();

        $prenotazioni = Prenotazione::where('ristoratore', $id)
        ->where('orario', '>=', $currentTime)
        ->orderBy('orario')
        ->get();
        $prenotazioni->each(function ($prenotazione) {
            $prenotazione->nome = Client::where('id', $prenotazione->cliente)->first()->nome;
        });

        return response()->json($prenotazioni);
    }

    public function store(PrenotazioneRequest $request) {
        $validatedData = $request->validated();
        $prenotazione = Prenotazione::create($validatedData);

        return response()->json(['message' => 'Prenotazione created successfully', 'data' => $prenotazione], 201);

    }

    public function update(Request $request, $id)
    {
        $prenotazione = Prenotazione::findOrFail($id);

        $validatedData = $request->validate([
            'ristoratore_id' => 'required|exists:ristoratores,id',
            'orario' => 'required|date_format:Y-m-d H:i:s',
            'numero_inviti' => 'required|integer',
            'divisione_conto' => 'required|in:Equo,Proporzionale',
            'stato' => 'required|in:Accettata,Rifiutata,In attesa',
        ]);

        $prenotazione->update($validatedData);

        return response()->json(['message' => 'Prenotazione updated successfully', 'data' => $prenotazione]);
    }

    public function destroy($id) {
        $prenotazione = Prenotazione::findOrFail($id);
        $prenotazione->delete();

        return response()->json(['message'=> 'Prenotazione deleted successfully'], 204);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'stato' => 'required|in:Accettata,Rifiutata'
        ]);

        $prenotazione = Prenotazione::findOrFail($id);

        $prenotazione->stato = $request->input('stato');
        $prenotazione->save();

        return response()->json([
            'message' => 'Prenotazione updated successfully',
            'prenotazione' => $prenotazione
        ]);


    }
}