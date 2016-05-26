<?php

namespace App\Http\Controllers;

use App\Curs;
use App\Task;
use App\UnitatFormativa;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use DB;

class TaskController extends Controller
{
    public function show($id, $uf_id, $task_id){

        $curs = Curs::find($id);
        $uf = UnitatFormativa::find($uf_id);
        $tasca = Task::find($task_id);
        $entregable = DB::table('user_task')
            ->where('user_id', Auth::user()->id)
            ->where('task_id', $tasca->id)
            ->get();

        if(empty($entregable)){
            $entregat = false;
        }else{
            $entregat = true;
        }



        return view('cursos.showUFTask', [
            'curs' => $curs,
            'uf' => $uf,
            'tasca' => $tasca,
            'entregable' => $entregable,
            'entregat' => $entregat,
        ]);

    }

    public function createForm($id, $uf_id){

        $curs = Curs::find($id);
        $uf = UnitatFormativa::find($uf_id);

        return view('cursos.createUFTask',[
            'curs' => $curs,
            'uf'   => $uf,
        ]);

    }

    public function create($id, $uf_id, Request $request){

        $input = Input::all();
        $filename = "";
        if($request->hasFile('file')){
            $file = $request->file('file');
            $destinationpath = '/tasques/'. $id . '/'. $uf_id;
            $extension = $file->getClientOriginalExtension();
            $filename = time().rand(11111, 99999) . '.' . $extension;
            $file->move(public_path() . $destinationpath, $filename);
        }
        $tasca = new Task([
            'name' => $input['name'],
            'description' => $input['description'],
            'data_finalització' => $input['data_finalització'],
            'file' => $filename,
            'course_id' => $id,
            'uf_id' => $uf_id,
        ]);
        $tasca->save();

        return Redirect::to(route('cursos.show',$id))
            ->with('message',"Tasca creada correctament");
        
    }

    public function entregables($id, $uf_id, $task_id){

        if(Auth::guest() || Auth::user()->isStudent()){
            return route('dashboard')->with('message','Nice try');
        }

        $curs = Curs::find($id);
        $uf = UnitatFormativa::find($uf_id);
        $tasca = Task::find($task_id);
        $entregables = DB::table('user_task')->where('task_id',$task_id)->get();
        $alumnes = array();

        foreach($entregables as $entregable){
            array_push($alumnes, User::find($entregable->user_id));
        }


        return view('cursos.showTaskEntregables',[
            'curs' => $curs,
            'uf' => $uf,
            'tasca' => $tasca,
            'entregables' => $entregables,
            'alumnes' => $alumnes,
        ]);
        
    }

    public function corregir($id, $uf_id, $task_id){
        
        $input = Input::all();
        $user_id = $input['user_id'];
        $nota = $input['nota'];
        $explicacio = "";
        if(Input::has('explicacio')){
            $explicacio = $input['explicacio'];
        }

        DB::table('user_task')
            ->where('user_id', $user_id)
            ->where('task_id', $task_id)
            ->update(array('nota' => $nota, 'explicacio' => $explicacio, 'corregit' => true));


        $curs = Curs::find($id);
        $uf = UnitatFormativa::find($uf_id);
        $tasca = Task::find($task_id);
        $entregables = DB::table('user_task')->where('task_id',$task_id)->get();
        $alumnes = array();

        foreach($entregables as $entregable){
            array_push($alumnes, User::find($entregable->user_id));
        }

        return view('cursos.showTaskEntregables',[
            'curs' => $curs,
            'uf' => $uf,
            'tasca' => $tasca,
            'entregables' => $entregables,
            'alumnes' => $alumnes,
        ]);
    }

    public function entregar($id, $uf_id, $task_id, Request $request){

        $input = Input::all();
        $user = Auth::user();
        $user_id = $user->id;
        $task = Task::find($task_id);
        $data_limit = $task->data_finalització;
        $now = Carbon::now();
        $entregat_tard = false;
        if($now >= $data_limit){
            $entregat_tard = true;
        }

        $file = $request->file('file');
        $destinationpath = '/tasques/'. $id . '/'. $uf_id . '/' . $task_id;
        $extension = $file->getClientOriginalExtension();
        $filename = time().rand(11111, 99999) . '.' . $extension;
        $file->move(public_path() . $destinationpath, $filename);

        $exists = DB::table('user_task')->where('user_id',$user_id)->where('task_id', $task_id)->get();
        if($exists){
            DB::table('user_task')
                ->where('user_id',$user_id)
                ->where('task_id', $task_id)->update(
                array(
                    'course_id' => $id,
                    'uf_id' => $uf_id,
                    'user_id' => $user_id,
                    'task_id' => $task_id,
                    'file' => $filename,
                    'corregit' => false,
                    'entregat_tard' => $entregat_tard,
                )
            );

        }else{
            DB::table('user_task')->insert(
                array(
                    'course_id' => $id,
                    'uf_id' => $uf_id,
                    'user_id' => $user_id,
                    'task_id' => $task_id,
                    'file' => $filename,
                    'corregit' => false,
                    'entregat_tard' => $entregat_tard,
                )
            );
        }

        return redirect(route('cursos.task.show',array($id, $uf_id, $task_id)))
            ->with('message',"Tasca entregada correctament");

    }

    public function edit($id, $uf_id, $task_id, Request $request){

        $input = Input::all();
        $tasca = Task::find($task_id);

        $tasca->name = $input['name'];
        $tasca->description = $input['description'];
        if($input['data_finalització']!= ""){
            $tasca->data_finalització = $input['data_finalització'];
        }

        if($request->hasFile('file')){
            $file = $request->file('file');
            $destinationpath = '/tasques/'. $id . '/'. $uf_id;
            $extension = $file->getClientOriginalExtension();
            $filename = time().rand(11111, 99999) . '.' . $extension;
            $file->move(public_path() . $destinationpath, $filename);

            $tasca->file = $filename;
        }

        $tasca->save();

        return Redirect::route('cursos.task.show', array($id, $uf_id, $task_id))->with('message', 'Tasca editada correctament');

    }

    public function delete($id, $uf_id, $task_id){

        if(Auth::guest()){
            return Redirect::route('dashboard')
                ->with('type_message', "warning")
                ->with('message', 'Nice try.');
        }

        $user = Auth::user();
        if($user->isAdmin() || $user->isTeacher()){


            Task::find($task_id)->delete();

            DB::table('user_task')->where('task_id', $task_id)->delete();

            return Redirect::route('cursos.show', $id)
                ->with('message','Tasca esborrada correctament');
        }else{
            return Redirect::route('dashboard')
                ->with('type_message', "warning")
                ->with('message', 'Nice try.');
        }

    }
}
