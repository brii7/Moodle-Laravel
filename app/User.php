<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function cursos()
    {
        return $this->belongsToMany('App\Curs');
    }

    public function isAdmin(){
        if($this->role == 'admin'){
            return true;
        }else{
            return false;
        }
    }
    
    public function isTeacher(){
        
    }
    
}
