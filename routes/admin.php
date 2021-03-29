<?php

use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

define('PAGINATION_COUNT',10);

Route::group(['namespace'=>'Admin','middleware'=>'auth:admin'],function(){
    Route::get('/', 'DashboardController@index')->name('admin.dashboard');
    ######### languages route ##########
    Route::group(['prefix'=>'langueges'],function(){
        Route::get('/','LanguagesController@index')->name('admin.languages');
        Route::get('/create','LanguagesController@create')->name('admin.languages.create');
        Route::post('/store','LanguagesController@store')->name('admin.languages.store');
        Route::get('/edit/{id}','LanguagesController@edit')->name('admin.languages.edit');
        Route::post('/update/{id}','LanguagesController@update')->name('admin.languages.update');
        Route::get('/delete/{id}','LanguagesController@delete')->name('admin.languages.delete');
    });
    ######### category route ##########
    Route::group(['prefix'=>'categories'],function(){
        Route::get('/','CategoriesController@index')->name('admin.categories');
        Route::get('/create','CategoriesController@create')->name('admin.categories.create');
        Route::post('/store','CategoriesController@store')->name('admin.categories.store');
        Route::get('/edit/{id}','CategoriesController@edit')->name('admin.categories.edit');
        Route::post('/update/{id}','CategoriesController@update')->name('admin.categories.update');
        Route::get('/delete/{id}','CategoriesController@destroy')->name('admin.categories.delete');
        Route::get('/status/{id}','CategoriesController@changeStatus')->name('admin.categories.status');
    });
    ######### vendors route ##########
    Route::group(['prefix'=>'vendors'],function(){
        Route::get('/','VendorsController@index')->name('admin.vendors');
        Route::get('/create','VendorsController@create')->name('admin.vendors.create');
        Route::post('/store','VendorsController@store')->name('admin.vendors.store');
        Route::get('/edit/{id}','VendorsController@edit')->name('admin.vendors.edit');
        Route::post('/update/{id}','VendorsController@update')->name('admin.vendors.update');
        Route::get('/destroy/{id}','VendorsController@destroy')->name('admin.vendors.destroy');
        Route::get('/status/{id}','VendorsController@changeStatus')->name('admin.vendors.status');
    });
    ######### subcategories route ##########
    Route::group(['prefix'=>'subcategories'],function(){
        Route::get('/','SubcategoryController@index')->name('admin.subcategories');
        Route::get('/create','SubcategoryController@create')->name('admin.subcategories.create');
        Route::post('/store','SubcategoryController@store')->name('admin.subcategories.store');
        Route::get('/edit/{id}','SubcategoryController@edit')->name('admin.subcategories.edit');
        Route::post('/update/{id}','SubcategoryController@update')->name('admin.subcategories.update');
        Route::get('/destroy/{id}','SubcategoryController@destroy')->name('admin.subcategories.destroy');
        Route::get('/status/{id}','SubcategoryController@changeStatus')->name('admin.subcategories.status');
    });

});

Route::group(['namespace'=>'Admin','middleware'=>'guest:admin'],function(){
    Route::get('login', 'Login@getLogin')->name('get.admin.login');
    Route::post('login', 'Login@login')->name('admin.login');
});

Route::get('logout', 'Admin\Login@logout')->name('logout');


