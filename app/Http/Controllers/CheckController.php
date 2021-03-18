<?php

namespace App\Http\Controllers;

use App\Models\Check;
use App\Models\CheckObject;
use App\Models\Control;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CheckController extends MainController
{
    public function create()
    {
        $objects = CheckObject::query()
            ->get();
        $controls = Control::query()
            ->get();
        return view('check.create', compact('objects', 'controls'));
    }


    public function store(Request $request)
    {
        $check = new Check();
        $check->object_id = $request->object;
        $check->control_id = $request->control;
        $dateStart = Carbon::parse($request->date_start);
        $dateFinish = Carbon::parse($request->date_finish);
        $dif = $dateFinish->diff($dateStart)->days;
        $check->date_start = Carbon::parse($dateStart)->format('d.m.Y');
        $check->date_finish = Carbon::parse($dateFinish)->format('d.m.Y');
        $check->lasting = $dif;
        $check->save();
        return redirect()->route('main.index');
    }

    public function edit($id)
    {
        $check = Check::query()
            ->find($id);
        $objects = CheckObject::query()
            ->get();
        $controls = Control::query()
            ->get();
        return view('check.edit', compact('check', 'objects', 'controls'));
    }


    public function update($id, Request $request)
    {
        $check = Check::query()
            ->find($id);
        $check->object_id = $request->object;
        $check->control_id = $request->control;
        $dateStart = Carbon::parse($request->date_start);
        $dateFinish = Carbon::parse($request->date_finish);
        $dif = $dateFinish->diff($dateStart)->days;
        $check->date_start = Carbon::parse($dateStart)->format('d.m.Y');
        $check->date_finish = Carbon::parse($dateFinish)->format('d.m.Y');
        $check->lasting = $dif;
        $check->update();
        return redirect()->route('main.index');
    }


    public function dell($id)
    {
        $check = Check::query()
            ->find($id);
        $check->delete();
    }


    public function search(Request $request) //поиск
    {
        $q = ($request->get('q'));
        $wordsSearch = Check::cleanSearchString($q); //очищаем поисковый запрос
        $checks = Check::getChecksToSearch($wordsSearch); //делаем выборку из реестра
        $checksForExcel = $checks->map(function ($item) { //дублируем коллекцию
           return $item;
        });
        $checksForExcel = Check::unsetRelevance($checksForExcel);//изменяем коллекцию для Excel
        Session::put('search', $checksForExcel); //загрузка данных поиска в сессию для экспорта в Excel

        return view('index', compact('checks', 'wordsSearch'));
    }
}
