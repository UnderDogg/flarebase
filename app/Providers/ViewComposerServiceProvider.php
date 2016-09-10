<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(
            ['user.show'], 'App\Http\ViewComposers\UserHeaderComposer'
        );
        view()->composer(
            ['relations.show'], 'App\Http\ViewComposers\RelationHeaderComposer'
        );
        view()->composer(
            ['tickets.show'], 'App\Http\ViewComposers\TicketHeaderComposer'
        );
        view()->composer(
            ['invoices.show'], 'App\Http\ViewComposers\InvoiceHeaderComposer'
        );
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
