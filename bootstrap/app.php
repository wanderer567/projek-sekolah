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
        // 1. Daftarkan Middleware Web agar UserActivity berjalan di setiap halaman
        $middleware->web(append: [
            \App\Http\Middleware\UserActivity::class,
        ]);

        // 2. Alias yang sudah kamu buat sebelumnya
        $middleware->alias([
            'checkRole' => \App\Http\Middleware\RoleManager::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();