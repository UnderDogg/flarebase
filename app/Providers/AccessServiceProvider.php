<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AccessServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \Modules\Core\Services\User\UserServiceContract::class,
            \Modules\Core\Services\User\UserService::class
        );
        $this->app->bind(
            \Modules\Core\Role\RoleRepositoryContract::class,
            \Modules\Core\Role\RoleRepository::class
        );
        $this->app->bind(
            \App\Services\Department\DepartmentServiceContract::class,
            \App\Services\Department\DepartmentService::class
        );
        $this->app->bind(
            \Modules\Core\Setting\SettingRepositoryContract::class,
            \Modules\Core\Setting\SettingRepository::class
        );
        $this->app->bind(
            \Modules\Tickets\Services\Ticket\TicketServiceContract::class,
            \Modules\Tickets\Ticket\TicketService::class
        );
        $this->app->bind(
            \Modules\Relations\Services\Relation\RelationServiceContract::class,
            \Modules\Relations\Services\Relation\RelationService::class
        );
        $this->app->bind(
            \Modules\Leads\Services\Lead\LeadServiceContract::class,
            \Modules\Leads\Services\Lead\LeadService::class
        );
        $this->app->bind(
            \Modules\Invoices\Services\Invoice\InvoiceServiceContract::class,
            \Modules\Invoices\Services\Invoice\InvoiceService::class
        );
    }
}
