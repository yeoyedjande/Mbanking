<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use App\Models\Role;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Role::class => RolePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('is-admin', function ($user) {
            return $user->role->id == 1; 
        });

        Gate::define('view-parametres', function ($user) {
            return $user->role->id == 1;
        });

        Gate::define('is-caissier', function ($user) {
            return $user->role->id == 4; 
        });

        Gate::define('is-receptioniste', function ($user) {
            return $user->role->id == 9; 
        });

        Gate::define('is-caissier-principal', function ($user) {
            return $user->role->id == 5; 
        });

        Gate::define('is-analyste-credit', function ($user) {
            return $user->role->id == 7; 
        });

        Gate::define('is-service-operation', function ($user) {
            return $user->role->id == 8; 
        });

        Gate::define('is-chef-service-credit', function ($user) {
            return $user->role->id == 10; 
        });

        Gate::define('is-comptable', function ($user) {
            return $user->role->id == 3; 
        });

        Gate::define('is-direction', function ($user) {
            return $user->role->id == 6; 
        });

    }
}
