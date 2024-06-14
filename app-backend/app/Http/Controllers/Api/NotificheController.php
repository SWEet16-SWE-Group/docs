<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ordinazione;
use Illuminate\Http\Request;

use DB;

class NotificheController extends Controller
{

    private $query_norifiche_ristoratore = <<<'EOF'
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

    private $query_norifiche_cliente = <<<'EOF'
    select * from (
      (
        select n.id, n.lettura, n.significato, n.created_at, c.id as c_id, p.id as p_id, null as i_nome, r.nome as r_nome
        from notifiche as n
        inner join prenotazioni as p on p.id = n.prenotazione
        inner join inviti as i on p.id = i.prenotazione
        inner join clients as c on c.id = i.cliente
        inner join ristoratori as r on r.id = p.ristoratore
        where n.significato = 'PRENOTAZIONE STATO'
      )
      union all
      (
        select n.id, n.lettura, n.significato, n.created_at, c.id as c_id, p.id as p_id, invitato.nome as i_nome, null as r_nome
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
        $id_e = $id;
        $return = DB::select('select * from notifiche');
        $getbyprenotazione = fn ($id) => DB::select(<<<'EOF'
            select
                r.id as r_id,
                c.id as c_id,
                r.nome as r_nome,
                c.nome as c_nome
            from inviti as i
            inner join clients as c on c.id = i.cliente
            inner join prenotazioni as p on p.id = i.prenotazione
            inner join ristoratori as r on r.id = p.ristoratore
            inner join (
                select p.id, min(i.created_at) as c
                from prenotazioni as p
                inner join inviti as i on p.id = i.prenotazione
                group by p.id
            ) as imin on i.created_at = imin.c
            where p.id = ?
            limit 1
        EOF,[$id]);
        $getbyprenotazionestato = fn ($id) => DB::select(<<<'EOF'
            select
                r.id as r_id,
                c.id as c_id,
                r.nome as r_nome,
                c.nome as c_nome
            from prenotazioni as p
            inner join inviti as i on p.id = i.prenotazione
            inner join clients as c on c.id = i.cliente
            inner join ristoratori as r on r.id = p.ristoratore
            where p.id = ? and c.id = ?
            limit 1
        EOF,[$id, $id_e]);
        $getbyinvitoaccettato = fn ($id, $ic) => DB::select(<<<'EOF'
            select
                -1 as r_id,
                iiv.id as c_id,
                iv.nome as c_nome,
                p.id as p_id
            from inviti as i
            inner join clients as iv on iv.id = i.cliente
            inner join prenotazioni as p on p.id = i.prenotazione
            inner join inviti as iiv on iiv.prenotazione = p.id
            where i.id = ? and iiv.id = ? and iv.id != iiv.id
            limit 1
        EOF,[$id, $ic]);
        $getbyinvito = fn ($id) => DB::select(<<<'EOF'
            select
                r.id as r_id,
                c.id as c_id,
                c.nome as c_nome,
                p.id as p_id
            from inviti as i
            inner join clients as c on c.id = i.cliente
            inner join prenotazioni as p on p.id = i.prenotazione
            inner join ristoratori as r on r.id = p.ristoratore
            where i.id = ?
            limit 1
        EOF,[$id]);
        $getbyordinazione = fn ($id) => DB::select(<<<'EOF'
            select
                r.id as r_id,
                c.id as c_id,
                c.nome as c_nome,
                pz.nome as pz_nome,
                p.id as p_id
            from inviti as i
            inner join clients as c on c.id = i.cliente
            inner join ordinazioni as o on i.id = o.invito
            inner join pietanze as pz on pz.id = o.pietanza
            inner join prenotazioni as p on p.id = i.prenotazione
            inner join ristoratori as r on r.id = p.ristoratore
            where o.id = ?
            limit 1
        EOF,[$id]);
        $appendreturn = function ($a,$v) { $a->d = $v; return $a;};
        $return = array_map(fn ($a) => match($a->significato) {
            'PRENOTAZIONE CREATA'    => $appendreturn($a,$getbyprenotazione($a->prenotazione)),
            'PRENOTAZIONE STATO'     => $appendreturn($a,$getbyprenotazionestato($a->prenotazione)),
            'PRENOTAZIONE CONTO'     => $appendreturn($a,$getbyprenotazionestato($a->prenotazione)),
            'PRENOTAZIONE CANCELLATA'=> $appendreturn($a,$getbyprenotazionestato($a->prenotazione)),
            'INVITO ACCETTATO'       => $appendreturn($a,$getbyinvitoaccettato($a->invito, $id)),
            'INVITO PAGATO'          => $appendreturn($a,$getbyinvito($a->invito)),
            'ORDINAZIONE CREATA'     => $appendreturn($a,$getbyordinazione($a->ordinazione)),
            'ORDINAZIONE CANCELLATA' => $appendreturn($a,$getbyordinazione($a->ordinazione)),
            'ORDINAZIONE PAGATA'     => $appendreturn($a,$getbyordinazione($a->ordinazione)),
        },$return);
        print_r(['tipo' => $tipo, 'data' => $return]);
        $return = array_filter($return, fn ($a) => $a->d);
        foreach($return as &$a){
            $a->d = $a->d[0];
        }
        $return = array_filter($return, fn ($a) => match($tipo){
            'cliente'       => $a->d->c_id == $id,
            'ristoratore'   => $a->d->r_id == $id,
        });
        return $return;
    }

    public function notifiche($tipo,$id){
        $return = $this->_notifiche($id,$tipo);
        foreach ($return as $a) {
            DB::update('update notifiche as n set lettura = "LETTO" where id = ? ;',[$a->id]);
        }
        return response()->json($return, 200);
    }

    public function count($tipo,$id){
        ob_start();
        $return = count($this->_notifiche($id,$tipo));
        ob_end_clean();
        return response()->json(['count' => $return], 200);
    }
}
