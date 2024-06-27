<?php
namespace Modules\Customer\Providers;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Migrations');
        
        $this->loadTranslationsFrom(__DIR__ . '/../Languages', 'customer');
        
        $this->loadViewsFrom(__DIR__ . '/../Views', 'customer');
        
        $this->loadRoutesFrom(__DIR__ . '/../Routes/admin.php');
        
        $this->loadRoutesFrom(__DIR__ . '/../Routes/web.php');
        
        $this->loadRoutesFrom(__DIR__ . '/../Routes/api.php');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        register_hook('customer_settings_fields');
        
        add_action('customer_settings_fields', 'customer::form.avatar');
        add_action('customer_settings_fields', 'customer::form.information');
    }
}
