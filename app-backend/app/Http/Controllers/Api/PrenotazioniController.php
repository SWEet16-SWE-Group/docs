<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PrenotazioneRequest;
use App\Models\Client;
use App\Models\Invito;
use App\Models\Ordinazione;
use App\Models\Prenotazione;
use Illuminate\Http\Request;
use DB;

class PrenotazioniController extends Controller
{

    public function show ($id) {
        $prenotazioni = Prenotazione::select('prenotazioni.*')
            ->where('ristoratore', $id)
            ->get();

        return response()->json($prenotazioni);
    }

    public function store(PrenotazioneRequest $request) {
        $validatedData = $request->validated();
        $prenotazione = Prenotazione::create($validatedData);

        return response()->json($prenotazione, 201);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'stato' => 'required|in:Accettata,Rifiutata'
        ]);

        $prenotazione = Prenotazione::findOrFail($id);

        $prenotazione->stato = $request->input('stato');
        $prenotazione->save();

        return response()->json([
            'message' => 'Prenotazione updated successfully',
            'prenotazione' => $prenotazione
        ]);
    }

    public function dashboard_c($id){
        $prenotazione = Prenotazione::select(
            'prenotazioni.id',
            'prenotazioni.orario',
            'ristoratori.nome as nome',
            'prenotazioni.numero_inviti',
            'prenotazioni.stato')
            ->join('inviti','prenotazioni.id','=','inviti.prenotazione')
            ->join('ristoratori','ristoratori.id','=','prenotazioni.ristoratore')
            ->where('inviti.cliente',$id)
            ->get();
        return response()->json($prenotazione, 200);
    }

    public function prenotazione_c($id){
        $prenotazione = Prenotazione::select(
            'prenotazioni.id',
            'prenotazioni.orario',
            'ristoratori.nome as nome',
            'ristoratori.id as ristoratore',
            'prenotazioni.numero_inviti',
            'prenotazioni.stato')
            ->join('ristoratori','ristoratori.id','=','prenotazioni.ristoratore')
            ->join('inviti','inviti.prenotazione','=','prenotazioni.id')
            ->where('inviti.prenotazione',$id,'')
            ->get()->first();
        $ordinazioni = DB::select(<<<'EOF'
            select o.id, c.nome as c, pz.nome as pietanza,
                GROUP_CONCAT(iia.nome) as aggiunte,
                GROUP_CONCAT(iir.nome) as rimozioni
            from prenotazioni as p
            inner join inviti as i on p.id = i.prenotazione
            inner join clients as c on c.id = i.cliente
            inner join ordinazioni as o on i.id = o.invito
            inner join pietanze as pz on pz.id = o.pietanza
            left join dettagliordinazione as d on o.id = d.ordinazione
            left join dettagliordinazione as ia on ia.id = d.id and ia.dettaglio = '+'
            left join dettagliordinazione as ir on ir.id = d.id and ir.dettaglio = '-'
            left join ingredienti as iia on iia.id = ia.ingrediente
            left join ingredienti as iir on iir.id = ir.ingrediente
            where p.id = ?
            group by o.id;
            EOF, [$id]);
        $ordinazioni2 = array_map(
            fn ($a) => ['nome' => $a, 'ordinazioni' => array_values(array_filter($ordinazioni,fn ($o) => $o->c == $a))],
            $cols = array_unique( $c = array_map(fn($a)=> $a->c,$ordinazioni)),
        );
        $return = ['prenotazione' => $prenotazione, 'ordinazioni' => array_values($ordinazioni2)];
        return response()->json($return, 200);
    }

    public function prenotazione_conto($id){
        $return = Prenotazione::select('prenotazioni.*','r.nome')
            ->where('prenotazioni.id',$id)
            ->join('ristoratori as r','r.id','=','prenotazioni.ristoratore')
            ->first();
        return response()->json($return,200);
    }

    public function prenotazione_dettagli($id){
        $return = Prenotazione::select(
            'prenotazioni.*',
            'r.nome',
            DB::raw('group_concat(c.nome) as partecipanti'))
            ->where('prenotazioni.id',$id)
            ->join('ristoratori as r','r.id','=','prenotazioni.ristoratore')
            ->join('inviti as i','i.prenotazione','=','prenotazioni.id')
            ->join('clients as c','i.cliente','=','c.id')
            ->groupBy('prenotazioni.id')
            ->first();
        return response()->json($return,200);
    }

    public function set_divisioneconto(Request $request, $id){
        $request->validate([
            'divisione_conto' => 'required|in:Equo,Proporzionale'
        ]);

        $prenotazione = Prenotazione::findOrFail($id);

        $prenotazione->divisione_conto = $request->input('divisione_conto');
        $prenotazione->save();
        $return = Prenotazione::select('prenotazioni.*','r.nome')
            ->where('prenotazioni.id',$id)
            ->join('ristoratori as r','r.id','=','prenotazioni.ristoratore')
            ->first();
        return response()->json($return,200);
    }

    public function pagamenti_ordinazioni($id){
        $return = DB::select(<<<'EOF'
            SELECT c.id as cid, c.nome as cliente, i.pagamento as pagamento_c,
            o.id as oid, pz.nome as pietanza,
            GROUP_CONCAT(iia.nome) as agginte,
            GROUP_CONCAT(iir.nome) as rimozioni, o.pagamento as pagamento_o
            FROM `prenotazioni` as p
            inner join inviti as i on i.prenotazione = p.id
            inner join clients as c on i.cliente = c.id
            inner join ordinazioni as o on o.invito = i.id
            inner join pietanze as pz on o.pietanza = pz.id
            left join dettagliordinazione as ia on ia.ordinazione = o.id and ia.dettaglio = '+'
            left join dettagliordinazione as ir on ir.ordinazione = o.id and ir.dettaglio = '-'
            left join ingredienti as iia on ia.ingrediente = iia.id
            left join ingredienti as iir on ir.ingrediente = iir.id
            where p.id = ?
            group by o.id;
            EOF, [$id]);
        return response()->json($return,200);
    }

    public function pagamenti_inviti($id){
        $return = DB::select(<<<'EOF'
            SELECT i.id as id, c.id as cid, c.nome as cliente, i.pagamento as pagamento_c
            FROM `prenotazioni` as p
            inner join inviti as i on i.prenotazione = p.id
            inner join clients as c on i.cliente = c.id
            where p.id = ?;
            EOF, [$id]);
        return response()->json($return,200);
    }

    public function getIngredientsForPrenotazione($prenotazioneId)
    {
        $ingredienti = DB::select(<<<'EOF'
            SELECT i.nome AS ingrediente,
                COUNT(*) AS quantita
            FROM prenotazioni pr
            JOIN inviti iv ON pr.id = iv.prenotazione
            JOIN ordinazioni o ON iv.id = o.invito
            JOIN ricette r ON o.pietanza = r.pietanza
            JOIN ingredienti i ON r.ingrediente = i.id
            WHERE pr.id = ?
            GROUP BY i.nome
            ORDER BY i.nome;
            EOF, [$prenotazioneId]);

        return response()->json($ingredienti, 200);
    }

    public function destroy($id)
    {
        $prenotazione = Prenotazione::find($id);
        if (!$prenotazione) {
            return response()->json(['message' => 'Prenotazione non trovata'], 404);
        }
        $prenotazione ->delete();
        return response()->json(['message' => 'Prenotazione eliminata con successo'], 204);
    }
}
