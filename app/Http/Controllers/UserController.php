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
        $user_notes = DB::table('user_task')->where('user_id', $user->id)->get();
        
        /*foreach($user_notes as $row){
            if($row->corregit){
                
                
                

            }
        }*/
        return view('user.notes', [
            'user' => $user,
            'user_notes' => $user_notes,
        ]);
        
    }
}
