<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8">
    <script src='https://cdn.bootcss.com/jquery/1.11.3/jquery.js'></script>
    <script src="https://cdn.bootcdn.net/ajax/libs/socket.io/4.5.2/socket.io.js"></script>
</head>
<body>

<div class="notification sticky hide">
    uid：<span id="uid"> </span>
    <p> </p>
    收到php发送的消息：<span id="content" style="color: red"> </span>
    <p> </p>
</div>


<script>
    // 链接远程ws服务器
    var ws = new WebSocket('ws://127.0.0.1:3000');

    ws.onopen = function(){
        var uid = 12345;
        $('#uid').html(uid);
        ws.send(uid);
    };

    ws.onmessage = function(e) {
        $('#content').html(e.data);
        console.log("收到服务端的消息：" + e.data);
    };

    ws.onclose = function()
    {
        console.log("连接已关闭...");
    };

</script>
</div>
</body>
</html>
