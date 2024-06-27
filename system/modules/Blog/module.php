<?php
/**
 * SETTING OF BLOG
 *
 * blog_has_province
 * blog_has_district
 * blog_has_address
 * blog_has_type
 */
return [
    'name' => 'Blog',
    'slug' => 'blog',
    'version' => '2.4.4',
    'latest_version' => '2.4.4',
    'description' => 'Manage all posts on website',
    'status' => 1,
    'position' => 2,
    'providers' => [
        \Modules\Blog\Providers\ServiceProvider::class
    ],
    'helpers_autoload' => [
        'posts',
    ]
];
