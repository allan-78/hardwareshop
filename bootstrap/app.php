<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\VerifyCsrfToken;
use App\Http\Middleware\TrimStrings;
use App\Http\Middleware\TrustProxies;
use App\Http\Middleware\EncryptCookies;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up'
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web([
            EncryptCookies::class,
            VerifyCsrfToken::class,
            TrimStrings::class,
            TrustProxies::class,
        ]);

        $middleware->group('admin', [
            'web',
            'auth',
            AdminMiddleware::class,
        ]);

        $middleware->alias([
            'admin' => AdminMiddleware::class,
        ]);

        $middleware->priority([
            EncryptCookies::class,
            TrustProxies::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->report(function (\Throwable $e) {
            // Report exceptions here
        });

        $exceptions->render(function (\Throwable $e) {
            //
        });

        $exceptions->renderable(function (\Exception $e) {
            //
        });
    })
    ->create();


