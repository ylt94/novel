<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{$title}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
        a{
            width:100%;
            height:100%;
            font-weight:450;
            display:inline-block;
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
        .head{
            height:60px;
            width:100%;
            box-sizing:border-box;
            border-bottom:1px solid #ed424b;
            color:#ed424b;
            text-align:center;
            line-height:60px;
        }
        .chapter{
            width:100%;
        }
        .total{
            width:90%;
            height:40px;
            display:flex;
            flex-direction:row;
            align-items:center;
            justify-content:space-between;
            font-size: .875rem;
            white-space: nowrap;
            color:black;
            padding:0 5% 0 5%;
        }
        .chapters-title{
            height:28px;
            width:95%;
            font-size: 13px;
            line-height: 28px;
            padding-left: 5%;
            color: #969ba3;
            background-color: #f6f7f9;
        }
        .chapters{
            width:95%;
            padding-left:5%;
        }
        .chapter-item{
            width:95%;
            padding-left:5%;
            height:44px;
            line-height:44px;
            font-size:14px;
            font-weight:500;
            border-top: 1px solid #f0f1f2;
        }
    </style>
</head>
<body>
    <div class="head">目录</div>
    <div class="chapter">
        <div class="total">
            <div class="total-chapters" style="font-weight: 700;">共534章</div>
            <div style="display:block" id="chapters_orders_asc" class="chapters-order" onclick="chaptersOrder(1)">正序</div>
            <div style="display:none" id="chapters_orders_desc" class="chapters-order" onclick="chaptersOrder(2)">逆序</div>
        </div>
        <div class="chapters-title">章节</div>
        <div class="chapters">
            @foreach($chapters as $chapter)
            <div class="chapter-item">
                <a href="/content/{{$chapter['id']}}"><span stype="color:black;font-weight:500;">{{$chapter['title']}}</span></a>
            </div>
            @endforeach
            
        </div>
    </div>
    <script type="text/javascript">
        function chaptersOrder(order_by){
            var asc = document.getElementById('chapters_orders_asc');
            var desc = document.getElementById('chapters_orders_desc');
            if(order_by==1){
                asc.style.display = "none";
                desc.style.display = "block";
            }else if(order_by==2){
               
                asc.style.display = "block";
                desc.style.display = "none";
            }else{
                return false;
            }
            var items = document.getElementsByClassName('chapter-item');
            for(var i=items.length-1;i>-1;i--){
				document.querySelector(".chapters").appendChild(items[i]);
			}
            

        }
    </script>
</body>
</html>