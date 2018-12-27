<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{$novel_title}}_{{$title}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <script src="main.js"></script> -->
    <style>
        a{
            width:100%;
            height:100%;
            font-weight:450;
            display:inline-block;
        }
        a:link {color: white;text-decoration:blink; text-decoration:none;} 
        a:active:{color: white;text-decoration:none; } 
        a:visited {color:white;text-decoration:none;} 
        a:hover {color: white; text-decoration:underline;text-decoration:none;}
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
        .load-more{
            
        }
        .load-more-btn{
            background-color: #ed424b;
            font-size: .875rem;
            line-height: 2.25rem;
            border-radius: 99px;
            color:white;
            width: 17.5rem;
            border:none;
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
    <div class="load-more">
        <button class="load-more-btn"><a href="/content/next/{{$novel_id}}_{{$id}}">下一章</a></button>
    </div>
</body>
</html>