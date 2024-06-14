<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ordinazione;
use Illuminate\Http\Request;

use DB;

class NotificheController extends Controller
{

    private $query_notifiche_ristoratore = <<<'EOF'
    select * from
    (
      (
          select n.id, n.lettura, n.significato, n.created_at, r.id as r_id, p.id as p_id, c.nome as c_nome, null as pz_nome
          from notifiche as n
          inner join prenotazioni as p on n.prenotazione = p.id
          inner join ristoratori as r on r.id = p.ristoratore
          inner join inviti as i on i.prenotazione = p.id
          inner join clients as c on c.id = i.cliente
          inner join (
            select p.id as pid, min(i.created_at) as cmin
            from inviti as i
            inner join prenotazioni as p on p.id = i.prenotazione
            group by p.id
          ) as uniq on i.created_at = uniq.cmin and p.id = uniq.pid
          where significato = 'PRENOTAZIONE CREATA'
      )
      union all
      (
          select n.id, n.lettura, n.significato, n.created_at, r.id as r_id, p.id as p_id, null as c_nome, null as pz_nome
          from notifiche as n
          inner join prenotazioni as p on n.prenotazione = p.id
          inner join ristoratori as r on r.id = p.ristoratore
          where significato = 'PRENOTAZIONE CONTO'
      )
      union all
      (
          select n.id, n.lettura, n.significato, n.created_at, r.id as r_id, p.id as p_id, c.nome as c_nome, pz.nome as pz_nome
          from notifiche as n
          inner join ordinazioni as o on n.ordinazione = o.id
          inner join inviti as i on o.invito = i.id
          inner join prenotazioni as p on i.prenotazione = p.id
          inner join ristoratori as r on r.id = p.ristoratore
          inner join clients as c on c.id = i.cliente
          inner join pietanze as pz on pz.id = o.pietanza
          where significato = 'ORDINAZIONE PAGATA'
          or significato = 'ORDINAZIONE CREATA'
      )
      union all
      (
          select n.id, n.lettura, n.significato, n.created_at, r.id as r_id, p.id as p_id, c.nome as c_nome, null as pz_nome
          from notifiche as n
          inner join inviti as i on n.invito = i.id
          inner join prenotazioni as p on i.prenotazione = p.id
          inner join ristoratori as r on r.id = p.ristoratore
          inner join clients as c on c.id = i.cliente
          where significato = 'INVITO PAGATO'
      )
    ) as notifiche_ristoratori
    where r_id = ?
    order by created_at desc
    EOF;

    private $query_notifiche_cliente = <<<'EOF'
    select * from (
      (
        select n.id, n.lettura, n.significato, n.created_at, c.id as c_id, p.id as p_id, p.stato as p_stato, null as i_nome, r.nome as r_nome
        from notifiche as n
        inner join prenotazioni as p on p.id = n.prenotazione
        inner join inviti as i on p.id = i.prenotazione
        inner join clients as c on c.id = i.cliente
        inner join ristoratori as r on r.id = p.ristoratore
        where n.significato = 'PRENOTAZIONE STATO'
      )
      union all
      (
        select n.id, n.lettura, n.significato, n.created_at, c.id as c_id, p.id as p_id, null as p_stato, invitato.nome as i_nome, null as r_nome
        from notifiche as n
        inner join inviti as i on i.id = n.invito
        inner join clients as invitato on invitato.id = i.cliente
        inner join prenotazioni as p on i.prenotazione = p.id
        inner join inviti as ii on p.id = ii.prenotazione
        inner join clients as c on c.id = ii.cliente
        where n.significato = 'INVITO ACCETTATO'
        and c.id != invitato.id
      )
    ) as notifiche_clienti
    where c_id = ?
    order by created_at desc
    EOF;

    private function _notifiche($id,$tipo){
        return DB::select(match($tipo){
            'cliente'       => $this->query_notifiche_cliente,
            'ristoratore'   => $this->query_notifiche_ristoratore
        },[$id]);
    }

    public function notifiche($tipo,$id){
        $return = $this->_notifiche($id,$tipo);
        foreach ($return as $a) {
            DB::update('update notifiche as n set lettura = "LETTO" where id = ? ;',[$a->id]);
        }
        return response()->json($return, 200);
    }

    public function count($tipo,$id){
        $return = count($this->_notifiche($id,$tipo));
        return response()->json(['count' => $return], 200);
    }
}
