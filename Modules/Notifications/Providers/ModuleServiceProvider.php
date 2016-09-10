<?php
namespace Modules\Notifications\Providers;

use Caffeinated\Modules\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the module services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__ . '/../Resources/Lang', 'notifications');
        $this->loadViewsFrom(__DIR__ . '/../Resources/Views', 'notifications');
    }

    /**
     * Register the module services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
        //$this->registerBindings();
    }

    private function registerBindings()
    {
        $this->app->bind('Modules\Notifications\Services\Notifications\NotificationServiceContract', 'Modules\Notifications\Services\Notification\NotificationService');
        // add bindings
    }


}
