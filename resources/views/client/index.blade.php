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
    <!-- <style>
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
            width:100;
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
        .novel{
            height:88%;
            width:100%;
            padding-left:5%;
        }
        .novel-item{
            height:22%;
            box-sizing:border-box;
            border-bottom:1px solid #e1e5e8;
            min-height:22%;
            padding: 5% 5% 5% 0;
            display:flex;
            flex-direction:row;
            
        }
        .novel-image{
            height:100%;
            width:20%;
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
    </style> -->
</head>
<body>
    <div class="container">
        <div class="left">
            <ul class="novel_category">
                <li class="novel_category_item"><a href="#">全部</a></li>
                <li class="novel_category_item"><a href="#">玄幻</a></li>
                <li class="novel_category_item"><a href="#">仙侠</a></li>
                <li class="novel_category_item"><a href="#">都市</a></li>
                <li class="novel_category_item"><a href="#">科幻</a></li>
                <li class="novel_category_item"><a href="#">武侠</a></li>
                <li class="novel_category_item"><a href="#">军事</a></li>
                <li class="novel_category_item"><a href="#">体育</a></li>
                <li class="novel_category_item"><a href="#">游戏</a></li>
                <li class="novel_category_item"><a href="#">灵异</a></li>
                <li class="novel_category_item"><a href="#">历史</a></li>
                <li class="novel_category_item"><a href="#">奇幻</a></li>
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
            </div>
            <div class="novel">
                <div class="novel-item">
                    <div class="novel-image">
                        <img src="//bookcover.yuewen.com/qdbimg/349573/1010734492/150" />
                    </div>
                    <div class="novel-info">
                        <div class="novel-title">凡人修仙传之仙界篇</div>
                        <div class="novel-desc">凡人修仙，风云再起时空穿梭，轮回逆转金仙太乙，大罗道祖三千大道，法则至尊《凡人修仙传》仙界篇，一个韩立叱咤仙界的故事，一个凡人小子修仙的不灭传说。特说明下，没有看过前传的书友，并不影响本书的阅读体验，</div>
                        <div class="novel-auther">---忘语</div>
                    </div>
                </div>
                <div class="novel-item">
                    <div class="novel-image">
                        <img src="//bookcover.yuewen.com/qdbimg/349573/1004608738/150" />
                    </div>
                    <div class="novel-info">
                        <div class="novel-title">圣墟</div>
                        <div class="novel-desc">在破败中崛起，在寂灭中复苏。沧海成尘，雷电枯竭，那一缕幽雾又一次临近大地，世间的枷锁被打开了，一个全新的世界就此揭开神秘的一角……</div>
                        <div class="novel-auther">---辰东</div>
                    </div>
                </div>
                <div class="novel-item">
                    <div class="novel-image">
                        <img src="//bookcover.yuewen.com/qdbimg/349573/1010468795/150" />
                    </div>
                    <div class="novel-info">
                        <div class="novel-title">飞剑问道</div>
                        <div class="novel-desc">在这个世界，有狐仙、河神、水怪、大妖，也有求长生的修行者。修行者们，开法眼，可看妖魔鬼怪。炼一口飞剑，可千里杀敌。千里眼、顺风耳，更可探查四方。……秦府二公子‘秦云’，便是一位修行者……</div>
                        <div class="novel-auther">---我吃西红柿</div>
                    </div>
                </div>
                <div class="novel-item">
                    <div class="novel-image">
                        <img src="//bookcover.yuewen.com/qdbimg/349573/1010399782/150" />
                    </div>
                    <div class="novel-info">
                        <div class="novel-title">太初</div>
                        <div class="novel-desc">一树生的万朵花，天下道门是一家。法术千般变化，人心却亘古不变</div>
                        <div class="novel-auther">---高楼大厦</div>
                    </div>
                </div>
                <div class="novel-item">
                    <div class="novel-image">
                        <img src="//bookcover.yuewen.com/qdbimg/349573/1010734492/150" />
                    </div>
                    <div class="novel-info">
                        <div class="novel-title">凡人修仙传之仙界篇</div>
                        <div class="novel-desc">凡人修仙，风云再起时空穿梭，轮回逆转金仙太乙，大罗道祖三千大道，法则至尊《凡人修仙传》仙界篇，一个韩立叱咤仙界的故事，一个凡人小子修仙的不灭传说。特说明下，没有看过前传的书友，并不影响本书的阅读体验，</div>
                        <div class="novel-auther">---忘语</div>
                    </div>
                </div>
                <div class="novel-item">
                    <div class="novel-image">
                        <img src="//bookcover.yuewen.com/qdbimg/349573/1010734492/150" />
                    </div>
                    <div class="novel-info">
                        <div class="novel-title">凡人修仙传之仙界篇</div>
                        <div class="novel-desc">凡人修仙，风云再起时空穿梭，轮回逆转金仙太乙，大罗道祖三千大道，法则至尊《凡人修仙传》仙界篇，一个韩立叱咤仙界的故事，一个凡人小子修仙的不灭传说。特说明下，没有看过前传的书友，并不影响本书的阅读体验，</div>
                        <div class="novel-auther">---忘语</div>
                    </div>
                </div>
                <div class="novel-item">
                    <div class="novel-image">
                        <img src="//bookcover.yuewen.com/qdbimg/349573/1010734492/150" />
                    </div>
                    <div class="novel-info">
                        <div class="novel-title">凡人修仙传之仙界篇</div>
                        <div class="novel-desc">凡人修仙，风云再起时空穿梭，轮回逆转金仙太乙，大罗道祖三千大道，法则至尊《凡人修仙传》仙界篇，一个韩立叱咤仙界的故事，一个凡人小子修仙的不灭传说。特说明下，没有看过前传的书友，并不影响本书的阅读体验，</div>
                        <div class="novel-auther">---忘语</div>
                    </div>
                </div>
                <div class="novel-item">
                    <div class="novel-image">
                        <img src="//bookcover.yuewen.com/qdbimg/349573/1010734492/150" />
                    </div>
                    <div class="novel-info">
                        <div class="novel-title">凡人修仙传之仙界篇</div>
                        <div class="novel-desc">凡人修仙，风云再起时空穿梭，轮回逆转金仙太乙，大罗道祖三千大道，法则至尊《凡人修仙传》仙界篇，一个韩立叱咤仙界的故事，一个凡人小子修仙的不灭传说。特说明下，没有看过前传的书友，并不影响本书的阅读体验，</div>
                        <div class="novel-auther">---忘语</div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</body>
</html>