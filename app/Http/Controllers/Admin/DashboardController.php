<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    ################################# method index #################################
    /* method index to go to the view of admin.dashboard */
    public function index(){
        return view('admin.dashboard');
    }
}
