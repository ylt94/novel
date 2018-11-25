<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>小说网</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="{{asset('css/index.css')}}" />
    <!-- <script src="{{ asset('js/app.js') }}"></script> -->
    <style>
        a{
            width:100%;
            height:100%;
            font-weight:450;
            display:inline-block;
        }
        a:link {color: black;text-decoration:blink; text-decoration:none;} 
        a:active:{color: #ef9789;background-color:white;text-decoration:none; } 
        a:visited {color:grey;text-decoration:none;} 
        a:hover {color: #f57070; text-decoration:underline;background-color:white;text-decoration:none;}
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
        .container{
            height:100%;
            width:100%;
            display:flex;
            flex-direction:row;
        }
        .left{
            width:18%;
            padding-top:10%;
            box-sizing:border-box;
            background-color:#f9fafb;
            border-right:1px solid #e1e5e8; 
        }
        .novel_category{
            width:100%;
            padding:0;
            max-height:100%;
            -webkit-overflow-scrolling: touch;
            overflow-x: hidden;
            overflow-y: scroll;
        }
        .novel_category_item{
            width:100%;
            height:40px;
            line-height:40px; 
            list-style-type:none;
            margin: 0 auto;
            text-align:center;
        }
        .right{
            height:100%;
            width:82%;
            box-sizing:border-box;
            background-color:white;
            display:flex;
            flex-direction:column;
            -webkit-overflow-scrolling: touch;
            overflow-x: hidden;
            overflow-y: scroll;
        }
        .right-head{
            height:12%;
            width:100%;
            box-sizing:border-box;
            border-bottom:1px solid #e1e5e8;
            min-height:80px;
            display:flex;
            flex-direction:column;
            
        }
        .search-params{
            height:50%;
            width:100%;
            display:flex;
            flex-direction:row;
            justify-content:space-around;
            align-items:center;
        }
        .novel{
            height:88%;
            width:100%;
            padding-left:5%;
        }
        .novel-item{
            height:22%;
            width:95%;
            box-sizing:border-box;
            border-bottom:1px solid #e1e5e8;
            min-height:22%;
            padding: 5% 5% 5% 0;
            
        }
        .novel-item-a{
            height:100%;
            display:flex;
            flex-direction:row;
        }
        .novel-image{
            height:100%;
            width:20%;
            max-width:60px;
            border:1px solid grey;
            box-sizing:border-box;
        }
        .novel-info{
            padding-left:5%;
            width:70%;
            height:100%;
            display:flex;
            flex-direction:column;
            justify-content:center;
        }
        .novel-title{
            height:40%;
            width:100%;
            font-weight:500;
            color:black;
            line-height:200%;
            overflow: hidden;        
            white-space:nowrap;
            text-overflow:ellipsis;
        }
        .novel-desc{
            height:30px;
            width:100%;
            color:#929191;
            display:flex;
            font-size:10px;
            justify-content:flex-start;
            text-overflow: ellipsis;
            display:-webkit-box;
            -webkit-box-orient:vertical;
            -webkit-line-clamp:2;
            overflow: hidden;
        }
        .novel-auther{
            height:30%;
            width:100%;
            color:#9c9b9b;
            display:flex;
            font-size:13px;
            align-items:center;
            justify-content:flex-start;
            overflow:hidden;
        }
        .search-login{
            height:50%;
            width:100%;
            display:flex;
            flex-direction:row;
        }
        .search{
            height:100%;
            width:80%;
            display:flex;
            flex-direction:row;
            justify-content:center;
            align-items:flex-end;
        }
        .search-border{
            height:80%;
            width:90%;
            box-sizing:border-box;
            border:1px solid #e1e5e8;
            color:#e1e5e8;
            font-size:14px;
            text-align:center;
            line-height:200%;
            border-radius:20px;
        }
        .login{
            height:100%;
            width:20%;
            line-height:300%;
            text-align:center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="left">
            <ul class="novel_category">
                <li class="novel_category_item"><a id="novel_type_0" href="javascript:getNewByNovelType(0)">全部</a></li>
                @foreach($types as $type)
                <li class="novel_category_item"><a id="{{'novel_type_'.$type->id}}" href="javascript:getNewByNovelType({{$type->id}})">{{$type->name}}</a></li>
                @endforeach
            </ul>
            
        </div>
        <div class="right">
            <div class="right-head">
                <div class="search-login">
                    <div class="search">
                        <div class="search-border">
                         请输入小说名   
                        </div>
                    </div>
                    <div class="login">
                        <a href="#">登录</a>
                    </div>
                </div>
                <div class="search-params">
                    <div class="search-param"><a id='recommend' href="javascript:getNewByOrderType('recommend')">推荐</a></div>
                    <div class="search-param"><a id='collection_num' href="javascript:getNewByOrderType('collection_num')">收藏</a></div>
                    <div class="search-param"><a id='newset' href="javascript:getNewByOrderType('newset')">更新</a></div>
                </div>
            </div>
            <div class="novel">
                @foreach($novels as $novel)
                <div class="novel-item">
                    <a class="novel-item-a" href="/novel/{{$novel->id}}">
                        <div class="novel-image">
                            <img src="{{$novel->img_url}}" />
                        </div>
                        <div class="novel-info">
                            <div class="novel-title">{{$novel->title}}</div>
                            <div class="novel-desc">{{$novel->desc}}</div>
                            <div class="novel-auther">---{{$novel->author}}</div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>

        </div>
    </div>
    <script type="text/javascript">
        window.onload = function(){
            var novel_type = 0;
            var order_type = 'recommend';
            var _novel_type = GetUrlParam('novel_type')
            if(_novel_type){
                novel_type = _novel_type;
            }
            var _order_type = GetUrlParam('order_type')
            if(_order_type){
                order_type = _order_type;
            }
            
            var dom_novel_type = document.getElementById('novel_type_'+novel_type);
            dom_novel_type.style.color = '#f57070';
            var dom_order_type = document.getElementById(order_type);
            dom_order_type.style.color = '#f57070';
        }
        function getNewByNovelType(novel_type){
            var domain = document.location.protocol+ '//'+ document.location.host;
            var order_type = GetUrlParam('order_type') ? GetUrlParam('order_type') : 'recommend'
            window.location.href = domain +'?novel_type='+novel_type+'&order_type='+order_type;
        }
        function getNewByOrderType(order_type){
            var domain = 'http://'+ document.location.host;
            var novel_type = GetUrlParam('novel_type') ? GetUrlParam('novel_type') : '0'
            window.location.href = domain +'?novel_type='+novel_type+'&order_type='+order_type;
        }

        function GetUrlPara(){
    　　　　var url = document.location.toString();
    　　　　var arrUrl = url.split("?");

    　　　　var para = arrUrl[1];
    　　　　return para;
    　　}

        //获取指定参数的值
        function GetUrlParam(paraName) {
    　　　　var url = document.location.toString();
    　　　　var arrObj = url.split("?");

    　　　　if (arrObj.length > 1) {
    　　　　　　var arrPara = arrObj[1].split("&");
    　　　　　　var arr;

    　　　　　　for (var i = 0; i < arrPara.length; i++) {
    　　　　　　　　arr = arrPara[i].split("=");

    　　　　　　　　if (arr != null && arr[0] == paraName) {
    　　　　　　　　　　return arr[1];
    　　　　　　　　}
    　　　　　　}
    　　　　　　return false;
    　　　　}
    　　　　else {
    　　　　　　return false;
    　　　　}
　　    }
    </script>
</body>
</html>