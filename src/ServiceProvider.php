<?php

namespace Squadron\Firebase\Auth;

use Illuminate\Support\Facades\Event;
use Squadron\Firebase\Auth\Listeners\CreateFirebaseCustomAuthToken;
use Squadron\User\Events\TokenCreated;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole())
        {
            $this->publishes([
                __DIR__.'/../config/firebaseAuth.php' => config_path('squadron/firebaseAuth.php'),
            ], 'config');
        }

        Event::listen(TokenCreated::class, CreateFirebaseCustomAuthToken::class);
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/firebaseAuth.php', 'squadron.firebaseAuth');
    }
}
