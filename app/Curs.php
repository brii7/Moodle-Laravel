<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Curs extends Model
{
    /*
     * Atributs que es poden emplenar "manualment".
     */
    protected $fillable = ['name', 'teacher_id'];

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
     * Definir la relació amb les tasques
     */
    public function tasks(){
        return $this->hasMany(Task::class);
    }

    /*
     * Retorna el nom del professor del curs
     */
    public function teacher(){

        $teacher = User::find($this->teacher_id);
        return $teacher->name;
    }

}
