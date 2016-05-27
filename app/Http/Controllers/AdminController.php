<?php

namespace App\Http\Controllers;

use App\Curs;
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

    public function deleteUser($id){



        if(Auth::guest()){
            return Redirect::route('dashboard')
                ->with('type_message', "warning")
                ->with('message', 'Nice try.');
        }

        $user = User::find($id);
        $boolean = true;
        if(Auth::user()->isAdmin()){
            $cursos = Curs::all();
            foreach ($cursos as $curs){
                
                $teacher_id = $curs->teacherid();
                if($user->id == $teacher_id){
                    $curs = $curs->name;
                    $boolean = false;
                }
                
            }
            if($boolean){
                $user->delete();
                $type_message = 'success';
                $message = 'Usuari esborrat correctament';
            }else{
                $type_message = 'warning';
                $message = "Aquest usuari està registrat com a professor al curs ".$curs.", tria un altre professor per al curs
                i després torna a provar d'esborrar el professor.";
            }
            return Redirect::route('users')
                ->with('type_message', $type_message)
                ->with('message', $message);
        }else{
            return Redirect::route('dashboard')
                ->with('type_message', "warning")
                ->with('message', 'Nice try.');
        }
    }
}
