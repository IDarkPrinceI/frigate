<?php

namespace App\Http\Controllers;


use App\Models\Check;
use Illuminate\Http\Request;

class MainController extends Controller
{
    //главная страница
    public function index()
    {
       $checks = Check::query()
           ->paginate(15);
//       dd($test);
        return view('index', compact('checks'));
    }


}
