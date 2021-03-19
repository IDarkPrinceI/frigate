<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


//Route::get('/', 'MainController@index')->name('main.index');

//Проверки
Route::get('/', 'CheckController@index')->name('main.index'); //главная страница
Route::get('/create', 'CheckController@create')->name('check.create'); //страница добавления
Route::post('/store', 'CheckController@store')->name('check.store'); //добавить
Route::get('/edit/{id}', 'CheckController@edit')->name('check.edit'); //страница редактирования
Route::post('/update/{id}', 'CheckController@update')->name('check.update'); //обновить
Route::delete('/dell/{id}', 'CheckController@dell')->name('check.dell'); //удалить
//Route::get('/dell/{id}', 'CheckController@dell')->name('check.dell');
Route::get('/search', 'CheckController@search')->name('check.search');
//Route::get('/object/', 'CheckController@object')->name('check.object');
Route::get('/object/{data}', 'CheckController@object')->name('check.object');
//Excel
Route::get( '/export' , 'MaatwebsiteController@export')->name('exportExcel');
Route::get( '/import' , 'MaatwebsiteController@import')->name('importExcel');


