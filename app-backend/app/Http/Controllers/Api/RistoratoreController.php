<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\RistoratoreRequest;
use App\Models\Ristoratore;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pietanza;
use DB;

class RistoratoreController extends Controller
{
    public function index()
    {
        $ristoratori = Ristoratore::select('id', 'user', 'nome', 'cucina', 'indirizzo', 'telefono', 'capienza', 'orario')->get();
        return response()->json($ristoratori, 200);
    }

    public function store(RistoratoreRequest $request)
    {

        $validatedData = $request->validated();
        $ristoratore = Ristoratore::create($validatedData);

        return response()->json($ristoratore, 201);
    }

    public function show($id)
    {
        $ristoratore = Ristoratore::find($id);
        if (!$ristoratore) {
            return response([
                "notification" => "Ristoratore non trovato!",
                'status' => "failure",
            ],404);
        }
        return response()->json($ristoratore);
    }

    public function update(Request $request, $id)
    {
        $ristoratore = Ristoratore::find($request->id);

        $ristoratore -> nome = is_null($request -> nome) ? $ristoratore -> nome : $request -> nome;
        $ristoratore -> cucina = is_null($request -> cucina) ? $ristoratore -> cucina : $request -> cucina;
        $ristoratore -> indirizzo = is_null($request -> indirizzo) ? $ristoratore -> indirizzo : $request -> indirizzo;
        $ristoratore -> telefono = is_null($request -> telefono) ? $ristoratore -> telefono : $request -> telefono;
        $ristoratore -> capienza = is_null($request -> capienza) ? $ristoratore -> capienza : $request -> capienza;
        $ristoratore -> orario = is_null($request -> orario) ? $ristoratore -> orario : $request -> orario;
        $ristoratore->save();

        return response()->json($ristoratore,202);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ristoratore  $ristoratore
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $ristoratore = Ristoratore::where('id', $id)->first();
            $ristoratore->delete();

            return response([
                "notification" => "Ristoratore eliminato con succcesso",
                'status' => "success",
            ],200);
        } catch (\Exception $e) {
            return response([
                "notification" => "Errore durante l'eliminazione del ristoratore!",
                'status' => "failure",
            ],500);
        }
    }

    public function listByUser($user) {
        $ristoratori = Ristoratore::where('user', $user)->get();

        if ($ristoratori->isEmpty()) {
            return response([
                "notification" => "Questo account non ha ristoratori!",
                'status' => "failure",
            ],404);
        }

        return response()->json($ristoratori);
    }

    public function menu($id){
        $menu = Pietanza::select('pietanze.id as id', 'pietanze.nome as nome', DB::raw('GROUP_CONCAT(ingredienti.nome SEPARATOR ", ") as ingredienti'))
            ->join('ristoratori','ristoratori.id', '=', 'pietanze.ristoratore')
            ->join('ricette','pietanze.id','=','ricette.pietanza')
            ->join('ingredienti','ingredienti.id','=','ricette.ingrediente')
            ->groupBy('pietanze.id','pietanze.nome')
            ->where('ristoratori.id',$id)
            ->get();
        return response()->json($menu,200);
    }

    public function search(Request $request) {
        $ristoranti=Ristoratore::where('indirizzo','LIKE', "%{$request->città}%")->get();
        if (!$ristoranti->isEmpty()) {

        $query = $request->ristorante;
// sortBy permette di ordinare gli elementi della collection secondo una funzione data;
//la funzione scelta è levenshtein(), nativamente implementata da php e che calcola
// la distanza tra due stringhe in termini di somiglianza
        $sortedRestaurants = $ristoranti->sortBy(function ($ristorante) use($query) {
            return levenshtein($query, $ristorante->nome);
        })->values()->take(20);
/* nelle prove mi sembrava funzionasse male levenshtein(); quindi ho  creato anche un array associativo che mi mandavo al front-end
 con come chiavi i nomi dei ristoranti e valori le loro distanza di levenshtein(); a quanto pare corrispondono
        $restaurants= Ristoratore::all('nome')->toArray();
        $distances = [];

    // Calcola la distanza di Levenshtein per ciascun valore nell'array
    foreach ($restaurants as $restaurant) {
        $distance = levenshtein($request->ristorante, $restaurant["nome"]);
        $distances[$restaurant["nome"]] = [  $distance];
    }

    // Ordina l'array in base alle distanze calcolate
   arsort($distances); */

        $ristorantiJson = $sortedRestaurants->map(function ($ristorante) {
            return [
                'ristorante' => $ristorante,
                'cucina' => $ristorante->cucina->Cucina
            ];

        });

        return response()->json(['listaRistoranti' => $ristorantiJson,
                                 'notification' => 'Creata lista ristoranti',
                                 'status' => 'success'],200);
    }
 else  {
    return response()->json(['notification' => 'Nessun ristorante presente nella città da te inserita!',
                             'status' => 'failure'],404);
}
    }
}
