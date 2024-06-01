<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\RistoratoreRequest;
use App\Models\Ristoratore;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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

        return response()->json($ristoratore, 201);
    }

    public function show($id)
    {
        $ristoratore = Ristoratore::find($id);
        if (!$ristoratore) {
            return response()->json(['error' => 'Ristoratore non trovato'], 404);
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

            return response()->json([
                "message" => "Ristoratore aggiornato con successo"
            ],202);
        } else {
            return response()->json(["error" => "Ristoratore non trovato"], 404);
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

            return response()->json(['message' => 'Ristoratore eliminato con successo.'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Errore durante l\'eliminazione del ristoratore.'], 500);
        }
    }

    public function listByUser($user) {
        $ristoratori = Ristoratore::where('user', $user)->get();

        if ($ristoratori->isEmpty()) {
            return response()->json(['message' => 'L\'account non ha ristoratori'], 404);
        }

        return response()->json($ristoratori);
    }
}
