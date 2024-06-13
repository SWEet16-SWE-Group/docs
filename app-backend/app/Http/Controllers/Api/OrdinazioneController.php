<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrdinazioneRequest;
use App\Models\Ordinazione;
use DB;
use http\Client\Request;

class OrdinazioneController extends Controller
{
    public function store(OrdinazioneRequest $request) {
        $a = $request->input('aggiunte',[])  ;
        $r = $request->input('rimozioni',[]) ;
        $validatedData = $request->validated();
        $ordinazione = Ordinazione::create($validatedData);

        $insert = fn (...$a) => DB::insert('insert into dettagliordinazione(ingrediente, ordinazione, dettaglio) values (?,?,?)',$a);
        foreach($a as $a){
            $insert($a['ingrediente'],$ordinazione->id,'+');
        }
        foreach($r as $a){
            $insert($a['ingrediente'],$ordinazione->id,'-');
        }

        return response()->json($ordinazione, 201);
    }

    public function paga($id){
        $record = Ordinazione::findOrFail($id);
        $record->pagamento = 'PAGATO';
        $record->save();
        return response()->json(0,200);
    }

    public function destroy($id) {
        $ordinazione = Ordinazione::find($id);
        if (!$ordinazione) {
            return response()->json(['message' => 'Ordinazione non trovata'], 404);
        }
        $ordinazione ->delete();
        return response()->json(['message' => 'Ordinazione eliminata con successo'], 204);
    }
}
