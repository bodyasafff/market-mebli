<?php
Route::group(['middleware' => ['check.ip']], function () {
    
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('login', 'Auth\LoginController@login');
    Route::post('logout', 'Auth\LoginController@logout')->name('logout');

    Route::group(['middleware' => ['auth'], 'namespace' => 'Dashboard'], function () {

        Route::get('redirect/after-login', function (){
            if(\App\Models\User::hasRole(\App\Models\Datasets\UserRole::ADMIN)){
                return redirect()->route('dashboard.index');
            }
            return redirect()->route('dashboard.index');
        })->name('dashboard.redirect.after-login');

        Route::group(['middleware' => ['check.user.roles:'.\App\Models\Datasets\UserRole::ADMIN]], function () {

            Route::get('', 'IndexController@index')->name('dashboard.index');

            Route::group(['prefix' => 'product-category'],function (){

               Route::get('', 'ProductCategoryController@index')->name('dashboard.product-category.index');
               Route::post('index-json','ProductCategoryController@indexJson')->name('dashboard.product-category.indexJson');
               Route::get('create','ProductCategoryController@create')->name('dashboard.product-category.create');
               Route::post('store','ProductCategoryController@store')->name('dashboard.product-category.store');

               Route::get('{model}/edit','ProductCategoryController@edit')
                   ->where('model', '[0-9]+')
                   ->name('dashboard.product-category.edit');

               Route::post('{model}/update','ProductCategoryController@update')
                   ->where('model', '[0-9]+')
                   ->name('dashboard.product-category.update');

               Route::get('{model}/destroy','ProductCategoryController@destroy')
                   ->where('model', '[0-9]+')
                   ->name('dashboard.product-category.destroy');
            });


            Route::group(['prefix' => 'console-proc'], function () {
                Route::get('{procId?}/{procNum?}', 'ConsoleProcController@index')
                    ->where('procId', '[0-9]+')
                    ->where('procNum', '[0-9]+')
                    ->name('dashboard.console-proc.index');

                Route::group(['middleware' => ['check.key']], function () {
                    Route::get('{procId}/{procNum}/total-result', 'ConsoleProcController@totalResult')
                        ->where('procId', '[0-9]+')
                        ->where('procNum', '[0-9]+')
                        ->name('dashboard.console-proc.total-result');
                    Route::get('{procId}/{procNum}/start', 'ConsoleProcController@start')
                        ->where('procId', '[0-9]+')
                        ->where('procNum', '[0-9]+')
                        ->name('dashboard.console-proc.start');
                    Route::get('{procId}/{procNum}/stop', 'ConsoleProcController@stop')
                        ->where('procId', '[0-9]+')
                        ->where('procNum', '[0-9]+')
                        ->name('dashboard.console-proc.stop');
                    Route::get('{procId}/{procNum}/clear-log', 'ConsoleProcController@clearLog')
                        ->where('procId', '[0-9]+')
                        ->where('procNum', '[0-9]+')
                        ->name('dashboard.console-proc.clear-log');
                });
            });

            Route::group(['prefix' => 'user'], function () {
                Route::get('', 'UserController@index')
                    ->name('dashboard.user.index');
                Route::post('index-json', 'UserController@indexJson')
                    ->name('dashboard.user.index-json');

                Route::get('create', 'UserController@create')
                    ->name('dashboard.user.create');

                Route::post('store', 'UserController@store')
                    ->name('dashboard.user.store');

                Route::get('{model}/edit', 'UserController@edit')
                    ->where('model', '[0-9]+')
                    ->name('dashboard.user.edit');

                Route::post('{model}/update', 'UserController@update')
                    ->where('model', '[0-9]+')
                    ->name('dashboard.user.update');

                Route::post('{model}/ajax-update', 'UserController@ajaxUpdate')
                    ->where('model', '[0-9]+')
                    ->name('dashboard.user.ajax-update');

                Route::post('{model}/destroy', 'UserController@destroy')
                    ->where('model', '[0-9]+')
                    ->name('dashboard.user.destroy');
            });
        });
    });

});