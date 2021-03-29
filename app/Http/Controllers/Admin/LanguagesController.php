<?php

namespace App\Http\Controllers\Admin;

use App\Models\Language;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateRequest;

class LanguagesController extends Controller
{

    #########################/* index method */#########################
    /* the index method go to view  'admin.languages.index' to show all languages */
    public function index(){

        //get all languages form database 
        $languages = Language::select('id','name','abbr','direction','active')->paginate(PAGINATION_COUNT);

        // go to view  'admin.languages.index' and send all languages
        return view('admin.languages.index',compact('languages'));
    }

    #########################/* create method */#########################
    /* the cteate method go to view 'admin.languages.create for creating new language   */
    public function create(){

        // go to the view 'admin.languages.create'
        return view('admin.languages.create');
    }

    #########################/* store method */#########################
    /* the store method to store the request of new language in datebase */
    public function store(CreateRequest $request){
        try {

            // the status of the language
            $request['active'] = $request->active == 'on' ? 1 : 0;

            // create the new language
            Language::create($request->except(['_token']));

            // back to the index page with successful message
            return redirect()->route('admin.languages')->with(['success'=>'تمت إضافة لغة جديدة']);

        }catch(\Exception $ex){

            // back the index page with error message in case any exception
            return redirect()->route('admin.languages')->with(['error'=>'هناك خطأ']);
        }
    }

    #########################/* edit method */#########################
    /* the edit method go to view 'admin.languages.edit' to edit on language */
    public function  edit($id){

        // get the language want to edit with its translation
        $languages = Language::find($id);

        // if the language not found return to index page with error message
        if(!$languages){
            return redirect()->route('admin.languages')->with(['error'=>'هذه اللغة غير موجودة']);
        }

        // go to the view 'admin.languages.edit'    
        return view('admin.languages.edit',compact('languages'));
    }

    #########################/* update method */#########################
    /* the update method to update  the category in datebase */
    public function update(CreateRequest $request,$id){
        try{
             
            // get the language from database by its id
            $languages = Language::find($id);

            // check if vendor not found
            if(!$languages){

                // back to the index page with error message if language not found
                return redirect()->route('admin.languages')->with(['error'=>'هذه اللغة غير موجودة']);
            }

            // put the status of the language
            $request['active'] = $request->active == 'on' ? 1 : 0;

            // update the language
            $languages->update($request->except(['_token']));

            // back to the index page with successful message
            return redirect()->route('admin.languages')->with(['success'=>'تمت التعديل بنجاح']);

        }catch(\Exception $ex){

            // back to index page with error message in case of any exception
            return redirect()->route('admin.languages')->with(['error'=>'هناك خطأ']);
        }
    }

    #########################/* delete method */#########################
    /* the delete method to delete category from datebase */
    public function delete($id){

        // get language from database by its id
        $languages = Language::find($id);

        // check if language found in database
        if(!$languages){

            // back to the index page with error message
            return redirect()->route('admin.languages')->with(['error'=>'هذه اللغة غير موجودة']);
        }

        // delete the language from database
        $languages->delete();

        // back to the index page with successful message
        return redirect()->route('admin.languages')->with(['success'=>'تمت حذف اللغة']);
    }
}
