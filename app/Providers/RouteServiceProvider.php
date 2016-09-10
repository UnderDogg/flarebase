<?php
namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapWebRoutes();
        $this->mapAdminRoutes();
        $this->mapStaffRoutes();
        $this->mapClientRoutes();
        $this->mapApiRoutes();
        //
    }


    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::group([
            'middleware' => 'web',
            'namespace' => $this->namespace,
        ], function ($router) {
            require base_path('routes/web.php');
        });
    }


    /**
     * Define the "staff" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapStaffRoutes()
    {
        Route::group([
            'middleware' => 'staff',
            'namespace' => 'Modules\Core\Http\Controllers',
            //'prefix' => 'staffpanel',
        ], function ($router) {
            require base_path('Modules/Core/Routes/staffRoutes.php');
        });
    }

    /**
     * Define the "admin" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapAdminRoutes()
    {
        Route::group([
            //['namespace' => 'Admin']
            'middleware' => 'staff',
            'namespace' => 'Modules\Core\Http\Controllers',
            //'prefix' => 'adminpanel',
        ], function ($router) {
            require base_path('Modules/Core/Routes/adminRoutes.php');
        });
    }


    /**
     * Define the "client" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapClientRoutes()
    {
        Route::group([
            'middleware' => 'client',
            'namespace' => $this->namespace,
            //'prefix' => 'client',
        ], function ($router) {
            require base_path('Modules/Core/Routes/clientRoutes.php');
        });
    }


    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::group([
            'middleware' => 'api',
            'namespace' => $this->namespace,
            'prefix' => 'api',
        ], function ($router) {
            require base_path('Modules/Core/Routes/apiRoutes.php');
        });
    }
}