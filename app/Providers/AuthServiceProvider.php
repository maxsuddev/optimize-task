<?php

namespace App\Providers;

use App\Models\Lead;
use App\Policies\LeadPolicy;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Eloquent\LeadRepository;
use App\Repositories\Eloquent\TaskRepository;
use App\Repositories\Contracts\LeadRepositoryInterface;
use App\Repositories\Contracts\TaskRepositoryInterface;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Lead::class => LeadPolicy::class,
    ];
     public array $bindings = [
        LeadRepositoryInterface::class => LeadRepository::class,
        TaskRepositoryInterface::class => TaskRepository::class,
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
