<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreChecksRequest;
use App\Models\Check;
use App\Models\CheckObject;
use App\Models\Control;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CheckController extends Controller
{
    //главная страница
    public function index()
    {
        $checks = Check::query()
            ->with('control', 'object') //жадная загрузка
            ->paginate(15);
        return view('index', compact('checks'));
    }

    //страница добавления
    public function create()
    {
        $objects = CheckObject::getCheckObjects(); //СМП для выпадающего списка
        $controls = Control::getControls(); //Контроли для выпадающего списка
        return view('check.create', compact('objects', 'controls'));
    }


//    public function store(Request $request) //сохранение записи
    public function store(StoreChecksRequest $request) //сохранение записи
    {
        $check = new Check();
        $check = Check::writeAttribute($check, $request); //запись атрибутов
        $check->save();
        return redirect()->route('main.index');
    }


    public function edit($id) //страница редактирования записи
    {
        $check = Check::getCheck($id); //получение записи проверки
        $objects = CheckObject::getCheckObjects(); //СМП для выпадающего списка
        $controls = Control::getControls(); //Контроли для выпадающего списка
        return view('check.edit', compact('check', 'objects', 'controls'));
    }


    public function update($id, StoreChecksRequest $request) //обновление записи
    {
        $check = Check::getCheck($id); //получение записи проверки
        $check = Check::writeAttribute($check, $request); //запись атрибутов
        $check->update();
        return redirect()->route('main.index');
    }


    public function dell($id) //удаление
    {
        $check = Check::getCheck($id);
        $check->delete();
    }


    public function search(Request $request) //поиск
    {
        $q = $request->get('q');
        $wordsSearch = Check::cleanSearchString($q); //очищаем поисковый запрос
        $checks = Check::getChecksToSearch($wordsSearch); //делаем выборку из реестра
        if (is_string($checks)) {
            return view('index', compact('checks', 'wordsSearch'));
        }
        $checksForExcel = $checks->map(function ($item) { //дублируем коллекцию
            return $item;
        });
        $checksForExcel = Check::unsetRelevance($checksForExcel);//изменяем коллекцию для Excel
        Session::put('search', $checksForExcel); //загрузка данных поиска в сессию для экспорта в Excel
        return view('index', compact('checks', 'wordsSearch'));
    }


    public function include(Request $request) //построение выпадающего списка СМП и Контролирующих органов
    {
        $data = $request->get('data'); //получения введенных данных
        $type = $request->get('type'); //получения типа для определения модели
        $data = Check::cleanSearchString($data); //обработка введенного запроса
        if ($data == null) { //если input пуст
            $data = 'Введите название';
        } elseif ($type === 'object') { //если формируется выпадающий список СМП
            $html = CheckObject::searchCheckObjects($data); //строим выпадающий список СМП
        } else {
            $html = Control::searchControls($data); //строим выпадающий список Контролей
        }
        return response()->json(compact('html')); // возвращаем ответ для обновления части страницы
    }
}
