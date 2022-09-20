<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\Exceptions\InvalidRequestException;

class RedisController extends Controller
{
    // 发布消息到指定频道
    public function publish()
    {
        Redis::publish('test-channel', json_encode([
            'name' => 'Adam Wathan'
        ]));
    }
}
