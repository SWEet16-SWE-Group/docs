<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ingrediente;
use App\Http\Requests\IngredienteRequest;
use DB;

class IngredienteController extends Controller
{
    public function index($ristoratoreId)
    {
        $ingredienti = Ingrediente::where('ristoratore', $ristoratoreId)->get();
        return response()->json($ingredienti);
    }

    public function show($id)
    {
        $ingrediente = Ingrediente::findOrFail($id);
        return response()->json($ingrediente);
    }

    public function store(IngredienteRequest $request)
    {
        $request->validated();
        $ingrediente = Ingrediente::create($request->all());
        return response()->json($ingrediente, 201);
    }

    public function update(IngredienteRequest $request, $id)
    {
        $ingrediente = Ingrediente::find($id);

        if (!$ingrediente) {
            return response()->json(['message' => 'Ingrediente non trovato'], 404);
        }

        $request->validated();
        $ingrediente->update($request->all());
        return response()->json($ingrediente);
    }

    public function destroy($id)
    {
        $ingrediente = Ingrediente::find($id);

        if (!$ingrediente) {
            return response()->json(['message' => 'Ingrediente non trovato'], 404);
        }

        $ingrediente->delete();
        return response()->json(['message' => 'Ingrediente eliminato con successo'], 204);
    }

    public function aggiunte($pietanza){
        $ingredienti = DB::select(<<<'EOF'
            select distinct i.id, i.nome
            from ingredienti as i
            inner join pietanze as pz on i.ristoratore = pz.ristoratore
            left join ricette as r on r.ingrediente = i.id and r.pietanza = ?
            left join pietanze as p on r.pietanza = p.id
            where r.pietanza is null
            EOF, [$pietanza]);
        return response()->json($ingredienti,200);
    }

    public function rimozioni($pietanza){
        $ingredienti = Ingrediente::select('ingredienti.id','ingredienti.nome')
            ->join('ricette as r','r.ingrediente','=','ingredienti.id')
            ->where('r.pietanza', $pietanza)
            ->get();
        return response()->json($ingredienti,200);
    }

}
