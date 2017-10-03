<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\UserCreated' => [
            'App\Listeners\UserCreatedListener',
        ],

        'App\Events\UserUpdated' => [
            'App\Listeners\UserUpdatedListener',
        ],

        'App\Events\TransactionDestroyed' => [
            'App\Listeners\TransactionDestroyedListener',
        ],

        'App\Events\AccountCreated' => [
            'App\Listeners\AccountCreatedListener',
        ],

        'App\Events\AccountUpdated' => [
            'App\Listeners\AccountUpdatedListener',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
