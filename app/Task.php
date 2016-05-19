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
    protected $fillable = ['name', 'description', 'data_finalització'];

    /**
     * Get the user that owns the task.
     */
    public function UF()
    {
        return $this->belongsTo(UnitatFormativa::class, 'uf_id');
    }
}
