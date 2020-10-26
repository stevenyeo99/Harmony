<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('is-boss', function($user) {
            return $user->is_boss == 'YESNO';
        });

        Gate::define('is-admin', function($user) {
            return $user->is_admin == 'YES'; 
        });

        Gate::define('is-user', function($user) {
            return $user->is_admin == 'NO';
        });
    }
}
