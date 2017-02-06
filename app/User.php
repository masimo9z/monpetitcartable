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
    protected $table = 'mpc_user';
    
    protected $fillable = [
        'id', 'pseudo', 'nom', 'prenom', 'rang', 'groupe', 'classe', 'avatar', 'vie', 'date_naissance', 'ip', 'email', 
        'password', 'sexe', 'date_inscription', 'remember_token', 
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public $timestamps = false;
}
