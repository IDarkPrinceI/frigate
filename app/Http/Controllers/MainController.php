<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
    //главная страница
    public function index()
    {
        return view('index');
    }


}
