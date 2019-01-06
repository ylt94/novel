<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>我的书架</title>
    <meta name="viewport" content="width=device-width, initial-scale=1,user-scalable">
    <!-- <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <script src="main.js"></script> -->
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
        img{
            background-size:cover;
            height:100%;
            width:100%;
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
        .header{
            height:10%;
            padding: 0 5% 0 5%;
            display:flex;
            flex-direction:row;
            justify-content:space-between;
            align-items:center;
            border-bottom:1px solid #dcdfe6;
            box-sizing:border-box;
        }

        .main{
            min-height:90%;
            width:90%;
            padding: 0 5% 0 5%;
            display:flex;
            flex-direction:row;
            flex-flow: row wrap;
            align-content:flex-start;
            justify-content:space-between;
        }

        .book-item{
            margin-top:10px;
            width:30%;
            height: 150px;
            min-width:30%;
            text-align: center;
        }

        .book-item:after {
            content: "";
            flex: auto;
        }
        
        .novel-img{
            width:100%;
            height:130px;
        }
        .novel-title{
            height:20px;
            width:100%;
            overflow: hidden;        
            white-space:nowrap;
            text-overflow:ellipsis;
            font-size:12px;
            font-weight:500;
            padding:0 5% 0 5%;
        }
        
    </style>
</head>
<body>
   <div class="header">
        <div><a href="/">首页</a></div>
        <div><a href="/loginout">退出登录</a></div>
   </div>
   <div class="main">
        <div class="book-item">
            <a href="/chapters/1">
                <div class="novel-img">
                    <img src="//bookcover.yuewen.com/qdbimg/349573/1010734492/150" />
                </div>
                <div class="novel-title">凡人修仙传之仙界篇</div>
            </a>
        </div>
   </div>
</body>
</html>