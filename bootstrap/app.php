<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append(\App\Http\Middleware\SanitizeInput::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Make sure all api request should be return json response
        $exceptions->shouldRenderJsonWhen(function (Request $request) {
            return $request->is('api/*') || $request->expectsJson();
        });

        // Custom exception handle
//        $exceptions->render(function (Throwable $exception) {
//            $statusCode = match (true) {
//                $exception instanceof NotFoundHttpException => 404,
//                $exception instanceof ThrottleRequestsException => 429,
//                default => 500,
//            };
//
//            $message = match (true) {
//                $exception instanceof NotFoundHttpException => $exception->getMessage(),
//                $exception instanceof ThrottleRequestsException => $exception->getMessage(),
//                default => 'Internal Server Error',
//            };
//
//            return response()->json([
//                'success' => false,
//                'message' => $message,
//                'code' => $statusCode,
//            ], $statusCode);
//        });

    })->create();
