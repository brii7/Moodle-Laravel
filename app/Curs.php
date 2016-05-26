<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Curs extends Model
{
    /*
     * Atributs que es poden emplenar "manualment".
     */
    protected $fillable = ['name', 'teacher_id', 'description'];

    /*
     * Taula on correspon el model
     */
    protected $table = 'cursos';

    public $timestamps = false;

    /*
     * Definir la relació amb els usuaris
     */
    public function members(){
        return $this->belongsToMany('App\User');
    }
    /*
     * Definir la relació amb les tasques i Unitats Formatives
     */
    public function UFs(){
        return $this->hasMany(UnitatFormativa::class, 'course_id');
    }

    public function tasks(){
        return $this->hasMany(Task::class, 'course_id');
    }

    /*
     * Retorna el nom del professor del curs
     */
    public function teacher(){

        $teacher = User::find($this->teacher_id);
        return $teacher->name;
    }
    public function teacherid(){

        $teacher = User::find($this->teacher_id);
        return $teacher->id;
    }

    /**
     * Nota mitjana de totes les notes de tasques que están a aquest curs
     */
    public function mitjana(){
        
        $notes = array();
        $tasques = $this->tasks;
        if(count($tasques) == 0){
            return 'No hi ha tasques';
        }


        foreach($tasques as $tasca){

            $id = $tasca->id;
            $rows = DB::table('user_task')->where('task_id',$id)->get();

            foreach($rows as $row){
                if($row->corregit){
                    $nota = $row->nota;
                    array_push($notes, $nota);
                }

            }
        }

        $sumatotal = 0;
        for($i = 0; $i < sizeof($notes); $i++){

            $sumatotal = $sumatotal + $notes[$i];

        }
        if(sizeof($notes) == 0){
            return 'Encara no hi ha correccions.';
        }
        $mitjana = $sumatotal/sizeof($notes);
        return $mitjana;

        
    }

}
