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
    <button onclick="websocket()">发送</button>
</body>
<script>
    function sockets(){
        for(var i = 0; i <1; i++){
            websocket();
        }
    }

    function websocket(){
        var ws = new WebSocket("ws://new.mitop.api.qidianjinfu.com:8001");
        ws.onopen = function(evt) {
            //ws.send('ping');
            console.log("Connection open ..."); 
            var send_data = {"market":"btc/usdt"};
            send_data = JSON.stringify(send_data);
            console.log("send data: " + send_data);
            ws.send(send_data);
        };
        // var t2 = window.setInterval(function() {

        //     var send_data = {"route":"api/market/index","data":""};
        //     send_data = JSON.stringify(send_data);
        //     console.log("send data: " + send_data);
        //     ws.send(send_data);

        // },2000)
        
        ws.onmessage = function(evt) {
            // if(evt.data != 'pong'){
            //     ws.send('ping');
            // }
            console.log("Received Message: " + evt.data);
        };
        
        
    }
</script>
</html>