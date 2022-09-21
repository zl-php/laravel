<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8">
    <script src='https://cdn.bootcss.com/jquery/1.11.3/jquery.js'></script>
    <script src="https://cdn.bootcdn.net/ajax/libs/socket.io/2.0.3/socket.io.js"></script>
</head>
<body>

<div class="notification sticky hide">
    uid：<span id="uid"> </span>
    <p> </p>
    收到php发送的消息：<span id="content" style="color: red"> </span>
    <p> </p>
</div>

<div>
    可以通过url：<a href="http://127.0.0.1:2121?type=publish&to=uid&content=content" target="_blank" ><font style="color:#91BD09">http://127.0.0.1:2121type=publish&to=uid&content=content</font></a> 向所有在线用户推送消息<br>
</div>

<script>
    var uid = Date.parse(new Date());
    $('#uid').html(uid);

    // 如果服务端不在本机，请把127.0.0.1改成服务端ip
    var socket = io('http://127.0.0.1:3120');
    // 当连接服务端成功时触发connect默认事件
    socket.on("connect", () => {
        console.log(`socket connect ok`)
        socket.emit('login', uid);
    });

    // 定义php_msg 事件回调函数
    socket.on('php_msg', function(msg){
        $('#content').html(msg);
    });

</script>
</div>
</body>
</html>
