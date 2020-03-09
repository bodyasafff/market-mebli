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

//            Route::get('', 'IndexController@index')->name('dashboard.index');
            Route::get('',function (){
               return redirect()->route('dashboard.product.index');
            })->name('dashboard.index');

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

            Route::group(['prefix' => 'property-category'],function (){
                Route::get('','PropertyCategoryController@index')->name('dashboard.property-category.index');
                Route::post('index-json','PropertyCategoryController@indexJson')->name('dashboard.property-category.indexJson');
                Route::get('create','PropertyCategoryController@create')->name('dashboard.property-category.create');
                Route::post('store','PropertyCategoryController@store')->name('dashboard.property-category.store');

                Route::get('{model}/edit','PropertyCategoryController@edit')
                    ->where('model', '[0-9]+')
                    ->name('dashboard.property-category.edit');

                Route::post('{model}/update','PropertyCategoryController@update')
                    ->where('model', '[0-9]+')
                    ->name('dashboard.property-category.update');

                Route::get('{model}/destroy','PropertyCategoryController@destroy')
                    ->where('model', '[0-9]+')
                    ->name('dashboard.property-category.destroy');
            });

            Route::group(['prefix' => 'product'],function (){
                Route::get('', 'ProductController@index')->name('dashboard.product.index');
                Route::post('index-json','ProductController@indexJson')->name('dashboard.product.indexJson');
                Route::get('create','ProductController@create')->name('dashboard.product.create');

                Route::post('store','ProductController@store')->name('dashboard.product.store');

                Route::get('{model}/edit','ProductController@edit')
                    ->where('model', '[0-9]+')
                    ->name('dashboard.product.edit');

                Route::post('{model}/update','ProductController@update')
                    ->where('model', '[0-9]+')
                    ->name('dashboard.product.update');

                Route::get('{model}/destroy','ProductController@destroy')
                    ->where('model', '[0-9]+')
                    ->name('dashboard.product.destroy');
            });


            Route::group(['prefix' => 'property'],function (){
                Route::get('','PropertyController@index')->name('dashboard.property.index');
                Route::post('index-json','PropertyController@indexJson')->name('dashboard.property.indexJson');
                Route::get('create','PropertyController@create')->name('dashboard.property.create');

                Route::post('store','PropertyController@store')->name('dashboard.property.store');

                Route::get('{model}/edit','PropertyController@edit')
                    ->where('model', '[0-9]+')
                    ->name('dashboard.property.edit');

                Route::post('{model}/update','PropertyController@update')
                    ->where('model', '[0-9]+')
                    ->name('dashboard.property.update');

                Route::get('{model}/destroy','PropertyController@destroy')
                    ->where('model', '[0-9]+')
                    ->name('dashboard.property.destroy');
            });

            Route::group(['prefix' => 'client'],function (){
                Route::get('','ClientController@index')->name('dashboard.client.index');
                Route::post('index-json','ClientController@indexJson')->name('dashboard.client.indexJson');
                Route::post('detail-json','ClientController@detailJson')->name('dashboard.client.detailJson');
                Route::get('create','ClientController@create')->name('dashboard.client.create');

                Route::get('{orderId}/order-detail','ClientController@orderDetail')->name('dashboard.client.orderDetail');

                Route::post('store','ClientController@store')->name('dashboard.client.store');

                Route::get('{model}/detail','ClientController@detail')
                    ->where('model', '[0-9]+')
                    ->name('dashboard.client.detail');

                Route::get('{model}/edit','ClientController@edit')
                    ->where('model', '[0-9]+')
                    ->name('dashboard.client.edit');

                Route::post('{model}/update','ClientController@update')
                    ->where('model', '[0-9]+')
                    ->name('dashboard.client.update');

                Route::get('{model}/destroy','ClientController@destroy')
                    ->where('model', '[0-9]+')
                    ->name('dashboard.client.destroy');
            });

            Route::group(['prefix' => 'group'],function (){
                Route::get('','GroupController@index')->name('dashboard.group.index');
                Route::post('index-json','GroupController@indexJson')->name('dashboard.group.indexJson');
                Route::get('create','GroupController@create')->name('dashboard.group.create');

                Route::post('store','GroupController@store')->name('dashboard.group.store');

                Route::get('{model}/edit','GroupController@edit')
                    ->where('model', '[0-9]+')
                    ->name('dashboard.group.edit');

                Route::post('{model}/update','GroupController@update')
                    ->where('model', '[0-9]+')
                    ->name('dashboard.group.update');

                Route::get('{model}/destroy','GroupController@destroy')
                    ->where('model', '[0-9]+')
                    ->name('dashboard.group.destroy');
            });

            Route::group(['prefix' => 'order'],function (){
                Route::get('','OrderController@index')->name('dashboard.order.index');
                Route::post('index-json','OrderController@indexJson')->name('dashboard.order.indexJson');
                Route::get('create','OrderController@create')->name('dashboard.order.create');
                Route::post('store-product','OrderController@storeProduct')->name('dashboard.order.storeProduct');
                Route::post('store-client','OrderController@storeClient')->name('dashboard.order.storeClient');

                Route::get('{model}/download-payment-document','OrderController@downloadPaymentDocument')
                    ->where('model', '[0-9]+')
                    ->name('dashboard.order.downloadPaymentDocument');

                Route::get('{model}/detail','OrderController@detail')
                    ->where('model', '[0-9]+')
                    ->name('dashboard.order.detail');

                Route::post('store','OrderController@store')->name('dashboard.order.store');

                Route::get('{model}/edit','OrderController@edit')
                    ->where('model', '[0-9]+')
                    ->name('dashboard.order.edit');

                Route::post('{model}/update','OrderController@update')
                    ->where('model', '[0-9]+')
                    ->name('dashboard.order.update');

                Route::get('{model}/destroy','OrderController@destroy')
                    ->where('model', '[0-9]+')
                    ->name('dashboard.order.destroy');
            });

            Route::group(['prefix' => 'order-option'],function (){

                Route::group(['prefix' => 'state'],function (){
                    Route::get('','OrderOption\StateController@index')->name('dashboard.order_option.state.index');
                    Route::post('index-json','OrderOption\StateController@indexJson')->name('dashboard.order_option.state.indexJson');
                    Route::get('create','OrderOption\StateController@create')->name('dashboard.order_option.state.create');
                    Route::post('store','OrderOption\StateController@store')->name('dashboard.order_option.state.store');

                    Route::get('{model}/edit','OrderOption\StateController@edit')
                        ->where('model', '[0-9]+')
                        ->name('dashboard.order_option.state.edit');

                    Route::post('{model}/update','OrderOption\StateController@update')
                        ->where('model', '[0-9]+')
                        ->name('dashboard.order_option.state.update');

                    Route::get('{model}/destroy','OrderOption\StateController@destroy')
                        ->where('model', '[0-9]+')
                        ->name('dashboard.order_option.state.destroy');

                });

                Route::group(['prefix' => 'status-client'],function (){
                Route::get('','OrderOption\ClientStatusController@index')->name('dashboard.order_option.client_status.index');
                Route::post('index-json','OrderOption\ClientStatusController@indexJson')->name('dashboard.order_option.client_status.indexJson');
                Route::get('create','OrderOption\ClientStatusController@create')->name('dashboard.order_option.client_status.create');
                Route::post('store','OrderOption\ClientStatusController@store')->name('dashboard.order_option.client_status.store');

                Route::get('{model}/edit','OrderOption\ClientStatusController@edit')
                    ->where('model', '[0-9]+')
                    ->name('dashboard.order_option.client_status.edit');

                Route::post('{model}/update','OrderOption\ClientStatusController@update')
                    ->where('model', '[0-9]+')
                    ->name('dashboard.order_option.client_status.update');

                Route::get('{model}/destroy','OrderOption\ClientStatusController@destroy')
                    ->where('model', '[0-9]+')
                    ->name('dashboard.order_option.client_status.destroy');

                });

                Route::group(['prefix' => 'order-status'],function (){
                    Route::get('','OrderOption\OrderStatusController@index')->name('dashboard.order_option.order_status.index');
                    Route::post('index-json','OrderOption\OrderStatusController@indexJson')->name('dashboard.order_option.order_status.indexJson');
                    Route::get('create','OrderOption\OrderStatusController@create')->name('dashboard.order_option.order_status.create');
                    Route::post('store','OrderOption\OrderStatusController@store')->name('dashboard.order_option.order_status.store');

                    Route::get('{model}/edit','OrderOption\OrderStatusController@edit')
                        ->where('model', '[0-9]+')
                        ->name('dashboard.order_option.order_status.edit');

                    Route::post('{model}/update','OrderOption\OrderStatusController@update')
                        ->where('model', '[0-9]+')
                        ->name('dashboard.order_option.order_status.update');

                    Route::get('{model}/destroy','OrderOption\OrderStatusController@destroy')
                        ->where('model', '[0-9]+')
                        ->name('dashboard.order_option.order_status.destroy');
                });

                Route::group(['prefix' => 'creation-unit'],function (){
                    Route::get('','OrderOption\CreationUnitController@index')->name('dashboard.order_option.creation_unit.index');
                    Route::post('index-json','OrderOption\CreationUnitController@indexJson')->name('dashboard.order_option.creation_unit.indexJson');
                    Route::get('create','OrderOption\CreationUnitController@create')->name('dashboard.order_option.creation_unit.create');
                    Route::post('store','OrderOption\CreationUnitController@store')->name('dashboard.order_option.creation_unit.store');

                    Route::get('{model}/edit','OrderOption\CreationUnitController@edit')
                        ->where('model', '[0-9]+')
                        ->name('dashboard.order_option.creation_unit.edit');

                    Route::post('{model}/update','OrderOption\CreationUnitController@update')
                        ->where('model', '[0-9]+')
                        ->name('dashboard.order_option.creation_unit.update');

                    Route::get('{model}/destroy','OrderOption\CreationUnitController@destroy')
                        ->where('model', '[0-9]+')
                        ->name('dashboard.order_option.creation_unit.destroy');
                });

                Route::group(['prefix' => 'price-change'],function (){
                    Route::get('','OrderOption\PriceChangeController@index')->name('dashboard.order_option.price_change.index');
                    Route::post('index-json','OrderOption\PriceChangeController@indexJson')->name('dashboard.order_option.price_change.indexJson');
                    Route::get('create','OrderOption\PriceChangeController@create')->name('dashboard.order_option.price_change.create');
                    Route::post('store','OrderOption\PriceChangeController@store')->name('dashboard.order_option.price_change.store');

                    Route::get('{model}/edit','OrderOption\PriceChangeController@edit')
                        ->where('model', '[0-9]+')
                        ->name('dashboard.order_option.price_change.edit');

                    Route::post('{model}/update','OrderOption\PriceChangeController@update')
                        ->where('model', '[0-9]+')
                        ->name('dashboard.order_option.price_change.update');

                    Route::get('{model}/destroy','OrderOption\PriceChangeController@destroy')
                        ->where('model', '[0-9]+')
                        ->name('dashboard.order_option.price_change.destroy');
                });

                Route::group(['prefix' => 'delivery'],function (){
                    Route::get('','OrderOption\DeliveryController@index')->name('dashboard.order_option.delivery.index');
                    Route::post('index-json','OrderOption\DeliveryController@indexJson')->name('dashboard.order_option.delivery.indexJson');
                    Route::get('create','OrderOption\DeliveryController@create')->name('dashboard.order_option.delivery.create');
                    Route::post('store','OrderOption\DeliveryController@store')->name('dashboard.order_option.delivery.store');

                    Route::get('{model}/edit','OrderOption\DeliveryController@edit')
                        ->where('model', '[0-9]+')
                        ->name('dashboard.order_option.delivery.edit');

                    Route::post('{model}/update','OrderOption\DeliveryController@update')
                        ->where('model', '[0-9]+')
                        ->name('dashboard.order_option.delivery.update');

                    Route::get('{model}/destroy','OrderOption\DeliveryController@destroy')
                        ->where('model', '[0-9]+')
                        ->name('dashboard.order_option.delivery.destroy');
                });

                Route::group(['prefix' => 'delivery-status'],function (){
                    Route::get('','OrderOption\DeliveryStatusController@index')->name('dashboard.order_option.delivery_status.index');
                    Route::post('index-json','OrderOption\DeliveryStatusController@indexJson')->name('dashboard.order_option.delivery_status.indexJson');
                    Route::get('create','OrderOption\DeliveryStatusController@create')->name('dashboard.order_option.delivery_status.create');
                    Route::post('store','OrderOption\DeliveryStatusController@store')->name('dashboard.order_option.delivery_status.store');

                    Route::get('{model}/edit','OrderOption\DeliveryStatusController@edit')
                        ->where('model', '[0-9]+')
                        ->name('dashboard.order_option.delivery_status.edit');

                    Route::post('{model}/update','OrderOption\DeliveryStatusController@update')
                        ->where('model', '[0-9]+')
                        ->name('dashboard.order_option.delivery_status.update');

                    Route::get('{model}/destroy','OrderOption\DeliveryStatusController@destroy')
                        ->where('model', '[0-9]+')
                        ->name('dashboard.order_option.delivery_status.destroy');
                });

                Route::group(['prefix' => 'payment-status'],function (){
                    Route::get('','OrderOption\PaymentStatusController@index')->name('dashboard.order_option.payment_status.index');
                    Route::post('index-json','OrderOption\PaymentStatusController@indexJson')->name('dashboard.order_option.payment_status.indexJson');
                    Route::get('create','OrderOption\PaymentStatusController@create')->name('dashboard.order_option.payment_status.create');
                    Route::post('store','OrderOption\PaymentStatusController@store')->name('dashboard.order_option.payment_status.store');

                    Route::get('{model}/edit','OrderOption\PaymentStatusController@edit')
                        ->where('model', '[0-9]+')
                        ->name('dashboard.order_option.payment_status.edit');

                    Route::post('{model}/update','OrderOption\PaymentStatusController@update')
                        ->where('model', '[0-9]+')
                        ->name('dashboard.order_option.payment_status.update');

                    Route::get('{model}/destroy','OrderOption\PaymentStatusController@destroy')
                        ->where('model', '[0-9]+')
                        ->name('dashboard.order_option.payment_status.destroy');
                });

                Route::group(['prefix' => 'payment-method'],function (){
                    Route::get('','OrderOption\PaymentMethodController@index')->name('dashboard.order_option.payment_method.index');
                    Route::post('index-json','OrderOption\PaymentMethodController@indexJson')->name('dashboard.order_option.payment_method.indexJson');
                    Route::get('create','OrderOption\PaymentMethodController@create')->name('dashboard.order_option.payment_method.create');
                    Route::post('store','OrderOption\PaymentMethodController@store')->name('dashboard.order_option.payment_method.store');

                    Route::get('{model}/edit','OrderOption\PaymentMethodController@edit')
                        ->where('model', '[0-9]+')
                        ->name('dashboard.order_option.payment_method.edit');

                    Route::post('{model}/update','OrderOption\PaymentMethodController@update')
                        ->where('model', '[0-9]+')
                        ->name('dashboard.order_option.payment_method.update');

                    Route::get('{model}/destroy','OrderOption\PaymentMethodController@destroy')
                        ->where('model', '[0-9]+')
                        ->name('dashboard.order_option.payment_method.destroy');
                });

                Route::group(['prefix' => 'product-location'],function (){
                    Route::get('','OrderOption\ProductLocationController@index')->name('dashboard.order_option.product_location.index');
                    Route::post('index-json','OrderOption\ProductLocationController@indexJson')->name('dashboard.order_option.product_location.indexJson');
                    Route::get('create','OrderOption\ProductLocationController@create')->name('dashboard.order_option.product_location.create');
                    Route::post('store','OrderOption\ProductLocationController@store')->name('dashboard.order_option.product_location.store');

                    Route::get('{model}/edit','OrderOption\ProductLocationController@edit')
                        ->where('model', '[0-9]+')
                        ->name('dashboard.order_option.product_location.edit');

                    Route::post('{model}/update','OrderOption\ProductLocationController@update')
                        ->where('model', '[0-9]+')
                        ->name('dashboard.order_option.product_location.update');

                    Route::get('{model}/destroy','OrderOption\ProductLocationController@destroy')
                        ->where('model', '[0-9]+')
                        ->name('dashboard.order_option.product_location.destroy');
                });

                Route::group(['prefix' => 'return-location'],function (){
                    Route::get('','OrderOption\ReturnLocationController@index')->name('dashboard.order_option.return_location.index');
                    Route::post('index-json','OrderOption\ReturnLocationController@indexJson')->name('dashboard.order_option.return_location.indexJson');
                    Route::get('create','OrderOption\ReturnLocationController@create')->name('dashboard.order_option.return_location.create');
                    Route::post('store','OrderOption\ReturnLocationController@store')->name('dashboard.order_option.return_location.store');

                    Route::get('{model}/edit','OrderOption\ReturnLocationController@edit')
                        ->where('model', '[0-9]+')
                        ->name('dashboard.order_option.return_location.edit');

                    Route::post('{model}/update','OrderOption\ReturnLocationController@update')
                        ->where('model', '[0-9]+')
                        ->name('dashboard.order_option.return_location.update');

                    Route::get('{model}/destroy','OrderOption\ReturnLocationController@destroy')
                        ->where('model', '[0-9]+')
                        ->name('dashboard.order_option.return_location.destroy');
                });
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