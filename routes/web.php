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

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Backend\BackendRequestHandler;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/panel.php', function () {
    return view('layouts/panel', ['username'=>Auth::user(), 'userid'=>Auth::id(), 'pendingappeals'=>0, 'runningservers'=>1, 'last24errors'=>0, 'supportrequests'=>0, 'dtdev'=>"2.3 Developer"]);
})->middleware('auth');

Route::get('/server/backend.php', function (Request $request) {
  BackendRequestHandler::HandleRequest($request);
});

Route::post('/server/backend.php', function (Request $request) {
  BackendRequestHandler::HandleRequest($request);
});

Route::get('/login', 'Auth\LoginController@showLoginForm');
Route::post('/login', 'Auth\LoginController@authenticate');
Route::get('/login.php', 'Auth\LoginController@showLoginForm');
Route::post('/login.php', 'Auth\LoginController@authenticate');
Route::get('/signout.php', 'Auth\LoginController@logout');

Route::get('/signup.php', 'Auth\RegisterController@showRegistrationForm');
Route::post('/signup.php', 'Auth\RegisterController@register');

Route::get('reset.php/token{token?}', 'Auth\PasswordController@showResetForm');
Route::post('reset.php/email', 'Auth\PasswordController@sendResetLinkEmail');
Route::post('reset.php/reset', 'Auth\PasswordController@reset');
