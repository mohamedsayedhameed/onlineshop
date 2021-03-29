<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use App\Models\MainCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use App\Http\Requests\MainCategoryRequest;

class CategoriesController extends Controller
{
    #########################/* index method */#########################
    /* the index method go to view  'admin.categories.index' to show all categories */
    public function index(){

        // get the default language
        $default_lang = get_default_lang();

        //get all main categories form database 
        $categories =  MainCategory::where('translate_lang',$default_lang)->select('id','translate_lang','photo','name','slug','active')->get();
        
        // go to view  'admin.categories.index' and send all categories
        return view('admin.categories.index',compact('categories'));
    }

    #########################/* create method */#########################
    /* the cteate method go to view 'admin.categories.create for creating new category   */
    public function create(){

        // go to the view 'admin.categories.create'
        return view('admin.categories.create');
    }

    #########################/* store method */#########################
    /* the store method to store the request of new category in datebase */
    public function store(MainCategoryRequest $request){

        try{

            // convert the category object to collection
            $main_categories = collect($request->category);

            //filter the request to get the that in arabic language
            $filtered = $main_categories->filter(function($value,$key){
                return $value["abbr"] == get_default_lang();
            });

            $default_category = array_values($filtered->all())[0];

            $filepath = "";

            // save the photo by uploadimage method and get the path to save it in database
            if($request->has('photo')){
                $filepath = uploadImage('maincategories',$request->photo);
            }

            DB::beginTransAction();

            // insert the category in default language in database and get the id of the row
            $default_category_id = MainCategory::insertGetId([

                // save the translation language
                'translate_lang'=>$default_category['abbr'],

                // save the id of the category translate from 
                'translate_of'=>0,

                // save the name of the category
                'name'=>$default_category['name'],

                // save the slug
                'slug'=>$default_category['name'],

                // save the path of the photo of the category
                'photo'=>$filepath,
            ]);

            //filter the request to get the that in other language
            $categories = $main_categories->filter(function($key,$value){
                return $key["abbr"] != "ar";
            });

            if(asset($categories)){
                
                $category_arr = [];
                
                // save other translation of category in array to insert it in database
                foreach($categories as $category){
                    $category_arr = [

                        // save the translation language
                        'translate_lang'=>$category['abbr'],

                        // save the id of the category translate from
                        'translate_of'=>$default_category_id,

                        // save the name of the category
                        'name'=>$category['name'],

                        // save the name of the slug
                        'slug'=>$category['name'],

                        // save the path of the image of the category
                        'photo'=>$filepath,   
                    ];
                }

                // insert array in database
                MainCategory::insert($category_arr);
            }

            DB::commit();

            // back to index page with a successful message
            return redirect()->route('admin.categories')->with(['success'=>'تمت إضافة قسم']);

        }catch(Exception $ex){
            DB::rollback();
            return redirect()->route('admin.categories.create')->with(['error'=>'هناك خطأ']);
        }
    }

    #########################/* edit method */#########################
    /* the edit method go to view 'admin.categories.edit' to edit on category */
    public function edit($id){

        // get the category want to edit with its translation
        $category = MainCategory::with('categories')->selection()->find($id);

        // if the category not found return to index page with error message
        if(!$category){
            return redirect()->route('admin.categories')->with(['error'=>'هذا القسم غير موجود']);
        }

        // go to the view 'admin.categories.edit'
        return view('admin.categories.edit',compact('category'));  
    }

    #########################/* update method */#########################
    /* the update method to update  the category in datebase */
    public function update(MainCategoryRequest $request, $id){
        try{

            // check if category is found
            $maincategory = array_values($request->category)[0];
            if(!$maincategory){

                // back to the index page with error message
                return redirect()->route('admin.categories')->with(['error'=>'هذا القسم غير موجود']);
            }

            // check for status of category
            if($request->has('category.0.active'))
                // change the status to active 
                {$request->request->add(['active'=>1]);}
            else
                // change the status to not actvie
                {$request->request->add(['active'=>0]);}

            // check for any change in the photo of the category
            if($request->has('photo')){

                // save the new image and get the new path by uploadImage method
                $filepath=uploadImage('maincategories',$request->photo);

                // update the path of the photo in datebase
                MainCategory::where('id',$id)->update([
                    'photo'=>$filepath,
                ]);
            }

            // update category inside datebase
            MainCategory::where('id',$id)->update([

                // update the name of the category
                'name'=>$maincategory['name'],

                // update the status of the category
                'active'=>$request->active,
            ]);

            // back to the index page with successful message
            return redirect()->route('admin.categories')->with(['success'=>'تم التعديل بنجاح']);

        }catch(Exception $ex){
            // back to index page with error message in case of any exception
            return redirect()->route('admin.categories')->with(['success'=>'هناك خطأ']);
        }
    }

    #########################/* destroy method */#########################
    /* the destroy method to delete category from datebase */
    public function destroy($id){

        // get category from database by its id
        $category = MainCategory::find($id);

        // check if category found in database
        if(!$category){

            // back to the index page with error message
            return redirect()->route('admin.categories')->with(['error'=>'can\'t find this category']);
        }

        // get all vendors of this category
        $vendors = $category->vendors();
      
        // check if this category has vendors
        if( isset($vendors) && $vendors->count() > 0 ){
            
            // back to the index page with error message that can't delete this category because it has vendors
            return redirect()->route('admin.categories')->with(['error'=>'can\'t delete this category']);
        }

        // get the image path of category from database
        $image = Str::after($category->photo,'ecommerce/');

        // get the base path of the image
        $image = base_path($image);

        // delete the image 
        unlink($image);

        // delete the translations of the category from the database
        $category->categories()->delete();

        // delete the category from database
        $category->delete();

        // back to the index page with successful message
        return redirect()->route('admin.categories')->with(['success'=>'category deleted successfuly']);
    }

    #########################/* changeStatus method */#########################
    /* the changeStatus method to change stataus  the category in datebase */
    public function changeStatus($id)
    {
        // get the categroy from datebase by its id
        $category = MainCategory::find($id);

        // check if category found in database
        if(!$category){

            // back to the index page with error message
            return redirect()->route('admin.categories')->with(['error'=>'can\'t find this category']);
        }

        // change the status
        $status = $category->active == 0? 1: 0;

        // update to the new status
        $category->update(['active'=> $status]);

        // update the translation of the category to the new status
        $category->categories()->update(['active'=>$status]);

        // back to the index page with successful message
        return redirect()->route('admin.categories')->with(['success'=>'status change successfuly']);
    }
}
