<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;

class AdminController extends Controller
{
    public function userList(){
        if(!Auth::check()){
            return Redirect::route('welcome');
        }
        $user = Auth::user();
        $users = User::all();
        if($user->role == 'admin'){
            return view('admin.users', [
                'users' => $users,
            ]);
        }else{
            return Redirect::route('dashboard');
        }
    }
    public function formUser(){

        // No login
        if(!Auth::check()){
            return Redirect::route('welcome');
        }
        $user = Auth::user();
        $users = User::all();
        if($user->isAdmin()){
            return view('admin.usernew');
        }else{
            return Redirect::route('dashboard');
        }

        
    }
    public function createUser(){

        $input = Input::all();
        try{
            User::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'password' => bcrypt($input['password']),
                'role' => $input['role'],
            ]);
        }
        catch(QueryException $q){
            return Redirect::to(route('users.create'))->withInput()->withMessage("La contrassenya ha de ser més gran de 6 caràcters, i el 
            correu no ha d'estar en ús");
        }

        return Redirect::route('users.create')->with('message',"Usuari creat correctament");

    }
}
