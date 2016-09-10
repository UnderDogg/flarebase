<?php
namespace Modules\Invoices\Providers;

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
        $this->loadTranslationsFrom(__DIR__ . '/../Resources/Lang', 'invoices');
        $this->loadViewsFrom(__DIR__ . '/../Resources/Views', 'invoices');
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
        $this->app->bind('Modules\Invoices\Services\Invoice\InvoiceServiceContract', 'Modules\Invoices\Services\Invoice\InvoiceService');
        // add bindings
    }


}
