<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Allergeni;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AllergeniController extends Controller
{
    public function index() : Response {
        $allergeni=Allergeni::get()->all();
       return response($allergeni);
    }
}
