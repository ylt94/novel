<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>websocket</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <script src="main.js"></script> -->
</head>
<body>
    <button onclick="sockets()">发送</button>
</body>
<script>
    function sockets(){
        for(var i = 0; i <1; i++){
            websocket();
        }
    }

    function websocket(){
        var ws = new WebSocket("ws://47.75.0.3:5200/api/usdt");
        ws.onopen = function(evt) {
            console.log("Connection open ...");
            //var send_data = '{"name":"test","send":1}';
            var send_data = [{"name":"test","send":1}];
            console.log(send_data);
            send_data = JSON.stringify(send_data);
            console.log(send_data);
            ws.send(send_data);
        };

        // ws.onclose = function(evt) {
        //     console.log("Connection closed.");
        // }
        ws.onmessage = function(evt) {
            console.log("Received Message: " + evt.data);
            ws.close();
        };
        
        
    }
</script>
</html>