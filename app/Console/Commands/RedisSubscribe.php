<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class RedisSubscribe extends Command
{
    /**
     * 订阅命令
     *
     * @var string
     */
    protected $signature = 'redis:subscribe';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Subscribe to a Redis channel';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // 程序底层网络资源上执行读取或写入操作时使用了超时，默认设置了timeout 为60s，所以这里要设置用不超时
        ini_set('default_socket_timeout', -1);

        $redis = Redis::connection('publisher');
        $redis->subscribe(['test-channel'], function ($data, $message) {
            echo $data;
        });
    }
}
