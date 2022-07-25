<?php
namespace App\Exceptions;

use Exception;
use Throwable;

class HttpRequestException extends Exception
{
    public function __construct($message, $code, Throwable $previous = null)
    {
        parent::__construct($message, intval($code), $previous);
    }

    public function render()
    {
        $result = [
            'errcode' => $this->getCode(),
            'message' => $this->getMessage(),
            'data' => []
        ];

        return response()->json($result, $this->getCode());
    }
}
