<?php

namespace App\Http\Controllers;


use App\Models\Check;
use Illuminate\Http\Request;

class MainController extends Controller
{
    //главная страница
    public function index()
    {
        $query = Check::query();
        $checks = Check::paginateQuery($query);
        return view('index', compact('checks'));
    }


}
