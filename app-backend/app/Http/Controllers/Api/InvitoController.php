<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\InvitoRequest;
use App\Models\Invito;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InvitoController extends Controller {

    public function store(InvitoRequest $request) {
        $validatedData = $request->validated();
        $invito = Invito::create($validatedData);

        if ($invito) {
            return response([
                "notification" => "Cliente invitato alla prenotazione.",
                'status' => "success",
            ], 201);
        } else {
            return response([
                "notification" => "Errore nell'invito del cliente.",
                'status' => "failure",
            ], 404);
        }
    }

    public function get_by_prenotazione_cliente($prenotazione, $cliente){
        $invito = Invito::where('prenotazione', $prenotazione)
            ->where('cliente', $cliente)
            ->get();
        return response()->json($invito,200);
    }

    public function paga(Request $request, $id){
        $request->validate([
            'pagamento' => 'required|in:NON PAGATO,PAGATO'
        ]);

        $record = Invito::findOrFail($id);
        $record->pagamento = $request->input('pagamento');
        $record->save();
        return response()->json(0,200);
    }
}
