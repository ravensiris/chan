<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof ValidationException) {
            return $exception->response;
        }

        if ($exception instanceof NotFoundHttpException) {

            $error_data = ['error' => [
                'errors' =>
                [
                    [
                        'domain' => 'global',
                        'reason' => 'notFound',
                        'message' => 'Not Found',
                    ]
                ],
                'code' => 404,
                'message' => 'Not Found'
            ]];
            return response()->json($error_data, 404);
        }

        if ($exception instanceof ModelNotFoundException) {

            $error_data = ['error' => [
                'errors' =>
                [
                    [
                        'domain' => request_domain($request),
                        'reason' => 'notFound',
                        'message' => 'Not Found',
                    ]
                ],
                'code' => 404,
                'message' => 'Not Found'
            ]];
            return response()->json($error_data, 404);
        }

        return parent::render($request, $exception);
    }
}
