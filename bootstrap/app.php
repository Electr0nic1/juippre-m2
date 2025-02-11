<?php

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        apiPrefix: 'api-kosmos'
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {

        $exceptions->render(function (NotFoundHttpException $exception) {
            return response()->json([
                "message" => "Not found",
                "code" => 404
            ], 404);
        });

        $exceptions->render(function (AuthenticationException $exception) {
            return response()->json([
                "code" => 401,
                "message" => "Login failed",
            ], 401);
        });

        $exceptions->render(function (AccessDeniedHttpException $exception) {
            return response()->json([
                "code" => 403,
                "message" => "Forbidden for you",
            ], 403);
        });

        $exceptions->render(function (ValidationException $exception) {
            return response()->json([
                "error" => [
                    "code" => 422,
                    "message" => $exception->getMessage(),
                    "errors" => $exception->errors(),
                ]
            ], 422);
        });


    })->create();
