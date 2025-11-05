<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // دعم مصادقة SPA عبر Sanctum بالكوكيز لمسارات API
        $middleware->prependToGroup('api', \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class);
        // فرض ترميز UTF-8 لكل الردود النصية لمنع تشوه العربية
        $middleware->append(\App\Http\Middleware\ForceUtf8Headers::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
