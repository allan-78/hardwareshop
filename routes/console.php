<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Console\Kernel;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Custom maintenance commands
Artisan::command('shop:clear-expired-carts', function () {
    // Clear expired shopping carts
})->purpose('Clear expired shopping carts');

Artisan::command('shop:send-order-reminders', function () {
    // Send reminders for pending orders
})->purpose('Send reminders for pending orders');

// In App\Providers\RouteServiceProvider.php

    // $this->routes(function () {
    //     Route::middleware('web')
    //         ->group(base_path('routes/web.php'));

    //     Route::middleware('web')
    //         ->group(base_path('routes/admin.php'));

    //     Route::prefix('api')
    //         ->middleware('api')
    //         ->group(base_path('routes/api.php'));
    // });

