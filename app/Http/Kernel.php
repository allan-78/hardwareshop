protected $routeMiddleware = [
    // ...existing middlewares...
    'admin' => \App\Http\Middleware\AdminMiddleware::class,
];