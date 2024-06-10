<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pietanza;
use App\Http\Requests\PietanzaRequest;
use DB;

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
        $pietanza = Pietanza::find($id);
        if(!$pietanza) {
            return response()->json([
                'message' => 'Pietanza non trovata'
            ], 404);
        }
        $pietanza->update($request->all());
        return response()->json($pietanza);
    }

    public function destroy($id)
    {
        $pietanza = Pietanza::find($id);
        if (!$pietanza) {
            return response()->json(['message' => 'Pietanza non trovata'], 404);
        }
        $pietanza ->delete();
        return response()->json(['message' => 'Pietanza eliminata con successo'], 204);
    }

    public function dettagli($id){
        $return = Pietanza::select(
            'pietanze.id',
            'pietanze.nome',
            DB::raw('group_concat(i.nome separator ", ") as ingredienti'),
            DB::raw('group_concat(a.nome separator ", ") as allergeni'),
        )
        ->join('ricette as r','r.pietanza','=','pietanze.id')
        ->join('ingredienti as i','r.ingrediente','=','i.id')
        ->leftJoin('allergeniingredienti as ia','ia.ingrediente','=','i.id')
        ->leftJoin('allergeni as a','ia.allergene','=','a.id')
        ->where('pietanze.id',$id)
        ->groupBy('pietanze.id')
        ->first();
        return response()->json($return,200);
    }
}
