<?php

use App\Models\Language;


######################################################################
/* here you can write function and use at any place in the project */
######################################################################

/* get_language */
// this function to get all active language in the site
function get_language(){
    
    //return Language::where('active','1')->select('id','name','abbr')->get();

    //use two scope 'active' and 'selection' that was defined at language model
    return \App\Models\Language::active() -> Selection() -> get();

}

/* get_default_lang */
// this function to get the default language of the site
function get_default_lang(){

    // get the default language from the site from the config file
    return   Config::get('app.locale');
}

/* uploadImage */
// function for uploading image
function uploadImage($folder, $image)
{
    // store the image
    $image->store('/', $folder);

    //get the extension of the photo
    $filename = $image->hashName();

    // make the path that will save in database
    $path = 'images/' . $folder . '/' . $filename;

    //return the path
    return $path;
}

/* function saveImages($photo, $path){
    $file_extension = $photo -> getClientOriginalExtension();
    $file_name = time().'.'.$file_extension;
    $photo->move($path, $file_name);
    return $file_name;
} */