<?php

namespace App\Http\Controllers\Home;

use App\Http\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TurnController extends Controller
{
    public function index()//
    {   

        dd('暂未开放');
 
       return view('home.turn.index'); 
    }

}
