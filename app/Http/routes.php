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

// Rutes d'aministradors
Route::group(['prefix' => 'admin'], function () {
    Route::get('/users', array('as' => 'users', 'uses' => 'AdminController@userList'));
    Route::get('/users/create', array('as' => 'users.create', 'uses' => 'AdminController@formUser'));
    Route::post('/users/create', array('as' => 'users.createpost', 'uses' => 'AdminController@createUser'));
});

// Rutes de cursos
Route::get('/cursos', ['as' => 'cursos', 'uses' => 'CursController@index']);
Route::group(['prefix' => 'cursos'], function () {
    Route::get('/new', array('as' => 'cursos.new', 'uses' => 'CursController@createForm'));
    Route::post('/new', array('as' => 'cursos.newpost', 'uses' => 'CursController@create'));
    Route::delete('/delete/{id}', array('as' => 'cursos.delete', 'uses' => 'CursController@delete'));
    Route::get('/{id}/show', array('as' => 'cursos.show', 'uses' => 'CursController@show'));
    Route::get('/{id}/tasks/{uf_id}/show', array('as' => 'cursos.task.show', 'uses' => 'CursController@showUFTask'));
    Route::get('/{id}/tasks/{uf_id}/add', array('as' => 'cursos.task.add', 'uses' => 'CursController@addUFTask'));
    Route::get('/{id}/newuf', array('as' => 'cursos.newuf', 'uses' => 'CursController@createUFForm'));
    Route::post('/{id}/newuf', array('as' => 'cursos.newufpost', 'uses' => 'CursController@createUF'));
    Route::post('/{id}/inscriure', array('as' => 'cursos.inscriure', 'uses' => 'CursController@inscriure'));
    Route::post('/{id}/esborrar', array('as' => 'cursos.esborrar', 'uses' => 'CursController@anularInscripcio'));
    Route::get('/users', array('as' => 'cursos.users', 'uses' => 'CursController@userList'));
    Route::get('/users/add', array('as' => 'cursos.createuser', 'uses' => 'CursController@formUser'));
    Route::post('/users/add', array('as' => 'cursos.createuserpost', 'uses' => 'CursController@createUser'));
});