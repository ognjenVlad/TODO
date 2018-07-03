<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

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
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof Tymon\JWTAuth\Exceptions\TokenExpiredException) {
            \Log::debug('TOKEN EXPIRED');
            return response()->json(['token_expired'], $exception->getStatusCode());
        } else if ($exception instanceof Tymon\JWTAuth\Exceptions\TokenInvalidException) {
            \Log::debug('TOKEN_INVALID');
            return response()->json(['token_invalid'], $exception->getStatusCode());
        }else if ($exception instanceof \Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException) {
            \Log::debug('TOKEN_ABSCENT');
            return response()->json(['token_abscent'], $exception->getStatusCode());
        }
        \Log::debug('NO EXCEPTION');
        return parent::render($request, $exception);
    }
}
