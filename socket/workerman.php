<?php
# @Author : zhoulei1
# @Time   : 2022-09-20
# @File   : workerman.php

require_once  dirname(__DIR__ ) . '/vendor/autoload.php';

use Workerman\Worker;
use Workerman\Connection\TcpConnection;
use Workerman\Protocols\Http\Request;

global $worker;

$worker = new Worker('websocket://0.0.0.0:3000');

// worker进程启动后建立一个内部通讯端口
$worker->onWorkerStart = function($worker)
{
    $http_worker = new Worker("http://0.0.0.0:12356");


    // 接收到浏览器发送的数据时回复hello world给浏览器
    $http_worker->onMessage = function(TcpConnection $http_connection, Request $request)
    {
        // $data数组格式，里面有uid，表示向那个uid的页面推送数据
        $data = $request->get();
        $uid = @$data['to'];
        // 通过workerman，向uid的页面推送数据
        $ret = sendMessageByUid($uid, @$data['content']);
        // 返回推送结果
        return $http_connection->send($ret ? 'ok' : "uid $uid not online");
    };

    $http_worker->listen();
};

// 新增加一个属性，用来保存uid到connection的映射
$worker->uidConnections = [];

// 当有客户端发来消息时执行的回调函数
$worker->onMessage = function($connection, $data)use($worker)
{
    // 判断当前客户端是否已经验证,既是否设置了uid
    if(!isset($connection->uid))
    {
        // 没验证的话把第一个包当做uid（这里为了方便演示，没做真正的验证）
        $connection->uid = $data;
        /* 保存uid到connection的映射，这样可以方便的通过uid查找connection，
         * 实现针对特定uid推送数据
         */
        $worker->uidConnections[$connection->uid] = $connection;
        return;
    }
};

// 当有客户端连接断开时
$worker->onClose = function($connection)use($worker)
{
    global $worker;
    if(isset($connection->uid))
    {
        echo $connection->uid;
        // 连接断开时删除映射
        unset($worker->uidConnections[$connection->uid]);
    }
};

// 向所有验证的用户推送数据
function broadcast($message)
{
    global $worker;
    foreach($worker->uidConnections as $connection)
    {
        $connection->send($message);
    }
}
// 针对uid推送数据
function sendMessageByUid($uid, $message)
{
    global $worker;
    if(isset($worker->uidConnections[$uid]))
    {
        $connection = $worker->uidConnections[$uid];
        $connection->send($message);
        return true;
    }
    return false;
}


// 运行worker
Worker::runAll();
