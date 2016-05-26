<?php

namespace App\Http\Controllers;
use App\UnitatFormativa;
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
        $unitatsformatives = $curs->UFs();
        $professors = User::where('role','=','teacher')->get();

        $user = Auth::user();
        $inscrit = $curs->members->contains($user->id);

        if($inscrit || $user->isAdmin() || $user->isTeacher()){
            return view('cursos.show', [
                'curs' => $curs,
                'unitatsformatives' => $unitatsformatives,
                'professors' => $professors,
            ]);
        }

        return Redirect::route('cursos')
            ->with('type_message', "danger")
            ->with('message', 'No estàs inscrit a aquest curs');
    }

    public function edit($id){

        $input = Input::all();
        $curs = Curs::find($id);

        $curs->name = $input['name'];
        $curs->description = $input['description'];
        $curs->teacher_id = $input['teacher_id'];
        $curs->save();

        return Redirect::route('cursos.show', $id)->with('message', 'Curs editat correctament');

    }
    
    public function createUFForm(){

        return view('cursos.createUF');
        
    }

    public function createUF($id){

        $input = Input::all();
        $input['course_id'] = $id;
        UnitatFormativa::create($input);
        return Redirect::route('cursos.show', [$id])->with('message',"Unitat Formativa creada correctament");
        
    }

    public function editUF($id, $uf_id){

        $input = Input::all();
        $uf = UnitatFormativa::find($uf_id);

        $uf->name = $input['name'];
        $uf->description = $input['description'];
        if($input['data_finalització']!= ""){
            $uf->data_finalització = $input['data_finalització'];
        }
        $uf->save();

        return Redirect::route('cursos.show', $id)->with('message', 'Unitat Formativa editada correctament');

    }

    public function deleteUF($id, $uf_id){

        if(Auth::guest()){
            return Redirect::route('dashboard')
                ->with('type_message', "warning")
                ->with('message', 'Nice try.');
        }

        $user = Auth::user();
        if($user->isAdmin() || $user->isTeacher()){
            UnitatFormativa::find($uf_id)->delete();
            return Redirect::route('cursos.show', $id)
                ->with('message','Unitat Formativa esborrada correctament');
        }else{
            return Redirect::route('dashboard')
                ->with('type_message', "warning")
                ->with('message', 'Nice try.');
        }
        
    }

    
}

