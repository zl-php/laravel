<?php
namespace App\Exceptions;

use Exception;
use Throwable;
use Illuminate\Support\Arr;

class InvalidRequestException extends Exception
{
    public function __construct($message, $code = 400, Throwable $previous = null)
    {
        parent::__construct($message, intval($code), $previous);
    }

    public function render()
    {
        $result =  config('app.debug') ? [
            'errcode' => $this->getCode(),
            'errmsg' => $this->getMessage(),
            'data' => [],
            'exception' => get_class($this),
            'file' => $this->getFile(),
            'line' => $this->getLine(),
            'trace' => collect($this->getTrace())->map(function ($trace) {
                return Arr::except($trace, ['args']);
            })->all(),
        ] : [
            'errcode' => $this->getCode(),
            'errmsg' => $this->getMessage(),
            'data' => []
        ];

        // 返回错误
        return response()->json($result);
    }
}
