<?php
Route::group([
    'prefix' => admin_path(),
    'namespace' => 'Modules\\Customer\\Http\\Controllers\\Admin',
    'middleware' => [
        'web',
        'admin'
    ],
    'as' => 'admin.'
], function () {
    Route::group([
        'prefix' => 'customer',
        'as' => 'customer.'
    ], function () {
        Route::resource('group', 'GroupController');
        Route::resource('source', 'SourceController');
    });
    
    Route::resource('customer.address', 'AddressController');
    Route::resource('customer', 'CustomerController');
});
