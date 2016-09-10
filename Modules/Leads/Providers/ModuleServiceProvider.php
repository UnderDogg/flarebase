<?php
namespace Modules\Leads\Providers;

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
        $this->loadTranslationsFrom(__DIR__ . '/../Resources/Lang', 'leads');
        $this->loadViewsFrom(__DIR__ . '/../Resources/Views', 'leads');
    }

    /**
     * Register the module services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
        $this->registerBindings();
    }

    private function registerBindings()
    {
        $this->app->bind('Modules\Leads\Services\Lead\LeadServiceContract', 'Modules\Leads\Services\Lead\LeadService');
        // add bindings
    }


}
