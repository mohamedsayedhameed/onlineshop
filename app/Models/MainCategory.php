<?php

namespace App\Models;

use App\Observers\MainCategoryObserver;
use Illuminate\Database\Eloquent\Model;

class MainCategory extends Model
{
    // the name of the table the model connected to
    protected $table = 'main_categories';

    // the column of the table
    protected $fillable = ['translate_lang', 'translate_of', 'name','slug','photo','active','created_at','updated_at'];

    // the hidden column of the table
    protected $hidden = ['created_at','updated_at'];

    // make the timestamps true
    // public $timestamps = true;

    ############################## boot method ##############################
    public static function boot(){
        parent::boot();
        MainCategory::observe(MainCategoryObserver::class);
    }

    ############################## scopeActive method ##############################
    /* the scopeActive is scope use to make query to get from table whre active == 1 */
    public function scopeActive($query){
        return $query->where('active',1);
    }

    ############################## scopeMain method ##############################
    /* the scopeMain is scope use to make query to get from table the main category */
    public function scopeMain($query){
        return $query->where('translate_of',0);
    }
    
    ############################## scopeSelection method ##############################
    /* the scopeSelection is scope use to make query */
    public function scopeSelection($query){
        return $query->select('id','translate_lang','translate_of','photo','name','slug','active')->get();
    }

    ############################## scopeCountMain method ##############################
    /* the scopeCountMain is scope use to make query to count the main category in table */
    public function scopeCountMain($query){
        return $query->where('translate_of',0)->count();
    }

        ############################## getActive method ##############################
        /* the getActive is get method return the actvie from tabel and convert it */
    public function getActive(){
        return $this->active == 1? 'مفعل':'غير مفعل';
    }

    ############################## getPhotoAttribute method ##############################
    /* the getPhotoAttribute is get method return the photo from tabel and add base_path to it */
    public function getPhotoAttribute($val){
        return ($val !== null)? 'http://localhost/ecommerce/public/'.$val : "";
    }

    ############################## categories method ##############################
    /* the categories method use to make one to one relation and get the translation of main category */
    public function categories(){
        return $this->hasMany(self::class,'translate_of');
    }

    ############################## vendors method ##############################
    /* the vendors method use to make one to many relation and get the the vendors of main category */
    public function vendors(){
        return $this->hasMany('App\Models\Vendor','category_id','id');
    }
}
