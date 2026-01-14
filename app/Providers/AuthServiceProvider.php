<?php

namespace App\Providers;

use App\Models\Lead;
use App\Policies\LeadPolicy;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
     protected $policies = [
        Lead::class => LeadPolicy::class,
    ];
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
