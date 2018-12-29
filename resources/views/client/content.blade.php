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
            font-size:auto;
        }
        .load-more{
            
        }
        .load-more-btn{
            background-color: #ed424b;
            font-size: .875rem;
            line-height: 2.25rem;
            border-radius: 99px;
            color:white;
            width: 10.5rem;
            border:none;
            margin-left:3.5rem;
        }
        #setting{
            position:fixed;
            height:30%;
            width:90%;
            background-color:#f6f7f9;
            bottom:0px;
            left:0px;
            visibility:hidden;
            padding:0 5% 0 5%;
            border-top:1px solid #e1e5e8;
            opacity:0;
        }
        .chapter{
            height:40%;
            width:100%;
            display:flex;
            flex-direction:row;
            justify-content:space-around;
            align-items:center;
        }
        .font-size{
            height:20%;
            width:100%;
            display:flex;
            flex-direction:row;
            justify-content:space-around;
            align-items:center;
        }
        .background-color{
            height:30%;
            width:100%;
            display:flex;
            flex-direction:row;
            justify-content:space-around;
            align-items:center;
        }
        .chapter-item{
            width:30%;
            height:60%;
            border-radius:3px;
            box-sizing:border-box;
            display:flex;
            align-items:center;
            background-color:auto;
            justify-content:space-between;
            color:black;
            border:none;
            font-size: .875rem;
        }
        .background-color-item{
            display:flex;
            flex-direction:row;
            justify-content:space-around;
            border-radius:99px;
            height:30px;
            width:30px;
        }
        .font-size-item{
            width:45%;
            height:60%;
            border-radius:3px;
            box-sizing:border-box;
            display:flex;
            align-items:center;
            background-color:auto;
            justify-content:center;
            color:black;
            border:none;
            font-size: .875rem;
        }
    </style>
</head>
<body>
    <div class="head">{{$title}}</div>
    <div class="detail">
        <h3>{{$title}}</h3>
        <div class="content" style="font-size:17px;" id="content" onclick="showMenu()">
           <?php echo $content; ?>
        </div>
        <div class="load-more">
        </div>
    </div>
    <div class="load-more">
        <button class="load-more-btn"><a href="/content/next/{{$novel_id}}_{{$id}}">下一章</a></button>
    </div>
    <div id="setting">
        <div class="chapter">
            <button class="chapter-item"><a href="/content/last/{{$novel_id}}_{{$id}}" style="color:black">上一章</a></button>
            <button class="chapter-item"><a href="/chapters/{{ $novel_id }}" style="color:black">目录</a></button>
            <button class="chapter-item"><a href="/content/next/{{$novel_id}}_{{$id}}" style="color:black">下一章</a></button>
        </div>
        <div class="font-size">
            <button class="font-size-item" onclick="changeFontSize(-1)">A-</button>
            <button class="font-size-item" onclick="changeFontSize(+1)">A+</button>
        </div>
        <div class="background-color">
            <div class="background-color-item" style="background-color:#f3efef" onclick="changeBackgroundColor(0)"></div>
            <div class="background-color-item" style="background-color:#d6dbe2" onclick="changeBackgroundColor(1)"></div>
            <div class="background-color-item" style="background-color:#a5c5bf" onclick="changeBackgroundColor(2)"></div>
            <div class="background-color-item" style="background-color:#ccc2a8" onclick="changeBackgroundColor(3)"></div>
            <div class="background-color-item" style="background-color:#656363" onclick="changeBackgroundColor(4)"></div>
        </div>
    </div>
</body>
<script type="text/javascript">
    window.onload=function(){
        var content_font_size = localStorage.getItem('novel_content_font_size');
        var content_color = localStorage.getItem('novel_content_color');
        var background_color = localStorage.getItem('novel_content_background_color');
        var body = document.body;
        var content = document.getElementById('content');
        if(background_color){
            body.style.backgroundColor = background_color;
        }
        
        if(content_color){
            content.style.color = content_color;
        }
        
        if(content_font_size){
            content.style.fontSize = content_font_size + 'px';
        }
        
    };
    function showMenu(){
        var el = document.getElementById('setting');
        el.style.visibility = el.style.visibility == "visible" ? "hidden" : "visible";
        el.style.opacity = el.style.opacity == 1 ? 0 : 1;
    }
    function changeBackgroundColor(key){
        var background_color = [
            "#f3efef",
            "#d6dbe2",
            "#a5c5bf",
            "#ccc2a8",
            "#656363"
        ];
        var body = document.body;
        body.style.backgroundColor = background_color[key];
        var content = document.getElementById('content');
        if(background_color[key] == '#656363'){
            content.style.color = "white";
        }else{
            content.style.color = "black";
        }
        localStorage.setItem('novel_content_background_color',background_color[key]);
        localStorage.setItem('novel_content_color',content.style.color);
    }

    function changeFontSize(num){
        var content = document.getElementById('content');
        var font_size = parseInt(content.style.fontSize.slice(0,-2));
        font_size += num > 0 ? +1 : -1;
        content.style.fontSize = font_size+'px';
        localStorage.setItem('novel_content_font_size',font_size);
    }
</script>
</html>