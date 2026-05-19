<?php

use Illuminate\Foundation\Application;
// --- TAMBAHKAN DUA BARIS INI ---
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
// -------------------------------
use App\Http\Middleware\EnsureIsAdmin;
use App\Http\Middleware\EnsureIsRegularUser;
 
return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Daftarkan alias agar bisa dipakai di routes/web.php
        $middleware->alias([
            'admin'       => EnsureIsAdmin::class,
            'user.only'   => EnsureIsRegularUser::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();