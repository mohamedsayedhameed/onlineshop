<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Admin extends Authenticatable
{
    // the name of the table the model connected to
    protected $table = 'admins';

    // the column of the table
    protected $fillable = ['name', 'email', 'password','photo','created_at','updated_at'];

    // the hidden column of the table
    protected $hidden = ['created_at','updated_at','password','remember_token'];

    // make the timestamps true
    // public $timestamps = true;
}
