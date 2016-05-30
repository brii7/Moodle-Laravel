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


        if(\App\User::all()->isEmpty()){

            return view('firstSetup');
            
        }
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
        $user = Auth::user();
        return view('home',[
            'user' => $user,
        ]);
    }
}]);

// Rutes d'autentificació, login, logout, i register.
Route::get('auth/login', ['as' => 'login', 'uses' => 'Auth\AuthController@getLogin']);
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', ['as' => 'logout', 'uses' => 'Auth\AuthController@logout']);


// Rutes d'aministradors
Route::group(['prefix' => 'admin'], function () {
    
    Route::get('/users', array('as' => 'users', 'uses' => 'AdminController@userList'));
    Route::get('/users/create', array('as' => 'users.create', 'uses' => 'AdminController@formUser'));
    Route::post('/users/create', array('as' => 'users.createpost', 'uses' => 'AdminController@createUser'));
    Route::delete('/users/delete/{id}', array('as' => 'users.delete', 'uses' => 'AdminController@deleteUser'));
    //Datatables
    Route::controller('users/datatables', 'DatatablesController', [
        'anyData'  => 'datatables.data',
        'getIndex' => 'datatables',
    ]);

});

// Rutes d'usuaris
Route::get('/notes', array('as' => 'users.notes', 'uses' => 'UserController@notes'));

// Rutes de cursos
Route::get('/cursos', ['as' => 'cursos', 'uses' => 'CursController@index']);
Route::group(['prefix' => 'cursos'], function () {
    Route::get('/new', array('as' => 'cursos.new', 'uses' => 'CursController@createForm'));
    Route::post('/new', array('as' => 'cursos.newpost', 'uses' => 'CursController@create'));
    Route::delete('/delete/{id}', array('as' => 'cursos.delete', 'uses' => 'CursController@delete'));
    Route::get('/{id}/show', array('as' => 'cursos.show', 'uses' => 'CursController@show'));
    Route::post('/{id}/edit', array('as' => 'cursos.edit', 'uses' => 'CursController@edit'));
    Route::delete('/{id}/{uf_id}/delete', array('as' => 'cursos.uf.delete', 'uses' => 'CursController@deleteUF'));
    Route::post('/{id}/{uf_id}/edit', array('as' => 'cursos.uf.edit', 'uses' => 'CursController@editUF'));
    Route::post('/{id}/show', array('as' => 'cursos.apunt.create', 'uses' => 'ApuntsController@create'));
    Route::delete('/{id}/{uf_id}/{apunt_id}/delete', array('as' => 'cursos.apunt.delete', 'uses' => 'ApuntsController@delete'));
    Route::get('/{id}/{uf_id}/task/{task_id}/show', array('as' => 'cursos.task.show', 'uses' => 'TaskController@show'));
    Route::post('/{id}/{uf_id}/task/{task_id}/show', array('as' => 'cursos.task.entregar', 'uses' => 'TaskController@entregar'));
    Route::post('/{id}/{uf_id}/task/{task_id}/edit', array('as' => 'cursos.task.edit', 'uses' => 'TaskController@edit'));
    Route::delete('/{id}/{uf_id}/task/{task_id}/delete', array('as' => 'cursos.task.delete', 'uses' => 'TaskController@delete'));
    Route::get('/{id}/{uf_id}/task/{task_id}/entregables', array('as' => 'cursos.task.entregables', 'uses' => 'TaskController@entregables'));
    Route::post('/{id}/{uf_id}/task/{task_id}/entregables', array('as' => 'cursos.task.corregir', 'uses' => 'TaskController@corregir'));
    Route::get('/{id}/{uf_id}/tasks/add', array('as' => 'cursos.task.createForm', 'uses' => 'TaskController@createForm'));
    Route::post('/{id}/{uf_id}/tasks/add', array('as' => 'cursos.task.create', 'uses' => 'TaskController@create'));
    Route::get('/{id}/newuf', array('as' => 'cursos.newuf', 'uses' => 'CursController@createUFForm'));
    Route::post('/{id}/newuf', array('as' => 'cursos.newufpost', 'uses' => 'CursController@createUF'));
    Route::post('/{id}/inscriure', array('as' => 'cursos.inscriure', 'uses' => 'CursController@inscriure'));
    Route::post('/{id}/esborrar', array('as' => 'cursos.esborrar', 'uses' => 'CursController@anularInscripcio'));
    Route::get('/users', array('as' => 'cursos.users', 'uses' => 'CursController@userList'));
    Route::get('/users/add', array('as' => 'cursos.createuser', 'uses' => 'CursController@formUser'));
    Route::post('/users/add', array('as' => 'cursos.createuserpost', 'uses' => 'CursController@createUser'));
});