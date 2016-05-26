<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description', 'data_finalització', 'uf_id','course_id', 'file'];

    public $timestamps = false;

    /**
     * Get the user that owns the task.
     */
    public function UF(){
        return $this->belongsTo(UnitatFormativa::class, 'uf_id');
    }

    public function curs(){
        return $this->belongsTo(Curs::class, 'course_id');
    }
}
