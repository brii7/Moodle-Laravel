<?php

namespace App\Http\Controllers;

use App\Curs;
use App\Task;
use App\UnitatFormativa;
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
        $corregit = DB::table('user_task')->where('user_id', Auth::user()->id)->where('task_id', $tasca->id)->pluck('corregit');


        return view('cursos.showUFTask', [
            'curs' => $curs,
            'uf' => $uf,
            'tasca' => $tasca,
            'corregit' => $corregit,
        ]);

    }

    public function createForm($id, $uf_id){

        $curs = Curs::find($id);
        $uf = UnitatFormativa::find($id);

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
        $curs = new Task([
            'name' => $input['name'],
            'description' => $input['description'],
            'data_finalització' => $input['data_finalització'],
            'file' => $filename,
            'course_id' => $id,
            'uf_id' => $uf_id,
        ]);
        $curs->save();

        //TODO: RETURN
        
    }

    public function corregir($user_id, $task_id){

        $input = Input::all();
        $nota = $input['nota'];
        $explicacio = $input['explicacio'];

        DB::table('user_task')->insert(
            array(
                'user_id' => $user_id,
                'task_id' => $task_id,
                'nota' => $nota, 
                'explicacio' => $explicacio,
            )
        );
        
        
    }
    public function entregar($id, $uf_id, $task_id, Request $request){

        $input = Input::all();
        $user = Auth::user();
        $user_id = $user->id;

        $file = $request->file('file');
        $destinationpath = '/tasques/'. $id . '/'. $uf_id . '/' . $task_id;
        $extension = $file->getClientOriginalExtension();
        $filename = time().rand(11111, 99999) . '.' . $extension;
        $file->move(public_path() . $destinationpath, $filename);

        DB::table('user_task')->insert(
            array(
                'user_id' => $user_id,
                'task_id' => $task_id,
                'file' => $filename,
                'corregit' => false,
            )
        );


        return redirect(route('cursos.task.show',array($id, $uf_id, $task_id) ));

    }

}
