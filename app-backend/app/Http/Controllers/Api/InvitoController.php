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

        return response()->json($invito, 201);
    }

    public function get_by_prenotazione_cliente($prenotazione, $cliente){
        $invito = Invito::where('prenotazione', $prenotazione)
            ->where('cliente', $cliente)
            ->get();
        return response()->json($invito,200);
    }

    public function paga($id){
        $record = Invito::findOrFail($id);
        $record->pagamento = 'PAGATO';
        $record->save();
        return response()->json(0,200);
    }
}
