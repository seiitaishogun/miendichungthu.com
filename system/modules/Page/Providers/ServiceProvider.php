<?php

namespace Modules\Page\Providers;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Migrations');
        $this->loadTranslationsFrom(__DIR__ . '/../Languages', 'page');
        $this->loadViewsFrom(__DIR__ . '/../Views', 'page');

        $this->loadRoutesFrom(__DIR__ . '/../Routes/admin.php');
        $this->loadRoutesFrom(__DIR__ . '/../Routes/web.php');
        $this->loadRoutesFrom(__DIR__ . '/../Routes/api.php');
    }

    public function register()
    {
        add_action('module_in_menu_search_hook', [
            'name' => 'Page',
            'url' => '/api/search/page',
        ]);
    }
}