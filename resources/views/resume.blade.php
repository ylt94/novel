<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>我的简历</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <script src="main.js"></script> -->
    <style>
        ::-webkit-scrollbar-track {
            border-radius: 10px;
            -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0);
            background-color: #e8e8e8;
        }
        ::-webkit-scrollbar-thumb {
            background-color: rgb(18, 208, 161);
            border-radius: 10px;
            cursor: pointer;
        }
        html {
            background-color: #fff;
            color: #636b6f;
            font-family: "microsoft yahei";
            font-weight: 100;
            min-height: 100%;
            margin: 0;
            background-color:#00c091;
            display:flex;
            justify-content:center;
            -webkit-overflow-scrolling: touch;
            overflow-x: hidden;
            overflow-y: scroll;
            min-width: 280px;
        }
        
        body{
            margin-top:30px;
            background-color:white;
            margin-bottom:30px;
            width: 100%;
            max-width: 820px;
            min-height: 100%;
            /* border:3px solid #e5e5e5;
            box-shadow: 0 0 8px 0 rgba(0,0,0,0.2); */
        }
        .head{
            margin-top:30px;
            background: #69cc41;
            padding:50px;
            height:200px;
            display:flex;
            flex-direction:row;
            justify-content:space-between;
        }
        .image{
            width:150px;
            box-sizing:border-box;
            border: 4px solid #e5e5e5;
            height:200px;
            background-color:white;
        }
        .base-info{
            display:flex;
            flex:1;
            height:200px;
            background-color:auto;
            color:white;
            flex-direction:column;
        }
        .name{
            color:auto;
            font-size:30px;
            font-weight:800;
            margin-left:30px;
        }
        .motto{
            padding-left:40px;
            font-size:15px;
            margin-bottom:10px;
            text-align:right;       
        }
        .desc{
            text-align:right;
            line-height:40px;
            font-size:17px;
            height:60%;
            width:100%;
        }
        .master{
            margin-top:15px;
            background-color:#f4f4f4;
            padding: 0 5% 0 5%;
        }
        .master-item{
            width:100%;
            height:150px;
            padding:10px 0 10px 0px;
            display:flex;
            flex-direction:column;
        }
        .master-item-title{
            color:black;
            height:50%;
            width:100%;
            display:flex;
            align-items:center;
            font-weight:800;
            font-size:18px;
            flex-direction:row;
            text-align:right;
        }
        .master-item-content{
            color:black;
            height:50%;
            width:100%;
            display:flex;
            align-items:center;
            font-size:14px;
            flex-direction:row;
        }
        .master-item-content-item{
            display:flex;
            flex:1;
            height:100%;
            min-width:25%;
            justify-content:center;
        }
        .work-content{
            width:100%;
        }
        .work-title{
            height:45px;
            color:black;
            width:100%;
            line-height:45px;
            font-weight:800;
            font-size:18px;
        }
        .work-item{
            margin-bottom:30px;
        }
        .work-item-title{
            color:black;
            height:60px;
            max-height:60px;
            /* overflow:hidden; */
            width:100%;
            display:flex;
            font-size:15px;
            align-items:center;
            flex-direction:row;
        }
        .work-title-item{
            display:flex;
            flex:1;
            min-width:25%;
            justify-content:center;
            line-height:2;
        }
        .work-item-content{
            color:black;
            font-weight:400;
            font-size:15px;
            line-height:2;
            text-indent:35px;
        }
        .skill{
            display:flex;
            flex-direction:column;
        }
        .skill-title{
            height:45px;
            color:black;
            width:100%;
            line-height:45px;
            font-weight:800;
            font-size:18px;
        }
        .skill-content{
            width:95%;
            text-indent: 35px;
            margin-left:5%;
            line-height: 2;
            display:flex;
            flex-direction:column;
        }
        .skill-item{
            display:flex;
            flex-direction:column;
            min-height:30px;
            flex:1;
            align-items:flex-start;
            justify-content:center;
            margin-bottom:10px;
        }

        .remark{
            margin-top:30px;
            font-size:13px;
            margin-bottom:30px;
            line-height:2;
        }
        
    </style>
</head>
<body>
    <div class="head">
        <!-- <div class="image"></div> -->
        <div class="base-info">
            <div class="name">袁粒桃</div>
            <div class="desc">
                25岁
                <span style="font-weight:600"> | </span>
                2.5年经验
                <span style="font-weight:600"> | </span>
                173****2748
                <span style="font-weight:600"> | </span>
                857425891@qq.com
            </div>
            <div class="motto"><i style="">-----生于忧患，死于安乐</i></div>
        </div>
    </div>
    <div class="master">
        <div class="master-item">
            <div class="master-item-title">求职意向</div>
            <div class="master-item-content">
                <div class="master-item-content-item">意向岗位：PHP工程师</div>
                <div class="master-item-content-item">意向城市：重庆</div>
                <div class="master-item-content-item">薪资要求：7K-10K</div>
                <!-- <div class="master-item-content-item">意向岗位：PHP工程师</div> -->
            </div>
        </div>
        <div class="master-item">
            <div class="master-item-title">教育背景</div>
            <div class="master-item-content">
                <div class="master-item-content-item">时间：2013-2017</div>
                <div class="master-item-content-item">学校：重庆师范大学</div>
                <div class="master-item-content-item">专业：软件工程(服务外包)</div>
                <div class="master-item-content-item">学历：本科</div>
            </div>
        </div>
        <div class="work-content">
            <div class="work-title">工作经历</div>
            <div class="work-item">
                <div class="work-item-title">
                    <div class="work-title-item">时间：2016-8 至 2017-2</div>
                    <div class="work-title-item">公司：重庆木叶科技</div>
                    <div class="work-title-item">职位：PHP工程师</div>
                </div>
                <div class="work-item-content">外包公司，负责APP接口开发，网站后端模块开发，如：某教育APP接口开发，某微信公众号转盘抽奖后端开发，某电商网站后端开发（http://www.zgnz168.com）</div>
            </div>

            <div class="work-item">
                <div class="work-item-title">
                    <div class="work-title-item">时间：2017-2 至 2018-5</div>
                    <div class="work-title-item">公司：重庆翼路科技</div>
                    <div class="work-title-item">职位：PHP工程师</div>
                </div>
                <div class="work-item-content">公司做自己的产品（零售，进销存）同时也接外包，主要后端框架：laravel，主要前端框架：angularjs，部分项目使用vue，负责后端接口，及接口对应的前端开发，期间因公司需求学会了小程序，主要工作有：进销存模块开发，新零售（分布式）微信三方授权及小程序开发以及外包项目：某法律咨询平台的律师端（小程序）和后台管理系统（laravel+angular）的开发</div>
            </div>

            <div class="work-item">
                <div class="work-item-title">
                    <div class="work-title-item">时间：2018-5 至 今</div>
                    <div class="work-title-item">公司：重庆嗨客网络</div>
                    <div class="work-title-item">职位：PHP工程师</div>
                </div>
                <div class="work-item-content">支付集成系统（laravel+vue），主要负责支付模块的后端开发维护迭代和硬件（pos机），pc插件接口开发，现进行分布式重写（Yii2+vue）</div>
            </div>
            
        </div>
        <div class="skill">
            <div class="skill-title">技术掌握</div>
            <div class="skill-content">
                <div class="skill-item">
                   1.能够搭建LNMP环境,掌握的Linux命令能够满足日常开发所需,有独立建站经验(http://120.78.183.168,暂只支持手机版)
                </div>
                <div class="skill-item">
                   2.掌握js,jquery,css，能够进行一般页面的编写，掌握vuejs,angularjs,能够搭建初始化环境以及模块编写
                </div>
                <div class="skill-item">
                   3.熟悉redis缓存，熟练使用mysql，了解mysql结构及运行原理，掌握sql优化，锁，事务相关知识
                </div>
                
                <div class="skill-item">
                   4.会开发微信小程序
                </div>
                <div class="skill-item">
                   5.熟悉PHP，了解基本运行原理，熟悉使用laravel,Yii2，掌握原生swoole
                </div>
            </div>
            <div class="skill-title">感兴趣的语言</div>
            <div class="skill-content">
                golang、dart
            </div>
        </div>
        <!-- <div class="remark"><i>注：谢绝毫无意义的外包、长期性经常性的加班(不想进icu)、有大牛带最好</i></div> -->
    </div>
</body>
</html>