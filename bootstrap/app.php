<?php

use App\Exceptions\RepositoryException;
use App\Exceptions\ServiceException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (ValidationException $e, Request $request) {
            return response()->json([
                'message' => 'There was a validation error.',
                'errors' => $e->errors(),
            ], 422);
        });

        $exceptions->render(function (RepositoryException $e, Request $request) {
            return response()->json([
                'message' => 'Database error: ' . $e->getMessage(),
            ], 500);
        });

        $exceptions->render(function (ServiceException $e, Request $request) {
            return response()->json([
                'message' => 'Service error: ' . $e->getMessage(),
            ], 500);
        });

        $exceptions->render(function (Throwable $e, Request $request) {
            return response()->json([
                'message' => $e->getMessage(),
            ], $e->getCode() ?: 500);
        });
    })->create();
