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
                        <a href="/login">登录</a>
                    </div>
                </div>
                <div class="search-params">
                    <div class="search-param"><a id='recommend' href="javascript:getNewByOrderType('recommend')">推荐</a></div>
                    <div class="search-param"><a id='collection' href="javascript:getNewByOrderType('collection')">收藏</a></div>
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