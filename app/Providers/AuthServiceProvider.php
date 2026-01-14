<?php

namespace App\Providers;

use App\Models\Lead;
use App\Policies\LeadPolicy;
use App\Repositories\Contracts\LeadRepositoryInterface;
use App\Repositories\Eloquent\LeadRepository;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Lead::class => LeadPolicy::class,
    ];
     public array $bindings = [
        LeadRepositoryInterface::class => LeadRepository::class,
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
