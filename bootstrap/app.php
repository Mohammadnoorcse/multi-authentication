<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->redirectTo(
            guests:'/account/login', // jodi login na theke tahle redirect to login page
            users:'/account/dashboard',//jodi user login theke punoray login korte chay tahle redirect korbe dashboard page
        );
        //admin middleware
        $middleware->alias([
           'admin.gust'=>\App\Http\Middleware\AdminRedirect::class,
           'admin.auth'=>\app\Http\Middleware\AdminAuthenticate::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
