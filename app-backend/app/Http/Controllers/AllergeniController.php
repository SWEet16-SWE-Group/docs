<?php

namespace App\Http\Controllers;

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
