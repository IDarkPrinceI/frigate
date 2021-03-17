<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckObjectController extends MainController
{
    public function add()
    {
        return view('checkObject.create');
    }
}
