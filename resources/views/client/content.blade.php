<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <script src="main.js"></script> -->
    <style>
        html, body {
            padding:0 5% 0 5%;
            width:90%;
            background-color: #fff;
            color: black;
            font-family: 'Raleway', sans-serif;
            font-weight: 100;
            height:100%;
            margin: 0;
        }
        .head{
            position: fixed;
            top: 0;
            right: 0;
            left: 0;
            height: 44px;
            line-height:44px;
            padding:0 5% 0 5%;
            width:90%;
            background-color:#f6f7f9;
            font-size: .75rem;
            font-weight: 400;
            overflow: hidden;        
            white-space:nowrap;
            text-overflow:ellipsis;
        }
        .detail{
            margin-top:44px;
            font-size: 1.125rem;
            line-height: 1.8;
            text-align: justify;
            width:100%;
        }
        .content{
            overflow: hidden;
            width:100%;
        }
    </style>
</head>
<body>
    <div class="head">{{$title}}</div>
    <div class="detail">
        <h3>{{$title}}</h3>
        <div class="content">
           <?php echo $content; ?>
        </div>
        <div class="load-more">
        </div>
    </div>
</body>
</html>