<?php

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

Route::resource('products', 'ProductController');

Route::post('products/delete-image', 'ProductController@deleteImage')->name('products.deleteImage');

Route::get('products/json/{product}', 'ProductController@json')->name('products.json');
