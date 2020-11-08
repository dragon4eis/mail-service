<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

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
        'App\Events\EmailCreate' => [
            'App\Listeners\LogCreate'
        ],
        'App\Events\EmailProcessing' => [
            'App\Listeners\LogProcessing',
        ],
        'App\Events\EmailFailed' => [
            'App\Listeners\LogFailure',
        ],
        'App\Events\EmailSend' => [
            'App\Listeners\LogSuccess',
        ]
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
