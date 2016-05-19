<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UnitatFormativa extends Model
{
    /*
     * Taula on correspon el model
     */
    protected $table = 'unitatsformatives';

    public $timestamps = false;

    protected $fillable = ['course_id', 'name', 'description', 'data_finalització'];

    public function curs()
    {
        return $this->belongsTo(Curs::class, 'course_id');
    }
    public function tasks(){
        return $this->hasMany(Task::class, 'uf_id');
    }

}
