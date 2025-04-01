<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model as Eloquent;


class User extends Eloquent {
    protected $table = 'users';
    public $timestamps = true; 

    protected $fillable = ['fname','email'];
} 