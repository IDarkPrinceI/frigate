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


//главная страница
Route::get('/', 'MainController@index')->name('main.index');
//Route::get('/create', 'MainController@create')->name('main.create');


Route::get('/create', 'CheckController@create')->name('check.create');
Route::post('/store', 'CheckController@store')->name('check.store');
Route::get('/edit/{id}', 'CheckController@edit')->name('check.edit');
Route::post('/update/{id}', 'CheckController@update')->name('check.update');
Route::delete('/dell/{id}', 'CheckController@dell')->name('check.dell');
Route::get('/dell/{id}', 'CheckController@dell')->name('check.dell');
Route::get('/search', 'CheckController@search')->name('check.search');

