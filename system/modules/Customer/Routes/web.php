<?php
Route::group([
    'middleware' => 'web',
    'namespace' => 'Modules\\Customer\\Http\\Controllers\\Web',
    'as' => 'customer.'
], function () {
    Route::auth();

    Route::group([
        'middleware' => 'auth:customer'
    ], function () {
        Route::name('profile')->get('/profile', 'ProfileController@index');
        Route::post('/profile', 'ProfileController@change');
        Route::name('affiliate')->get('/profile/affiliate', 'ProfileController@affiliate');
        Route::name('password')->get('/profile/password', 'PasswordController@index');
        Route::post('/profile/password', 'PasswordController@change');
    });
});

Route::get('customer/export/{lang}', 'Modules\\Customer\\Http\\Controllers\\Admin\\CustomerController@export');