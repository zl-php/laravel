<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exceptions\InvalidRequestException;

class TestController extends Controller
{
    public function test()
    {
        echo 1;

        //throw new InvalidRequestException('参数不能为空');
    }
}
