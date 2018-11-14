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
            height: 100%;
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
            height:100%;
            width: 820px;
            min-height: 1160px;
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
            margin-left:30px;
        }
        .name{
            color:auto;
            font-size:30px;
            font-weight:800;
        }
        .desc{
            padding-left:40px;
            font-size:15px;
            margin-bottom:10px;
        }
        .master{
            margin-top:15px;
            background-color:#f4f4f4;
            padding: 0 50px 0 50px;
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
    </style>
</head>
<body>
    <div class="head">
        <div class="image"></div>
        <div class="base-info">
            <div class="name">袁粒桃</div>
            <div class="desc"><i>-----春风得意马蹄疾，一日看遍长安花</i></div>
            <div class="desc">
                25岁
                <span style="font-weight:600"> | </span>
                2+年经验
                <span style="font-weight:600"> | </span>
                17384082748
                <span style="font-weight:600"> | </span>
                857425891@qq.com
            </div>
        </div>
    </div>
    <div class="master">
        <div class="master-item">
            <div class="master-item-title">求职意向</div>
            <div class="master-item-content">
                <div class="master-item-content-item">意向岗位：PHP工程师</div>
                <div class="master-item-content-item">意向城市：深广上北</div>
                <div class="master-item-content-item">薪资要求：12K-20K</div>
                <!-- <div class="master-item-content-item">意向岗位：PHP工程师</div> -->
            </div>
        </div>
        <div class="master-item">
            <div class="master-item-title">教育背景</div>
            <div class="master-item-content">
                <div class="master-item-content-item">时间：2013-2017</div>
                <div class="master-item-content-item">学校：重庆师范大学</div>
                <div class="master-item-content-item">专业：软件工程(服务外包)</div>
                <!-- <div class="master-item-content-item">意向岗位：PHP工程师</div> -->
            </div>
        </div>
    </div>
</body>
</html>