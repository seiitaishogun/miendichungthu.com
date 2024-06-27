<?php

Route::group([
    'prefix' => admin_path(),
    'middleware' => ['web', 'admin'],
    'as' => 'admin.',
    'namespace' => 'Modules\\Blog\\Http\\Controllers\\Admin'
], function () {

    // Category
    Route::name('post.category.index')->get('/post/category', 'CategoryController@index');
    Route::name('post.category.position')->post('post/category/sort/{postCategory}', 'CategoryController@position');
    Route::name('post.category.create')->get('/post/category/create', 'CategoryController@create');
    Route::name('post.category.store')->post('/post/category', 'CategoryController@store');
    Route::name('post.category.edit')->get('/post/category/{postCategory}/edit', 'CategoryController@edit');
    Route::name('post.category.update')->put('/post/category/{postCategory}', 'CategoryController@update');
    Route::name('post.category.destroy')->delete('/post/category/{postCategory}', 'CategoryController@destroy');

    // Post
    Route::post('post/sort/{post}', 'PostController@position');
    Route::resource('post', 'PostController');
});