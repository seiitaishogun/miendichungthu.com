<?php

Route::group([
    'middleware' => ['web'],
    'namespace' => 'Modules\\Gallery\\Http\\Controllers\\Web'
], function () {
    Route::name('gallery.category.shortlink')->get('gallery/collections', 'CategoryController@shortlink');
    Route::name('gallery.category.show')->get('gallery/collections/{slug}', 'CategoryController@show');

    Route::name('gallery.list.album')->get('gallery/albums', 'GalleryController@album');
    Route::name('gallery.list.video')->get('gallery/videos', 'GalleryController@video');
    Route::name('gallery.shortlink')->get('gallery', 'GalleryController@shortlink');
    Route::name('gallery.show')->get('gallery/{slug}', 'GalleryController@show');
});