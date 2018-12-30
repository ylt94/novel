<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>发生错误了</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        a:link {color: black;text-decoration:none;background-color:none;} 
        a:active:{color: black;text-decoration:none;background-color:none; } 
        a:visited {color: black;text-decoration:none;background-color:none;} 
        a:hover {text-decoration:none;background-color:none;}
        a{-webkit-tap-highlight-color: rgba(255, 255, 255, 0);
        -webkit-user-select: none;
        -moz-user-focus: none;
        -moz-user-select: none;}
        ::-webkit-scrollbar{
            display:none;
            width:0px;
            height:0px;
        }
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Raleway', sans-serif;
            font-weight: 100;
            height:100%;
            width:100%;
            margin: 0;
        }
        .main{
            height:30%;
            width:90%;
            position:fixed;
            left:5%;
            top:30%;
            background-color:white;
            border:2px dashed grey;
            box-sizing:border-box;
        }
        .title{
            height:40%;
            width:100%;
            font-size:20px;
            color:#0188de;
            text-align:center;
            line-height:300%;
            font-weight:800;
        }
        .content{
            height:30%;
            width:100%;
            font-size:15px;
            color:red;
            text-align:center;
            line-height:300%;
            font-weight:800;
        }
        .btn{
            height:30%;
            width:100%;
            font-size:15px;
            text-align:center;
        }
        .return-last-page{
            background-color: #ed424b;
            font-size: .875rem;
            line-height: 2.25rem;
            border-radius: 3px;
            color:white;
            width: 10.5rem;
            border:none;
            
        }
    </style>
</head>
<body>
    <main class="main">
        <div class="title">出错了~</div>
        <div class="content">{{$msg}}！</div>
        <div class="btn">
            <button class="return-last-page" onclick="JavaScript:history.back(-1);">返回上一页</button>
        </div>
    </main>
</body>
<script type="text/javascript">
</script>
</html>