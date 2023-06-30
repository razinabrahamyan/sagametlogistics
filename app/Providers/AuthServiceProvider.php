<?php

namespace App\Providers;

use App\Classes\Constants\RolesConstants;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        self::gates();
    }

    public static function gates()
    {
        Gate::define('showAdmin', function () {
            return RolesConstants::isAdmin();
        });

        Gate::define('showLogist', function () {
            return (RolesConstants::isAdmin() || RolesConstants::isLogist());
        });

        Gate::define('showManager', function () {
            return (RolesConstants::isManager() || RolesConstants::isAdmin() || RolesConstants::isLogist());
        });

        Gate::define('showPersonal', function () {
            return (RolesConstants::isLogisticPersonnel());
        });

        Gate::define('showResponsibleForDrivers', function () {
            return (RolesConstants::isResponsibleForDrivers());
        });
    }
}
