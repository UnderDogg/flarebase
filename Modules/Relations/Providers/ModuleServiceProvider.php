<?php

namespace Modules\Relations\Providers;

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
        $this->loadTranslationsFrom(__DIR__ . '/../Resources/Lang', 'relations');
        $this->loadViewsFrom(__DIR__ . '/../Resources/Views', 'relations');
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
        $this->app->bind('Modules\Relations\Services\Relation\RelationServiceContract', 'Modules\Relations\Services\Relation\RelationService');
        // add bindings
    }


}
