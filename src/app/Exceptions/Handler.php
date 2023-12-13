<?php

namespace App\Exceptions;

use Throwable;
use TypeError;
use ArgumentCountError;
use App\Traits\ApiResponser;
use Illuminate\Http\Response;
use Illuminate\Database\QueryException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class Handler extends ExceptionHandler
{
    use ApiResponser;
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

    public function render($request, Throwable $exception)
    {
        //dd($exception);
        if ($exception instanceof ValidationException) {
            $code = $exception->status;
            $message = null;
            foreach ($exception->errors() as $key => $value) {
                if (is_array($value)) {
                    foreach ($value as $v) {
                        $message = $v;
                        break;
                    }
                } else {
                    $message = $value;
                    break;
                }
            }
            return $this->errorResponse("ERR_", $message, $code);
        } else if ($exception instanceof MethodNotAllowedHttpException) {
            $code = $exception->getStatusCode();
            $message = "Method URL tidak diizinkan";
            return $this->errorResponse('METHOD_NOT_ALLOWED', $message, $code);
        } else if ($exception instanceof QueryException) {
            $code = 404;
            $message = "Data sudah tidak tersedia";
            return $this->errorResponse('NOT_FOUND', $message, $code);
        } else if ($exception instanceof NotFoundHttpException) {
            $code = $exception->getStatusCode();
            $message = Response::$statusTexts[$code];
            return $this->errorResponse('NOT_FOUND', $message, $code);
        } else if ($exception instanceof NabituException) {
            return $this->errorResponse('ERR_NABITU', $exception->message, $exception->status);
        } else if ($exception instanceof TypeError) {
            return $this->errorResponse('HTTP_INTERNAL_SERVER_ERROR', 'Jangan asal bro', Response::HTTP_INTERNAL_SERVER_ERROR);
        } else if ($exception instanceof AuthenticationException) {
            return $this->errorResponse('ERR_INVALID_ACCESS_TOKEN', 'invalid access token', Response::HTTP_UNAUTHORIZED);
        } else if ($exception instanceof ArgumentCountError) {
            return $this->errorResponse('HTTP_REQUEST_TIMEOUT', 'Argument tidak lengkap', Response::HTTP_REQUEST_TIMEOUT);
        }

        if (env('APP_DEBUG', false)) {
            return parent::render($request, $exception);
        }
    }
}
