<?php

Route::group([
    'middleware' => ['web'],
    'namespace' => 'Modules\\Page\\Http\\Controllers\\Web'
], function () {
    Route::name('page.shortlink')->get('pages', 'PageController@shortlink');
    Route::name('page.show')->get('pages/{slug}', 'PageController@show');
});