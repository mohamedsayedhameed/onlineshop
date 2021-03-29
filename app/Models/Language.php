<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    // the name of the table the model connected to
    protected $table = 'languages';

    // the column of the table
    protected $fillable = ['name', 'abbr', 'locale','direction','active','updated_at','created_at'];

    // the hidden column of the table
    protected $hidden = ['created_at','updated_at'];

    // make the timestamps true
    // public $timestamps = true;

    ############################## getActive method ##############################
    /* the getActive is get method return the actvie from tabel and convert it */
    public function getActive(){
        return $this->active == 1? 'مفعل':'غير مفعل';
    }

    ############################## scopeActive method ##############################
    /* the scopeActive is scope use to make query to get from table whre active == 1 */
    public function scopeActive($query){
        return $query -> where('active',1);
    }

    ############################## scopeActive method ##############################
    /* the scopeActive is scope use to make query */
    public function  scopeSelection($query){
        return $query -> select('id','abbr', 'name', 'direction', 'active');
    }
}
