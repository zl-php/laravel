<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
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
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (InvalidRequestException $e) {})->stop();
    }

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof ModelNotFoundException || $exception instanceof NotFoundHttpException) {
            throw new HttpRequestException($this->getErrorMessage('not_found'), 404);
        }  elseif ($exception instanceof ThrottleRequestsException) {
            throw new HttpRequestException($this->getErrorMessage('request_frequent'), 429);
        }  elseif ($exception instanceof MethodNotAllowedHttpException) {
            throw new HttpRequestException($this->getErrorMessage('method_not_allowed'), 405);
        }

        return parent::render($request, $exception);
    }

    // 输出提示文字
    protected function getErrorMessage($key)
    {
        $message = [
            'method_not_allowed'    => '请求的方式不被允许.',
            'not_found'             => '请求的方法不存在.',
            'request_frequent'      => '请求频繁.'
        ];

        return $message[$key] ?? '服务器错误';
    }
}
