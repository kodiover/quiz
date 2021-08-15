<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use App\Models\QuizSession;
use App\Policies\QuizSessionPolicy;
use App\Providers\ConfigUserProvider;
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
        QuizSession::class => QuizSessionPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Auth::provider('config', function($app, array $config) {
            return new ConfigUserProvider($config['password'] ?? null, $config['name'] ?? null);
        });
    }
}
