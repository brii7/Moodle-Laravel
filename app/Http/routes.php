<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/',['as' => 'welcome', function () {

    if(Auth::guest()) {
        return view('welcome');
    }
    else {
        return Redirect::route('dashboard');
    }
}]);
Route::get('/home',['as' => 'dashboard', function() {
    
    if(Auth::guest()) {
        return view('welcome');
    }
    else {
        return view('home');
    }
}]);

// Rutes d'autentificació, login, logout, i register.
Route::get('auth/login', ['as' => 'login', 'uses' => 'Auth\AuthController@getLogin']);
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', ['as' => 'logout', 'uses' => 'Auth\AuthController@logout']);
Route::get('auth/register', ['as' => 'register', 'uses' => 'Auth\AuthController@getRegister']);
Route::post('auth/register', 'Auth\AuthController@postRegister');


Route::group(['prefix' => 'admin'], function () {
    Route::get('/users', array('as' => 'users', 'uses' => 'AdminController@userList'));
    Route::get('/users/create', array('as' => 'users.create', 'uses' => 'AdminController@formUser'));
    Route::post('/users/create', array('as' => 'users.create', 'uses' => 'AdminController@createUser'));
});