<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB;

class NotificheController extends Controller
{
    private $q = [
        'cliente' => <<<'EOF'
        EOF,
        'ristoratore' => <<<'EOF'
        EOF,
    ];
    public function notifiche($id,$tipo){
        $return = DB::select($this->q[$tipo],[$id]);
        foreach ($return as $a) {
            DB::update('update notifiche as n set n.lettura = "LETTO" where n.id = ? ;',[$a]);
        }
        return response()->json($return, 200);
    }

    public function count($id,$tipo){
        $return = DB::select("select count(*) as c from ({$this->q[$tipo]})",[$id])[0]['c'];
        return response()->json($return, 200);
    }
}
