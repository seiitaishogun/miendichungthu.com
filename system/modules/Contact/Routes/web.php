<?php

Route::group([
    'middleware' => ['web'],
    'namespace' => 'Modules\\Contact\\Http\\Controllers'
], function () {
    Route::get('/contact', 'ContactController@index');
    Route::post('/contact', 'ContactController@send');
});