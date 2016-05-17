<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Input;
use App\Curs;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class CursController extends Controller
{
    public function index(){

        $user = Auth::user();
        $mycursos = $user->cursos();
        $cursos = Curs::all();
        return view('cursos.index',
            [
               'cursos' => $cursos,
                'mycursos' => $mycursos,
            ]);
    }

    public function createForm(){

        $professors = User::where('role','=','teacher')->get();
        return view('cursos.create', [
            'professors' => $professors,
        ]);

    }

    public function create(){

        $input = Input::all();
        Curs::create($input);
        return Redirect::route('cursos')->with('message',"Curs creat correctament");

    }

    public function delete($id){

        if(Auth::guest()){
            return Redirect::route('dashboard')
                ->with('type_message', "warning")
                ->with('message', 'Nice try.');
        }

        $user = Auth::user();
        if($user->isAdmin()){
            Curs::find($id)->delete();
            return Redirect::route('cursos')
                ->with('message','Curs esborrat correctament');
        }else{
            return Redirect::route('dashboard')
                ->with('type_message', "warning")
                ->with('message', 'Nice try.');
        }

    }

    public function inscriure($id){

        $user = Auth::user();
        $curs = Curs::find($id);

        if($curs->members->contains($user->id)){

            return Redirect::route('cursos')
                ->with('type_message', "danger")
                ->with('message', 'Ja estàs inscrit a aquest curs');

        }

        try{

            $curs->members()->attach($user->id);
        }catch (Illuminate\Database\QueryException $e) {

            return Redirect::route('cursos')
                ->with('type_message', "danger")
                ->with('message', 'Error al inscriure al curs');
        }

        return Redirect::route('cursos')
            ->with('type_message', "success")
            ->with('message', 'Inscrit correctament');

    }

    public function anularInscripcio($id){

        $user = Auth::user();
        $curs = Curs::find($id);

        if(!$curs->members->contains($user->id)){

            return Redirect::route('cursos')
                ->with('type_message', "danger")
                ->with('message', 'No estàs inscrit a aquest curs');

        }

        $curs->members()->detach($user->id);

        return Redirect::route('cursos')
            ->with('type_message', "success")
            ->with('message', 'Inscripció anul·lada correctament');

    }

    public function show($id){

        $curs = Curs::find($id);

        return view('cursos.show')
            ->with('curs',$curs);

    }
}

