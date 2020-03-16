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

Route::group(['namespace' => 'Web'], function () {

    Route::get('test', 'TestController@index');

    Route::get('', 'IndexController@index')
        ->name('home');

    Route::group(['prefix' => 'product'], function (){
        Route::get('{modelId}','ProductController@index')
            ->where('modelId', '[0-9]+')
            ->name('web.product.index');
    });

    Route::group(['prefix' => 'category'],function (){
        Route::get('{modelId}','ProductCategoryController@index')
            ->where('modelId', '[0-9]+')
            ->name('web.product-category.index');

        Route::get('{productCategoryId}/{idChekBoxes}/index-sort','ProductCategoryController@indexSort')->name('web.product-category.indexSort');
    });

    Route::group(['prefix' => 'basket'],function (){
        Route::get('{productsId}/index','BasketController@index')->name('web.basket.index');
    });
});

