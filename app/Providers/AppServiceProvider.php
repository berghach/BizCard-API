<?php

namespace App\Providers;

use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\PersonalAccessToken;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);
        
        Gate::guessPolicyNamesUsing(function(string $modelClass){
            switch ($modelClass) {
                case 'App\Models\User':
                    return 'App\Policies\UserPolicy';

                case 'App\Models\Card':
                    return 'App\Policies\CardPolicy';

                case 'App\Models\Contact':
                    return 'App\Policies\ContactPolicy';

                case 'App\Models\Link':
                    return 'App\Policies\LinkPolicy';
                
                default:
                    # code...
                    break;
            }
        });
    }
}
