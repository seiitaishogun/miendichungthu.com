<?php

return [
    'name' => 'Page',
    'slug' => 'page',
    'version' => '1.4.5',
    'latest_version' => '1.4.5',
    'description' => 'Manage all pages on website',
    'status' => 1,
    'position' => 2,
    'providers' => [
        \Modules\Page\Providers\ServiceProvider::class
    ],
    'helpers_autoload' => [
        // helpers here
    ]
];
