<?php

namespace App\Providers;

use App\Models\Ability;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
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

        foreach(Ability::all() as $ability)
        {
            Gate::define($ability->code,function($user) use ($ability) {
                return $user->role->abilities()->where('code',$ability->code)->exists();
            });
        }
    }
}
