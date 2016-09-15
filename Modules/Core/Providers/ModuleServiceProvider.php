<?php
namespace Modules\Core\Providers;

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
        $this->loadTranslationsFrom(__DIR__ . '/../Resources/Lang', 'core');
        $this->loadViewsFrom(__DIR__ . '/../Resources/Views', 'core');
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

        $service = new \Modules\Core\Services\User\UserService();

        $this->app->bind('Modules\Core\Services\User\UserServiceContract', 'Modules\Core\Services\User\UserService');
        $this->app->bind('Modules\Core\Services\Setting\SettingServiceContract', 'Modules\Core\Services\Setting\SettingService');

        $this->app->bind('Modules\Core\Services\Department\DepartmentServiceContract', 'Modules\Core\Services\Department\DepartmentService');

        $this->app->bind('Modules\Core\Services\Staff\StaffServiceContract', 'Modules\Core\Services\Staff\StaffService');

        $this->app->bind('Modules\Core\Services\Role\RoleServiceContract', 'Modules\Core\Services\Role\RoleService');

        /*    $this->app->bind(
          'Modules\Core\Services\User\UserServiceContract',
          function () {
            $service = new \Modules\Core\Services\User\UserServiceContract(new \Modules\Core\Models\User());
            return $service;

          }
        );*/
        // add bindings
    }
}
