<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB;

class NotificheController extends Controller
{

    private $prenotazioni_ristoratori_cliente = <<<'EOF'
    select
        p.id as prenotazione_id,
        p.orario,
        p.numero_inviti,
        p.divisione_conto,
        p.stato,
        r.id as ristoratore_id,
        r.nome as ristorante_nome,
        r.cucina,
        r.indirizzo,
        r.telefono,
        r.capienza,
        c.id as cliente_id,
        c.nome as cliente_nome
    from prenotazioni as p
    inner join ristoratori as r on r.id = p.ristoratore
    inner join inviti as i on p.id = i.prenotazione
    inner join clients as c on c.id = i.cliente
    inner join (
        select p.id, min(i.created_at) as min
        from prenotazioni as p
        inner join inviti as i on p.id = i.prenotazione
        group by p.id
    ) as imin on i.created_at = imin.min
    EOF;

    private $q = [
        'cliente' => <<<'EOF'
        EOF,
        'ristoratore' => <<<'EOF'
        select
            r.id as r_id,
            n.significato,
            n.lettura,
        from notifiche as n
        left join (PRENOTAZIONIRISTORATORICLIENTE) as p
            on p.prenotazione_id = n.prenotazione
            and n.significato = 'PRENOTAZIONE CREATA'
        left join () as
        EOF,
    ];
    public function notifiche($id,$tipo){
        $return = DB::select($this->q[$tipo],[$id]);
        foreach ($return as $a) {
            DB::update('update notifiche as n set n.lettura = "LETTO" where n.id = ? ;',[$a['id']]);
        }
        return response()->json($return, 200);
    }

    public function count($id,$tipo){
        $return = DB::select("select count(*) as c from ({$this->q[$tipo]}) as n where n.lettura = 'NON LETTO';",[$id])[0]['c'];
        return response()->json($return, 200);
    }
}
