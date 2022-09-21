<?php
# @Author : zhoulei1
# @Time   : 2022-09-20
# @File   : Server.php
require_once  dirname(__DIR__ ) . '/vendor/autoload.php';

use Workerman\Worker;
use PHPSocketIO\SocketIO;
use Workerman\Protocols\Http\Request;
use Workerman\Connection\TcpConnection;

// 全局数组保存uid在线数据
$uidConnectionMap = [];

// PHPSocketIO服务
$server_io = new SocketIO(3120);

// 客户端发起连接事件时，设置连接socket的各种事件回调
$server_io->on('connection', function($socket){
    // 客户端发来登录事件时触发
    $socket->on('login', function ($uid)use($socket){
        global $uidConnectionMap;
        // 已经登录过了
        if(isset($socket->uid)){
            return;
        }
        $uid = (string)$uid;
        if(!isset($uidConnectionMap[$uid])) {
            $uidConnectionMap[$uid] = 0;
        }
        // 这个uid有++$uidConnectionMap[$uid]个socket连接
        ++$uidConnectionMap[$uid];
        // 将这个连接加入到uid分组，方便针对uid推送数据
        $socket->join($uid);
        $socket->uid = $uid;
    });

    // 当客户端断开连接是触发（一般是关闭网页或者跳转刷新导致）
    $socket->on('disconnect', function () use($socket) {
        if(!isset($socket->uid)) {
            return;
        }
        global $uidConnectionMap;
        // 将uid的在线socket数减一
        if(--$uidConnectionMap[$socket->uid] <= 0) {
            unset($uidConnectionMap[$socket->uid]);
        }
    });
});


// 监听一个http端口，通过http协议访问这个端口可以向所有客户端推送数据
$server_io->on('workerStart', function(){
    // 监听http端口
    $http_worker = new Worker('http://0.0.0.0:2121');
    // 当http客户端发来数据时触发
    $http_worker->onMessage = function(TcpConnection $http_connection, Request $request){

        global $server_io, $uidConnectionMap;

        // 这里需要判断发送消息url的签名，此处为了测试省略
        $info = $request->get();
        switch (@$info['type'])
        {
            case 'publish':
                $to = @$info['to'];
                $info['content'] = htmlspecialchars(@$info['content']);

                // 有指定uid则向uid所在socket组发送数据，没有就发给全部用户
                if($to){
                    $server_io->to($to)->emit('php_msg', $info['content']);
                }else{
                    $server_io->emit('php_msg', @$info['content']);
                }

                // http接口返回，如果用户离线socket返回fail
                if($to && !isset($uidConnectionMap[$to])){
                    return $http_connection->send(json_encode(['code' => 1001, 'msg' => '该用户离线']));
                }else{
                    return $http_connection->send(json_encode(['code' => 0, 'msg' => 'success']));
                }
            default:
                break;
        }

        return $http_connection->send(json_encode(['code' => 0, 'msg' => 'fail']));
    };

    $http_worker->listen();
});


Worker::runAll();
