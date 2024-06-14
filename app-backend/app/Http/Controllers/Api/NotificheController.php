<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ordinazione;
use Illuminate\Http\Request;

use DB;

class NotificheController extends Controller
{

    private function _notifiche($id,$tipo){
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
            where i.id = ? and iiv.id = ?
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
            'PRENOTAZIONE STATO'     => $appendreturn($a,$getbyprenotazione($a->prenotazione)),
            'PRENOTAZIONE CONTO'     => $appendreturn($a,$getbyprenotazione($a->prenotazione)),
            'PRENOTAZIONE CANCELLATA'=> $appendreturn($a,$getbyprenotazione($a->prenotazione)),
            'INVITO ACCETTATO'       => $appendreturn($a,$getbyinvitoaccettato($a->invito, $id)),
            'INVITO PAGATO'          => $appendreturn($a,$getbyinvito($a->invito)),
            'ORDINAZIONE CREATA'     => $appendreturn($a,$getbyordinazione($a->ordinazione)),
            'ORDINAZIONE CANCELLATA' => $appendreturn($a,$getbyordinazione($a->ordinazione)),
            'ORDINAZIONE PAGATA'     => $appendreturn($a,$getbyordinazione($a->ordinazione)),
        },$return);
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
            DB::update('update notifiche as n set n.lettura = "LETTO" where n.id = ? ;',[$a->id]);
        }
        return response()->json($return, 200);
    }

    public function count($tipo,$id){
        $return = count($this->_notifiche($id,$tipo));
        return response()->json($return, 200);
    }
}
