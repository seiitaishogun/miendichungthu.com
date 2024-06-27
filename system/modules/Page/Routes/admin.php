<?php

Route::group([
    'prefix' => admin_path(),
    'middleware' => ['web', 'admin'],
    'as' => 'admin.',
    'namespace' => 'Modules\\Page\\Http\\Controllers\\Admin'
], function () {
    Route::resource('page', 'PageController');
});