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
        $ristoratori = Ristoratore::select('id', 'user', 'nome', 'indirizzo', 'telefono', 'capienza', 'orario')->get();
        return response()->json($ristoratori, 200);
    }

    public function store(RistoratoreRequest $request)
    {

        $validatedData = $request->validated();
        $ristoratore = Ristoratore::create($validatedData);

        if($ristoratore) {
            return response([
                "notification" => "Ristoratore creato con successo",
                'status' => "success",
            ], 201);
        } else {
            return response([
                "notification" => "Errore nella creazione di ristoratore!",
                'status' => "failure",
            ], 404);
        }
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
        if (Ristoratore::where('id', $id) -> exists()) {
            $ristoratore = Ristoratore::find($request->id);

            $ristoratore -> nome = is_null($request -> nome) ? $ristoratore -> nome : $request -> nome;
            $ristoratore -> indirizzo = is_null($request -> indirizzo) ? $ristoratore -> indirizzo : $request -> indirizzo;
            $ristoratore -> telefono = is_null($request -> telefono) ? $ristoratore -> telefono : $request -> telefono;
            $ristoratore -> capienza = is_null($request -> capienza) ? $ristoratore -> capienza : $request -> capienza;
            $ristoratore -> orario = is_null($request -> orario) ? $ristoratore -> orario : $request -> orario;
            $ristoratore->save();

            return response([
                'notification' => "Ristoratore aggiornato con succcesso",
                'status' => "success",
            ],202);
        } else {
            return response([
                'notification' => "Ristoratore non trovato!",
                'status' => "failure",
            ],404);
        }
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
}
