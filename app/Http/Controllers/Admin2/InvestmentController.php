<?php

namespace App\Http\Controllers\Admin2;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InvestmentController extends Controller
{
    public function index()
    {
        return view('admin.investment2.index');
    }
}
