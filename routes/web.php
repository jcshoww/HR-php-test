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
Route::get('/', 'IndexController@index')->name('index');
Route::get('weather', 'IndexController@weather')->name('weather');

Route::group(['prefix' => 'admin'], function () {
    Route::group(['prefix' => 'orders'], function () {
        Route::get('/', 'Admin\OrderController@index')->name('orders.index');
        Route::get('edit/{id}', 'Admin\OrderController@edit')->name('orders.edit');
        Route::post('current', 'Admin\OrderController@current')->name('orders.current');
        Route::post('new', 'Admin\OrderController@new')->name('orders.new');
        Route::post('delayed', 'Admin\OrderController@delayed')->name('orders.delayed');
        Route::post('finished', 'Admin\OrderController@finished')->name('orders.finished');
        Route::post('store', 'Admin\OrderController@store')->name('orders.store');
    });
    Route::group(['prefix' => 'products'], function () {
        Route::get('/', 'Admin\ProductController@index')->name('products.index');
        Route::post('change-price', 'Admin\ProductController@changePrice')->name('products.changePrice');
    });
});