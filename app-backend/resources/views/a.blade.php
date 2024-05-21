<?php


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

echo json_encode(DB::select('show tables;'));
