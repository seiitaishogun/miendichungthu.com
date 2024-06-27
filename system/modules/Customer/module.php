<?php
return [
    'name' => 'Customer',
    'slug' => 'customer',
    'version' => '1.3.6',
    'latest_version' => '1.3.6',
    'description' => 'Manage all customers on website',
    'status' => 1,
    'position' => 9,
    'providers' => [
        \Modules\Customer\Providers\ServiceProvider::class
    ],
    'helpers_autoload' => [
        'customs',
    ]
];
