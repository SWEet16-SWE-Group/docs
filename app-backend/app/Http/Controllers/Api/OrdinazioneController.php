<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrdinazioneRequest;
use App\Models\Ordinazione;
use DB;

class OrdinazioneController extends Controller
{
    public function store(OrdinazioneRequest $request) {
        $a = $request->input('rimozioni',[]) ;
        $r = $request->input('aggiunte',[])  ;
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
}
