<?php
namespace Modules\Helpdesk\Providers;

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
        $this->loadTranslationsFrom(__DIR__ . '/../Resources/Lang', 'helpdesk');
        $this->loadViewsFrom(__DIR__ . '/../Resources/Views', 'helpdesk');
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
        $this->app->bind('Modules\Helpdesk\Services\Helpdesk\HelpdeskServiceContract', 'Modules\Helpdesk\Services\Helpdesk\HelpdeskService');
        // add bindings
    }


}
