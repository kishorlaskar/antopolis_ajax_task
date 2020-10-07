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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('brand', 'BrandController');

Route::post('brand/update', 'BrandController@update')->name('brand.update');

Route::get('brand/destroy/{id}', 'BrandController@destroy');

Route::resource('category','CategoryController');

Route::resource('subcategory','SubcategoryController');

Route::resource('products','ProductController');
