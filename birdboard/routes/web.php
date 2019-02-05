<?php

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

Route::get('/', function () {
    return view('welcome');
});

//this is one way to apply middleware to a set of routes. This can also be done in the constructor of Controllers (HomeController has this).
Route::group(['middleware'=>'auth'], function () {
    Route::get('/projects', 'ProjectsController@index');
    Route::get('/projects/{project}', 'ProjectsController@show');
    Route::post('/projects', 'ProjectsController@store');

    Route::get('/home', 'HomeController@index')->name('home');
});

Auth::routes();
