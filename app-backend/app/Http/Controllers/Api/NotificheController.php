<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificheController extends Controller
{
    public function notifiche($id,$tipo){
        $return = [];
        return response()->json($return, 200);
    }

    public function count($id,$tipo){
        $return = [];
        return response()->json($return, 200);
    }
}
