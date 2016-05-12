<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Curs extends Model
{
    /*
     * Atributs que es poden emplenar "manualment".
     */
    protected $fillable = ['name'];

    /*
     * Taula on correspon el model
     */
    protected $table = 'cursos';

    /*
     * Definir la relació
     */
    public function members()
    {
        return $this->belongsToMany('App\User');
    }
    public function teacher(){

    }
}
