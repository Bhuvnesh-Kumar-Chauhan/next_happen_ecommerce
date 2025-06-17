<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // Map models to their policies if any
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

        Gate::before(function ($user, $ability) {
            return $user->hasRole('admin') ? true : null;
        });

        Gate::after(function ($user, $ability) {
            return $user->hasRole('admin'); 
        });
        Gate::define('category_delete', function ($user) {
            return $user->hasPermissionTo('delete-category'); 
        });
        Gate::define('subcategory_access', function ($user) {
            return $user->hasPermissionTo('view_subcategories'); 
        });

    }
}
