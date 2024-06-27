<?php

Route::group([
    'middleware' => ['web'],
    'namespace' => 'Modules\\Blog\\Http\\Controllers\\Web'
], function () {
	Route::get('blogs/agency', 'PostController@agency');
    Route::get('blogs/search', 'PostController@search');
    Route::name('post.shortlink')->get('blogs/posts', 'PostController@shortlink');

    Route::name('post.category.shortlink')->get('blogs', 'CategoryController@shortlink');
    Route::name('post.category.show')->get('blogs/{slug}', 'CategoryController@show');

    Route::name('post.show')->get('blogs/{category}/{slug}', 'PostController@show');
});