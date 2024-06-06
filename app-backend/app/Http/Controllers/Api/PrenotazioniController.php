<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PrenotazioneRequest;
use App\Models\Client;
use App\Models\Invito;
use App\Models\Ordinazione;
use App\Models\Prenotazione;
use Illuminate\Http\Request;
use DB;

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

        return response()->json($prenotazione, 201);
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

    public function dashboard_c($id){
        $prenotazione = Prenotazione::select(
            'prenotazioni.id',
            'prenotazioni.orario',
            'ristoratori.nome as nome',
            'prenotazioni.numero_inviti',
            'prenotazioni.stato')
            ->join('inviti','prenotazioni.id','=','inviti.prenotazione')
            ->join('ristoratori','ristoratori.id','=','prenotazioni.ristoratore')
            ->where('inviti.cliente',$id)
            ->get();
        return response()->json($prenotazione, 200);
    }

    public function prenotazione_c($id){
        $prenotazione = Prenotazione::select(
            'prenotazioni.id',
            'prenotazioni.orario',
            'ristoratori.nome as nome',
            'ristoratori.id as ristoratore',
            'prenotazioni.numero_inviti',
            'prenotazioni.stato')
            ->join('ristoratori','ristoratori.id','=','prenotazioni.ristoratore')
            ->join('inviti','inviti.prenotazione','=','prenotazioni.id')
            ->where('inviti.cliente',$id)
            ->get()->first();
        $ordinazioni = array_map(
            fn ($a) => [
                'nome' => $a['nome'],
                'ordinazioni' => Ordinazione::select(
                    'ordinazioni.id',
                    'pietanze.nome',
                    DB::raw('GROUP_CONCAT(iai.nome SEPARATOR ", ") as aggiunte '),
                    DB::raw('GROUP_CONCAT(iri.nome SEPARATOR ", ") as rimozioni'),
                )
                    ->join('pietanze','pietanze.id','=','ordinazioni.pietanza')
                    ->leftjoin('dettagliordinazione as ia','ordinazioni.id','=','ia.ordinazione')
                    ->leftjoin('dettagliordinazione as ir','ordinazioni.id','=','ir.ordinazione')
                    ->join('ingredienti as iai','iai.id','=','ia.ingrediente')
                    ->join('ingredienti as iri','iri.id','=','ir.ingrediente')
                    ->join('inviti','inviti.id','=','ordinazioni.invito')
                    ->groupBy('ordinazioni.id','pietanze.nome')
                    ->where('inviti.id',$a['id'])
                    ->where('ia.dettaglio','+')
                    ->where('ir.dettaglio','-')
                    ->get()->toArray()
            ],
        Invito::select('inviti.id', 'clients.nome')
                ->join('clients','clients.id','=','inviti.cliente')
                ->where('inviti.prenotazione',$id)->get()->toArray(),
        );
        $return = ['prenotazione' => $prenotazione, 'ordinazioni' => $ordinazioni];
        return response()->json($return, 200);
    }
}
