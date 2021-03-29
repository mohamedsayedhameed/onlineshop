<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\VendorRequest;
use App\Models\MainCategory;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Notifications\VendorCreated;
use DB;

class VendorsController extends Controller
{

    #########################/* index method */#########################
    /* the index method go to view  'admin.vendors.index' to show all vendors */
    public function index(){

        //get all vendors form database 
        $vendors = Vendor::selection()->paginate(PAGINATION_COUNT);

        // go to view  'admin.vendors.index' and send all vendors
        return view('admin.vendors.index',compact('vendors'));
    }

    #########################/* create method */#########################
    /* the cteate method go to view 'admin.vendors.create for creating new language   */
    public function create(){
        
        // get the main categories from database
        $categories = MainCategory::main()->active()->get();

        // go to the view 'admin.vendors.create'
        return view('admin.vendors.create',compact('categories'));
    }

    #########################/* store method */#########################
    /* the store method to store the request of new vendor in datebase */
    public function store(VendorRequest $request){
        try {

            // check for status of vendor
            if (!$request->has('active'))
                // change the status to active
                $request->request->add(['active' => 0]);
            else
            // change the status to not actvie
                $request->request->add(['active' => 1]);
            
            $filepath = '';

            //check for logo in request
            if($request->has('logo')){

                // save the logo and return the path to save in database
                $filepath = uploadImage('vendors',$request->logo);
            }

            // create the new vendor in database
            $vendor = Vendor::create([

                // the name of vendor
                'name' => $request->name,

                // the phone of vendor 
                'phone' => $request->phone,

                // the email of vendor
                'email' => $request->email,

                // the status of vendor
                'active' => $request->active,

                // the address of vendor
                //'address' => $request->address,

                // the path of logo of vendor
                'logo' => $filepath,

                // the password of vendor
                'password' => $request->password,

                // the category id of vendor
                'category_id' => $request->category_id,

                // the latitude of vendor
                //'latitude' => $request->latitude,

                // the longitude of vendor
                //'longitude' => $request->longitude,
            ]);

            // send notification after create the vendor
            Notification::send($vendor,new VendorCreated($vendor));

            // return to the index page with successful message
            return redirect()->route('admin.vendors')->with(['success'=>'تم اضافة متجر جديد']);

        }catch(\Exception $ex){

            // return to the index page with error message in case of any exception
            return redirect()->route('admin.vendors.create')->with(['error'=>'هناك خطأ']);
        }
    }

    #########################/* edit method */#########################
    /* the edit method go to view 'admin.vendors.edit' to edit on vendor */
    public function  edit($id){

        // get the main categories from database
        $categories = MainCategory::main()->active()->get();

        // get the vendor from database by its id to edit 
        $vendors = Vendor::find($id);

        // check if vendor found in database
        if(!$vendors){

            // if the vendor not found return to index page with error message
            return redirect()->route('admin.vendors')->with(['error'=>'هذه اللغة غير موجودة']);
        }

        // go to the view 'admin.languages.edit'
        return view('admin.vendors.edit',compact('vendors','categories'));
    }

    #########################/* update method */#########################
    /* the update method to update  the vendor in datebase */
    public function update(VendorRequest $request,$id){
        try{

            // get the vendor from database by its id to edit 
            $vendors = Vendor::find($id);

            // check if vendor is found
            if(!$vendors){

                // if the vendor not found return to index page with error message
                return redirect()->route('admin.vendors')->with(['error'=>'هذه اللغة غير موجودة']);
            }

            // check if request has logo
            if($request->has('logo')){

                // change the path of the logo
                $filepath=uploadImage('vendors',$request->logo);

                // update the path of the logo in datebase
                Vendor::where('id',$id)->update([
                    'logo'=>$filepath,
                ]);
            }

            // check the status of the vendor
            if(!$request->has('active'))
                {$request->request->add(['active'=>0]);}
            
            $data = $request->except('_token','id','password','logo');

            // check if there change in password
            if($request->has('password')){
                $data['password']=$request->password;
            }

            // update the vendor
            $vendors->update($data);

            // return to the index page with successful message
            return redirect()->route('admin.vendors')->with(['success'=>'تمت التعديل بنجاح']);

        }catch(\Exception $ex){

            // return to the index page with error message in case of any exception
            return redirect()->route('admin.vendors')->with(['error'=>'هناك خطأ']);
        }
    }

    #########################/* destroy method */#########################
    /* the destroy method to delete vendor from datebase */
    public function destroy($id){

        // get the vendor from database by its id
        $vendor = Vendor::find($id);

        // check if vendor not found
        if(!$vendor){

            // back to the index page with error message if vendor not found
            return redirect()->route('admin.categories')->with(['error'=>'can\'t find this vendor']);
        }

        // get the image vendor path
        $image = Str::after($vendor->logo,'ecommerce/');

        // get the base path of the vendor image
        $image = base_path($image);

        // delete the vendor image
        unlink($image);

        // delete the vendor
        $vendor->delete();

        // back to the index page with successful message
        return redirect()->route('admin.vendors')->with(['success'=>'vendor deleted successfuly']);
    }

    #########################/* changeStatus method */#########################
    /* the changeStatus method to change stataus  the vendor in datebase */
    public function changeStatus($id){

        // get the vendor from datebase by its id
        $vendor = Vendor::find($id);

        // check if vendor found in database
        if(!$vendor){

            // back to the index page with error message
            return redirect()->route('admin.vendors')->with(['error'=>'can\'t find this category']);
        }

        // change the status
        $status = $vendor->active == 0? 1: 0;

        // update to the new status
        $vendor->update(['active'=> $status]);

        // back to the index page with successful message
        return redirect()->route('admin.vendors')->with(['success'=>'status change successfuly']);
    }
}
