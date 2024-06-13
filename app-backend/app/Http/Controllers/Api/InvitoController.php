<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\InvitoRequest;
use App\Models\Invito;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class InvitoController extends Controller {

    public function store(InvitoRequest $request) {
        $validatedData = $request->validated();
        $invito = Invito::create($validatedData);

        DB::insert('insert into notifiche(invito,significato) values(?,"INVITO ACCETTATO")',[$invito->id]);

        return response()->json($invito, 201);
    }

    public function get_by_prenotazione_cliente($prenotazione, $cliente){
        $invito = Invito::where('prenotazione', $prenotazione)
            ->where('cliente', $cliente)
            ->get();
        return response()->json($invito,200);
    }

    public function paga($id){
        $invito = Invito::findOrFail($id);
        $invito->pagamento = 'PAGATO';
        $invito->save();

        DB::insert('insert into notifiche(invito,significato) values(?,"INVITO PAGATO")',[$invito->id]);

        return response()->json(0,200);
    }
}
