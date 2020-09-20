<?php

namespace App\Providers;

use App\Events\TestEvent;
use App\Listeners\ConfigureTenantConnection;
use App\Listeners\ConfigureTenantDatabase;
use App\Listeners\ConfigureTenantMigrations;
use App\Listeners\ResolveTenantConnection;
use App\Listeners\TestListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Tenancy\Affects\Connections\Events\Drivers\Configuring as DriversConfiguring;
use Tenancy\Affects\Connections\Events\Resolving;
use Tenancy\Hooks\Database\Events\Drivers\Configuring;
use Tenancy\Hooks\Migration\Events\ConfigureMigrations;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        Configuring::class => [
            ConfigureTenantDatabase::class,
        ],
        DriversConfiguring::class => [
            ConfigureTenantConnection::class,
        ],
        ConfigureMigrations::class => [
            ConfigureTenantMigrations::class,
        ],
        Resolving::class => [
            ResolveTenantConnection::class,
        ],

        TestEvent::class => [
            TestListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
