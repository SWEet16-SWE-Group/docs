<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pietanza;
use App\Http\Requests\PietanzaRequest;
use App\Models\Ingrediente;
use DB;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PietanzaController extends Controller
{
    use RefreshDatabase;

    public function index($ristoratoreId)
    {
        $pietanze = Pietanza::where('ristoratore', $ristoratoreId)->get();
        return response()->json($pietanze);
    }

    public function store(PietanzaRequest $request)
    {
        $request->validated();
        $pietanza = Pietanza::create($request->all());
        if ($request -> ingredienti) {
            $ingredients = $request->ingredienti;
            foreach($ingredients as $key => $value) {
                $ingrediente=Ingrediente::find($value);
                $pietanza->ingredienti()->attach($ingrediente);
            }
        }
        return response()->json($pietanza, 201);
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
            DB::raw('group_concat(i.nome) as ingredienti'),
            DB::raw('group_concat(a.nome) as allergeni'),
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
