<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('isAdminANDGVHD', function ($user){
            if($user->position != 1){
                return true;
            }
            return false;
        });

        Gate::define('isUser', function ($user){
            if($user->position == 1){
                return true;
            }
            return false;
        });

        Gate::define('isAuthor', function ($user, $idCurrent){
            if($user->id == $idCurrent){
                return true;
            }
            return false;
        });
    }
}
