<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    protected $table = 'subcategories';

    protected $fillable = ['name','category_id','created_at','updated_at'];

    protected $hidden = ['created_at','updated_at'];


    // public $timestamps = true;

    // public function scopeActive($query){
    //     return $query->where('active',1);
    // }

    // public function scopeMain($query){
    //     return $query->where('translate_of',0);
    // }
    
    // public function scopeSelection($query){
    //     //$default_lang=get_default_lang();
    //     //return $query->active()->where('translate_lang',$default_lang)->select('id','translate_lang','translate_of','name','slug','active')->get();
    //     return $query->select('id','translate_lang','translate_of','photo','name','slug','active')->get();
    // }

    // public function scopeCountMain($query){
    //     //$default_lang=get_default_lang();
    //     //return $query->active()->where('translate_lang',$default_lang)->select('id','translate_lang','translate_of','name','slug','active')->get();
    //     return $query->select()->where('translate_of',0)->count();
    // }

    // public function getActive(){
    //     return $this->active == 1? 'مفعل':'غير مفعل';
    // }
    
    // public function getPhotoAttribute($val){
    //     return ($val !== null)? 'http://localhost/ecommerce/public/'.$val : "";
    // }

    // public function categories(){
    //     return $this->hasMany(self::class,'translate_of');
    // }

    // public function vendors(){
    //     return $this->hasMany('App\Models\Vendor','category_id','id');
    // }
}
