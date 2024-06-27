<?php

return [
    'name' => 'Contact',
    'slug' => 'contact',
    'version' => '1.2.6 ',
    'latest_version' => '1.2.6',
    'description' => 'Contacts module',
    'status' => 1,
    'position' => 3,
    'providers' => [
        \Modules\Contact\Providers\ServiceProvider::class
    ]
];
