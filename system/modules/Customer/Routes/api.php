<?php
Route::group([
    'middleware' => [
        'api'
    ],
    'namespace' => 'Modules\\Customer\\Http\\Controllers\\API',
    'prefix' => 'api/customer'
], function () {
    Route::get('info', 'CustomerController@getInfoById');
});
