<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\QueryException;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];


    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }


    /**
     * Register the exception handling callbacks for the application.
     * This reset the default message for unauthenticated messages
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'unauthenticated, kindly login',
                'errors' => $exception->getMessage(),
            ], 401);
        }
    }


    public function render($request, Throwable $exception)
    {
        // Handle database query exceptions here
        if ($exception instanceof QueryException) {
            // Example: Log the error and return a custom JSON response
            logger()->error('Database query error:', ['exception' => $exception]);
            return response()->json([
                'success' => false,
                'message' => 'incomplete information',
                // 'errors' => $exception->getMessage(),
                // Trim certain character from the message
                'errors' => trim(substr($exception->getMessage(), 0, strpos($exception->getMessage(), ' (' )), 'SQLSTATE[HY000]: '),
            ], 400);
        }

        return parent::render($request, $exception);
    }

}
