<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        'App\Events\OrderCreated' => [
            'App\Listeners\SendOrderConfirmation',
            'App\Listeners\UpdateProductStock',
        ],
        'App\Events\OrderStatusChanged' => [
            'App\Listeners\SendOrderStatusNotification',
        ],
    ];

    public function boot()
    {
        //
    }
}