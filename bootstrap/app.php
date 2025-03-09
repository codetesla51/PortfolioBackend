<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Illuminate\Session\Middleware\StartSession;
use App\Http\Middleware\AdminAuthMiddleware; // Import middleware

return Application::configure(basePath: dirname(__DIR__))
  ->withRouting(
    web: base_path("routes/api.php"),
    commands: __DIR__ . "/../routes/console.php",
    health: "/up",
    then: function () {}
  )
  ->withMiddleware(function (Middleware $middleware) {
    $middleware->validateCsrfTokens(except: ["*"]);
    $middleware->append(StartSession::class);

    // Register AdminAuthMiddleware, but DO NOT apply it globally
    $middleware->alias([
        'admin.auth' => AdminAuthMiddleware::class
    ]);
  })
  ->withExceptions(function (Exceptions $exceptions) {})
  ->create();