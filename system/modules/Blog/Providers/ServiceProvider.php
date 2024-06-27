<?php

namespace Modules\Blog\Providers;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Migrations');
        $this->loadTranslationsFrom(__DIR__ . '/../Languages', 'blog');
        $this->loadViewsFrom(__DIR__ . '/../Views', 'blog');

        $this->loadRoutesFrom(__DIR__ . '/../Routes/admin.php');
        $this->loadRoutesFrom(__DIR__ . '/../Routes/web.php');
        $this->loadRoutesFrom(__DIR__ . '/../Routes/api.php');
    }

    public function register()
    {
        /**
         * COMMENT HOOK
         * @type array
         * @param class
         */
        register_hook('post_comment');

        add_action('module_in_menu_search_hook', [
            'name' => 'Blog',
            'url' => '/api/search/blog',
        ]);

        add_action('module_in_menu_search_hook', [
            'name' => 'Blog Category',
            'url' => '/api/search/blog/category',
        ]);
    }
}