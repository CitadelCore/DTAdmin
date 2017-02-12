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

Route::get('/panel.php', function () {
    return view('layouts/panel', ['username'=>'josephmarsden', 'userid'=>1, 'pendingappeals'=>0, 'runningservers'=>1, 'last24errors'=>0, 'supportrequests'=>0, 'dtdev'=>"2.3 Developer"]);
});
