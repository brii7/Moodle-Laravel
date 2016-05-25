<?php

namespace App\Http\Controllers;

use App\Apunt;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

class ApuntsController extends Controller
{



    public function create($id, Request $request){

        $input = Input::all();
        $uf_id = $input['uf_id'];
        $file = $request->file('file');
        $destinationpath = '/apunts/'. $id . '/'. $uf_id;
        $extension = $file->getClientOriginalExtension();
        $filename = time().rand(11111, 99999) . '.' . $extension;
        $file->move(public_path() . $destinationpath, $filename);

        $apunt = new Apunt([
            'course_id' => $id,
            'uf_id' => $uf_id,
            'name' => $input['name'],
            'file' => $filename,
        ]);
        $apunt->save();

        return Redirect::to(route('cursos.show',$id))
            ->with('message',"Apunt afegit correctament");


    }

    public function delete($id, $apunt_id){

        if(Auth::guest()){
            return Redirect::route('dashboard')
                ->with('type_message', "warning")
                ->with('message', 'Nice try.');
        }

        $user = Auth::user();
        if($user->isAdmin() || $user->isTeacher()){
            Apunt::find($apunt_id)->delete();
            return Redirect::route('cursos.show', $id)
                ->with('message','Apunt esborrat correctament');
        }else{
            return Redirect::route('dashboard')
                ->with('type_message', "warning")
                ->with('message', 'Nice try.');
        }

    }

}
