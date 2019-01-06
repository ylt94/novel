<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>注册</title>
    <meta name="viewport" content="width=device-width, initial-scale=1,user-scalable">
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
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Raleway', sans-serif;
            font-weight: 100;
            height:100%;
            width:100%;
            margin: 0;
        }
        .header{
            height:20%;
            width:100%;
            background-color:red;
        }
        .register{
            height:80%;
            width:90%;
            padding:0 5% 0 5%;
        }
        .logo{
            height:10%;
            width:100%;
        }
        .register-item{
            height:20%;
            width:100%;
            display:flex;
            flex-direction:row;
            justify-content:space-around;
            align-items:center;
        }
        .input{
            border:none;
            line-height:40px;
            width:90%;
            box-sizing:border-box;
            border-radius: 5px;
            border-bottom: 1px solid #dcdfe6;
            padding-left:20px;
            font-size:16px;
            color: #606266;
        }
        input::-webkit-input-placeholder {
            /* placeholder颜色  */
            color: #dcdfe6;
            /* placeholder字体大小  */
            font-size: 15px;
        }
        .sub-btn{
            margin-top:20px;
            height:40px;
            width:100%;
            background-color:red;
            border-radius: 5px;
            border:none;
            font-size: 15px;
        }

        .login{
            height:10%;
            width:95%;
            display:flex;
            flex:1;
            justify-content:flex-end;
            align-items:center;
        }
}
    </style>
</head>
<body>
    <div class="header">
    </div>
    <div class="register">
        <div class="logo">
            
        </div>
        <form style="height:80%;width:100%">
            <div class="register-item">
                <input type="text" size="20" placeholder="用户名" class="input" name="user_name" />
            </div>
            <div class="register-item">
                <input type="password" size="20" placeholder="密码" class="input" name="password" />
            </div>
            <div class="register-item">
                <input type="password" size="20" placeholder="确认密码" class="input" name="confirm_password" />
            </div>
            <div class="login">
            <a href="/login" style="color:blue;font-size:14px;">已有账号，去登录</a>
            </div>
            <input type="submit" class="sub-btn" value="注册">
        </form>
        
    </div>
</body>
</html>