<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{$novel_base['title']}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1;user-scalable=no">
    <!-- <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <script src="main.js"></script> -->
    <style>
        a:link {text-decoration:none;background-color:none;} 
        a:active:{text-decoration:none;background-color:none; } 
        a:visited {text-decoration:none;background-color:none;} 
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
            color: black;
            font-family: 'Raleway', sans-serif;
            font-weight: 100;
            height:98%;
            width:98%;
            margin: 0;
            padding: 1% 0 1% 2%;
        }
        img{
            background-size:cover;
            height:100%;
            width:100%;
        }
        
        .header{
            height:40%;
            width:100%;
            display:flex;
            flex-direction:column;
            box-sizing:border-box;
            border-bottom:1px solid #e1e5e8;
            /* background: url("//bookcover.yuewen.com/qdbimg/349573/1010734492/150") no-repeat fixed;
            background-size:cover;
            -moz-filter: blur(10px);
            -ms-filter: blur(10px);    
            filter: blur(10px); */
        }
        .book-info{
            height:70%;
            width:100%;
            display:flex;
            flex-direction:row;
        }
        .novel-image{
            height:100%;
            width:30%;
            border:1px solid grey;
            box-sizing:border-box;
        }
        .book-detail{
            height:100%;
            width:68%;
            padding-left:2%;
            display:flex;
            flex-direction:column;
        }
        .novel-title{
            height:25%;
            width:100%;
            font-weight:600;
            color:black;
            line-height:200%;
            overflow: hidden;        
            white-space:nowrap;
            text-overflow:ellipsis;
        }
        .novel-auther{
            height:20%;
            width:100%;
            font-size:14px;
            font-weight:400;
            color:black;
            line-height:200%;
            overflow: hidden;        
            white-space:nowrap;
            text-overflow:ellipsis;
        }
        .novel-type{
            height:20%;
            width:100%;
            font-size:14px;
            color:black;
            line-height:200%;
            overflow: hidden;        
            white-space:nowrap;
            text-overflow:ellipsis;
        }
        .novel-other{
            height:20%;
            width:100%;
            font-size:14px;
            color:black;
            line-height:200%;
            overflow: hidden;        
            white-space:nowrap;
            text-overflow:ellipsis;
        }
        .book-action{
            height:30%;
            width:100%;
            display:flex;
            flex-direction:row;
            align-items:center;
            justify-content:space-around;
        }
        .action-item{
            height:50%;
            width:29%;
            box-sizing:border-box;
            border:1px solid #e1e5e8;
            border-radius:5px;
            display:flex;
            align-items:center;
            justify-content:center;
        }
        .book-desc{
            width:98%;
            font-size: .875rem;
            text-align: justify;
            padding: 5% 2% 5% 0;
            box-sizing:border-box;
            border-bottom:1px solid #e1e5e8;
        }
        .chapters{
            height:40px;
            padding-left: 2%;
            width:98%;
            box-sizing:border-box;
            border-bottom:1px solid #e1e5e8;
            display:flex;
            flex-direction:row;
            align-items:center;
            
        }
        .chapters-newset{
            font-size:13px;
            width:70%;
            height:40px;
            line-height:40px;
            overflow: hidden;        
            white-space:nowrap;
            text-overflow:ellipsis;
        }
        .author-others{
            margin-top:20px;
            width:100%;
            display:flex;
            flex-direction:column;
        }
        .other-title{
            border-bottom:1px solid #e1e5e8;
            width:100px;
        }
        .other-novels{
            margin-top:10px;
            height:160px;
            width:100%;
            box-sizing:border-box;
            display:flex;
            flex-direction:row;
            align-items:center;
            justify-content:flex-start;
            -webkit-overflow-scrolling: touch;
            overflow-x: scroll;
            overflow-y: hidden;
            border-bottom:1px solid  #e1e5e8;  
        }
        .other-novel-item{
            margin-right:20px;
            box-sizing:border-box;
            height:140px;
            width:90px;
            min-width:90px;
            border:1px solid #e1e5e8;
            display:flex;
            flex-direction:column;
        }
        .other-novel-image{
            height:110px;
            width:100%;
        }
        .other-novel-title{
            height:30px;
            width:100%;
            overflow: hidden;        
            white-space:nowrap;
            text-overflow:ellipsis;
            font-size:12px;
            color:black;
            line-height:30px;
            font-weight:550;
        }
        .other-same{
            margin-top:20px;
            width:100%;
            display:flex;
            flex-direction:column;
            margin-bottom:10px;
        }
        .same-title{
            border-bottom:1px solid #e1e5e8;
            width:65px;
        }
    </style>

</head>
<body>
    <div class="header">
        <div class="book-info">
            <div class="novel-image">
                <img src="{{$novel_base['img_url']}}" />
            </div>
            <div class="book-detail">
                <div class="novel-title">{{$novel_base['title']}}</div>
                <div class="novel-auther">作者：{{$novel_base['author']}}</div>
                <div class="novel-type">类型：{{$novel_base['novel_type']}}</div>
                <div class="novel-other">状态：{{$novel_base['status'] == 1 ? '连载' : '完本'}}
                {{ $novel_base['words'] ? '| '.$novel_base['words'].'万字' : '' }}</div>
                <div class="novel-other">最后更新：{{ $last_chapter? $last_chapter['create_at'] :''}}</div>
            </div>
        </div>
        <div class="book-action">
            <div class="action-item" style="color:white;background-color:#f7483e;"><a style="color:white;" href="/chapters/{{ $novel_base['id'] }}">开始阅读</a></div>
            <div class="action-item" style="color:black;background-color:white;"><a style="color:black;" href="#">加入书架</a></div>
            <div class="action-item"style="color:black;background-color:white;"><a style="color:black;" href="#">我的书架</a></div>
        </div>
    </div>
    <div class="book-desc">
        {{$novel_base['desc']}}
    </div>
    <div class="chapters">
        <div style="font-weight:600;width:30%;">目录</div>
        <div class="chapters-newset"><a href="/content/{{ $last_chapter ? $last_chapter['id'] : '' }}" style="color:grey;">已更新至： {{$last_chapter ? $last_chapter['title'] : ''}}</a></div>
    </div>
    <div class="author-others">
        <div class="other-title">作者相关作品</div>
        <div class="other-novels">
            <div class="other-novel-item">
                <a href="#">
                    <div class="other-novel-image">
                        <img src="//bookcover.yuewen.com/qdbimg/349573/1010734492/150" />
                    </div>
                    <div class="other-novel-title">凡人修仙传之仙界篇</div>
                </a>
            </div>
            <div class="other-novel-item">
                <a href="#">
                    <div class="other-novel-image">
                        <img src="//bookcover.yuewen.com/qdbimg/349573/1010734492/150" />
                    </div>
                    <div class="other-novel-title">凡人修仙传之仙界篇</div>
                </a>
            </div>
            <div class="other-novel-item">
                <a href="#">
                    <div class="other-novel-image">
                        <img src="//bookcover.yuewen.com/qdbimg/349573/1010734492/150" />
                    </div>
                    <div class="other-novel-title">凡人修仙传之仙界篇</div>
                </a>
            </div>
            <div class="other-novel-item">
                <a href="#">
                    <div class="other-novel-image">
                        <img src="//bookcover.yuewen.com/qdbimg/349573/1010734492/150" />
                    </div>
                    <div class="other-novel-title">凡人修仙传之仙界篇</div>
                </a>
            </div>
            <div class="other-novel-item">
                <a href="#">
                    <div class="other-novel-image">
                        <img src="//bookcover.yuewen.com/qdbimg/349573/1010734492/150" />
                    </div>
                    <div class="other-novel-title">凡人修仙传之仙界篇</div>
                </a>
            </div>
        </div>
    </div>
    <div class="other-same">
        <div class="same-title">同类推荐</div>
        <div class="other-novels">
        <div class="other-novel-item">
                <a href="#">
                    <div class="other-novel-image">
                        <img src="//bookcover.yuewen.com/qdbimg/349573/1010734492/150" />
                    </div>
                    <div class="other-novel-title">凡人修仙传之仙界篇</div>
                </a>
            </div>
            <div class="other-novel-item">
                <a href="#">
                    <div class="other-novel-image">
                        <img src="//bookcover.yuewen.com/qdbimg/349573/1010734492/150" />
                    </div>
                    <div class="other-novel-title">凡人修仙传之仙界篇</div>
                </a>
            </div>
            <div class="other-novel-item">
                <a href="#">
                    <div class="other-novel-image">
                        <img src="//bookcover.yuewen.com/qdbimg/349573/1010734492/150" />
                    </div>
                    <div class="other-novel-title">凡人修仙传之仙界篇</div>
                </a>
            </div>
            <div class="other-novel-item">
                <a href="#">
                    <div class="other-novel-image">
                        <img src="//bookcover.yuewen.com/qdbimg/349573/1010734492/150" />
                    </div>
                    <div class="other-novel-title">凡人修仙传之仙界篇</div>
                </a>
            </div>
            <div class="other-novel-item">
                <a href="#">
                    <div class="other-novel-image">
                        <img src="//bookcover.yuewen.com/qdbimg/349573/1010734492/150" />
                    </div>
                    <div class="other-novel-title">凡人修仙传之仙界篇</div>
                </a>
            </div>
        </div>
    </div>
</body>
</html>