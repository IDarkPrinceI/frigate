<?php

namespace App\Http\Controllers;

use App\Models\Check;
use Illuminate\Http\Request;

class CheckController extends MainController
{
    public function create()
    {
        return view('check.create');
    }


    public function store(Request $request)
    {
        $check = new Check();
        $check->object = $request->object;
        $check->control = $request->control;
        $check->date_start = $request->date_start;
        $check->date_finish = $request->date_finish;
        $check->save();
        return redirect()->route('main.index');
    }

    public function edit($id)
    {
        $check = Check::query()
            ->find($id);
        return view('check.edit', compact('check'));
    }


    public function update($id, Request $request)
    {
        $check = Check::query()
            ->find($id);
        $check->object = $request->object;
        $check->control = $request->control;
        $check->date_start = $request->date_start;
        $check->date_finish = $request->date_finish;
        $check->update();
        return redirect()->route('main.index');
    }


    public function dell($id)
    {
        $check = Check::query()
            ->find($id);
        $check->delete();
    }
}
