<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    //
    public function home(){
        return response()->json(['success' => "now in home"], 200);
    }
}
