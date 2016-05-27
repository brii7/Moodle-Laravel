<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Curs;
use App\Task;
use App\UnitatFormativa;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Http\Requests;

class UserController extends Controller
{
    public function notes(){
        $user = Auth::user();
        if($user->isAdmin()){
            $user_notes = DB::table('user_task')
                ->where('user_id', $user->id)
                ->orderBy('course_id', 'asc')
                ->orderBy('uf_id', 'asc')
                ->get();
            return view('user.notes', [
                'user' => $user,
                'user_notes' => $user_notes,
            ]);
        }
        

        $user_notes = DB::table('user_task')
            ->where('user_id', $user->id)
            ->orderBy('course_id', 'asc')
            ->orderBy('uf_id', 'asc')
            ->get();

        $cursosarray = $user->cursos;
        $ufarray = array();
        foreach($cursosarray as $curs){
            array_push($ufarray, $curs->UFs);
        }
        
        $taskarray = array();
        foreach($user_notes as $row){
            $taskarray[$row->task_id] = $row->nota;

        }


        return view('user.notes', [
            'user' => $user,
            'user_notes' => $user_notes,
            'cursosarray' => $cursosarray,
            'ufarray' => $ufarray,
        ]);
        
    }
}
