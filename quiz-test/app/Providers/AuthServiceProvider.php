<?php

namespace App\Providers;

use App\Events\PlayerJoined;
use App\Events\AnswerReceived;
use App\PlayerSession;
use App\Policies\QuizSessionPolicy;
use App\QuizSession;
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

        //
    }
}
