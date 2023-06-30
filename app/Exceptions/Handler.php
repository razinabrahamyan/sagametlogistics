<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|\Symfony\Component\HttpFoundation\Response
     * @throws Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($this->isHttpException($exception)) {
//            if ($exception->getStatusCode() == 404) {
            return response()->view('content.errors.404', [], 404);
//            }
        }

        if ($exception instanceof \ErrorException) {
            if (!config('app.debug')) {
                return response()->view('content.errors.500', [
                    "error" => $exception->getMessage()
                ], 500);
            }
        }

        return parent::render($request, $exception);
    }
}
