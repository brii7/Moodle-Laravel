<?php

namespace App\Http\Controllers;

use App\Curs;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class CursController extends Controller
{
    public function index(Request $request){
        
        $user = Auth::user();
        $mycursos = $user->cursos();
        $cursos = Curs::all();



        return view('cursos.index',
            [
               'cursos' => $cursos,
                'mycursos' => $mycursos,
            ]);



    }
}
