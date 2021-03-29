<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Vendor extends Model
{   
    // use notifiable class to make notification
    use Notifiable;

    // the name of the table the model connected to
    protected $table = 'vendors';

    // the column of the table
    protected $fillable = ['name', 'phone', 'email','active','adress','category_id','logo','password','created_at','updated_at'];

    // the hidden column of the table
    protected $hidden = ['created_at','updated_at','category_id','password'];

    // make the timestamps true
    // public $timestamps = true;

    ############################## getActive method ##############################
    /* the getActive is get method return the actvie from tabel and convert it */
    public function getActive(){
        return $this->active == 1? 'مفعل':'غير مفعل';
    }

    ############################## setPasswordAttribute method ##############################
    /* the setPasswordAttribute is set method use to put the password encyrepted in database */
    public function setPasswordAttribute($q){
        if(!empty($q)){
            $this->attributes['password']=bcrypt($q);
        }
    }

    ############################## getLogoAttribute method ##############################
    /* the getLogoAttribute is get method return the logo from tabel and add base_path to it */
    public function getLogoAttribute($val){
        return ($val !== null)? 'http://localhost/ecommerce/public/'.$val : "";
    }

    ############################## scopeActive method ##############################
    /* the scopeActive is scope use to make query to get from table whre active == 1 */
    public function scopeActive($query){
        return $query->where('active',1);
    }

    ############################## scopeSelection method ##############################
    /* the scopeSelection is scope use to make query */
    public function scopeSelection($query){
        return $query->select('id','name','active','logo','address','phone','email','category_id');
    }

    ############################## category method ##############################
    /* the category method use to make one to many relation and get the the category that vendor belongs to */
    public function category(){
       return $this->belongsTo('App\Models\MainCategory','category_id','id');
    }
}
