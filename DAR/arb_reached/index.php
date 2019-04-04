<?php
    session_start();
    require 'pages/controller/connectdb.php';
    require 'pages/controller/user_functions.php';
    $_COOKIE['username'] = isset($_COOKIE['username']) ? $_COOKIE['username'] : '';
    $_COOKIE['ssid'] = isset($_COOKIE['ssid']) ? $_COOKIE['ssid'] : '';
        if(!authUser($_COOKIE['username'],$_COOKIE['ssid'], $conn)) { ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Web Based ARBO Profiling and Monitoring System</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="../public/css/bootstrap.min.css">
  <link rel="stylesheet" href="../public/css/Admin.css" type="text/css"/>
  <link href="../public/css/indexs.css" rel="stylesheet" type="text/css" media="all" />

<style>
    body {
        background: rgba(235,228,162,1);
        background: -moz-linear-gradient(top, rgba(235,228,162,1) 0%, rgba(235,228,162,1) 39%, rgba(102,208,116,1) 85%, rgba(58,201,101,1) 100%);
        background: -webkit-gradient(left top, left bottom, color-stop(0%, rgba(235,228,162,1)), color-stop(39%, rgba(235,228,162,1)), color-stop(85%, rgba(102,208,116,1)), color-stop(100%, rgba(58,201,101,1)));
        background: -webkit-linear-gradient(top, rgba(235,228,162,1) 0%, rgba(235,228,162,1) 39%, rgba(102,208,116,1) 85%, rgba(58,201,101,1) 100%);
        background: -o-linear-gradient(top, rgba(235,228,162,1) 0%, rgba(235,228,162,1) 39%, rgba(102,208,116,1) 85%, rgba(58,201,101,1) 100%);
        background: -ms-linear-gradient(top, rgba(235,228,162,1) 0%, rgba(235,228,162,1) 39%, rgba(102,208,116,1) 85%, rgba(58,201,101,1) 100%);
        background: linear-gradient(to bottom, rgba(235,228,162,1) 0%, rgba(235,228,162,1) 39%, rgba(102,208,116,1) 85%, rgba(58,201,101,1) 100%);
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ebe4a2', endColorstr='#3ac965', GradientType=0 );
    }
    .carousel-inner img {
      width: 50em;
      height: 30em;
      border-radius:5px;
    }
    #reg-box , #login_ss {
        display:flex;
        justify-content:center;
        align-items:center;
    }
    .login-avatar img {
      height:140px;
      width:140px;
      border-radius:50%;
      border:3px solid gray;
    }
    .login-avatar {
      display:flex;
      justify-content:center;
      align-items:center;
      margin-bottom:15%;
    }
    .carousel-inner {
        -webkit-box-shadow: 3px 5px 5px 0px rgba(0,0,0,0.38);
        -moz-box-shadow: 3px 5px 5px 0px rgba(0,0,0,0.38);
        box-shadow: 3px 5px 5px 0px rgba(0,0,0,0.38);
        border-top:2px solid white;
        border-left:2px solid white;
        width: 50em;
        height: 30em;
        border-radius:5px;
    }
    .ccpi,.ccni {
        background-color:green;
        border:1px solid white;
        border-radius:50%;
        height:50px;
        width:50px;
        display:flex;
      justify-content:center;
      align-items:center;
    }
    .register-box-body {
        height:450px;
        width:300px;
        border-top:2px solid white;
        border-left:1px solid white;
        margin-left:15%;
    }
    ::placeholder {
        color:black;
    }
    .carousel-indicators li{
        height:3px;
        width:20px;
    }
    .carousel-indicators {
        display:flex;
      justify-content:center;
      align-items:center;
    }
    .errorAuth {
        border:1px solid red;
    }
</style>
</head>

<body class="hold-transition win-page">

<div class="container-fluid">
    <nav class="navbar navbar-default">
        <div class="navbar-header">
            <h1><a class="navbar-brand" href="index.php" style="color:mediumseagreen">WBARB<span>RMS</span><p class="logo_w3l_agile_caption" style="color:green">Web-based ARB REACHED MONITORING System</p></a></h1>
            <b><div class="muted pull-center" style="color: mediumseagreen"><i class="icon-time"></i>&nbsp;
            <span id="tick2">
            </span> &nbsp;|&nbsp;
	      <?php
            $date = new DateTime();
            echo $date->format(' F j, Y, l');
          ?>
            </div></b>
        </div>
    </nav>
</div>

<div class="bg">
    <div class="row">
        <div class="col-lg-3 col-md-3" style="margin-bottom:10%;">
        <div  id="reg-box" style="margin-top:10%; margin-right:-20%;">
            <div class="register-box-body" style="border-radius:10px">
            
            <div class="login-avatar">
                <img src="../public/img/login-user.png" style="width:50%;" alt="">
            </div>

                <form action="validate/login.php" method="post" id="user">
                    <div class="form-group has-feedback" style="margin-bottom:10px;">
                        <input type="text" class="form-control" style="border-radius:10px"
                         name="username" id="username" required>
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" class="form-control" style="border-radius:10px"
                        placeholder="Password" name="password" id="password" required>
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div><br>
                    <div class="row">
                    <div class="col-xs-12 col-lg-12" style="width:100%;">
                        <center><button type="button" class="btn btn-success btn-flat"
                        style="width:35%; height:35px; border-radius:10px; padding-top:3px;" id="login" name="login"><b>Log In</b></button></center>
                    </div>
                    
                    </div>
                </form>
                <div class="col-xs-12 col-lg-12" style="margin-top:10px;">
                        <center>
                            <a href="../index.php">
                                <button type="button" class="btn btn-success btn-flat" style="width:30%; height:33px; border-radius:10px; padding-top:3px;">
                                <b>Main</b></button>
                            </a>
                        </center>
                </div>
            </div>
        </div>
        </div>
        <div class="col-lg-9 col-md-9" style="height:30em;width:50em;">
        <div  id="login_ss" style="margin-top:20px;">
        <div id="login_slideshow" class="carousel slide container-fluid" data-ride="carousel" style="height:30em;width:50em;">

  <!-- Indicators -->
        <ul class="carousel-indicators">
            <li data-target="#login_slideshow" data-slide-to="0" class="active"></li>
            <li data-target="#login_slideshow" data-slide-to="1"></li>
            <li data-target="#login_slideshow" data-slide-to="2"></li>
            <li data-target="#login_slideshow" data-slide-to="3"></li>
            <li data-target="#login_slideshow" data-slide-to="4"></li>
            <li data-target="#login_slideshow" data-slide-to="5"></li>
            <li data-target="#login_slideshow" data-slide-to="6"></li>
            <li data-target="#login_slideshow" data-slide-to="7"></li>
            <li data-target="#login_slideshow" data-slide-to="8"></li>
            <li data-target="#login_slideshow" data-slide-to="9"></li>
            <li data-target="#login_slideshow" data-slide-to="10"></li>
            <li data-target="#login_slideshow" data-slide-to="11"></li>
            <li data-target="#login_slideshow" data-slide-to="12"></li>
            <li data-target="#login_slideshow" data-slide-to="13"></li>
            <li data-target="#login_slideshow" data-slide-to="14"></li>
            <li data-target="#login_slideshow" data-slide-to="15"></li>
            <li data-target="#login_slideshow" data-slide-to="16"></li>
            <li data-target="#login_slideshow" data-slide-to="17"></li>
            <li data-target="#login_slideshow" data-slide-to="18"></li>
            <li data-target="#login_slideshow" data-slide-to="19"></li>
        </ul>

        <!-- The slideshow -->
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="../public/img/1-01.png" alt="">
            </div>
            <div class="carousel-item">
                <img src="../public/img/2-01.png" alt="">
            </div>
            <div class="carousel-item">
                <img src="../public/img/3-01.png" alt="">
            </div>
            <div class="carousel-item">
                <img src="../public/img/4-01.png" alt="">
            </div>
            <div class="carousel-item">
                <img src="../public/img/5-01.png" alt="">
            </div>
            <div class="carousel-item">
                <img src="../public/img/6-01.png" alt="">
            </div>
            <div class="carousel-item">
                <img src="../public/img/7-01.png" alt="">
            </div>
            <div class="carousel-item">
                <img src="../public/img/8-01.png" alt="">
            </div>
            <div class="carousel-item">
                <img src="../public/img/9-01.png" alt="">
            </div>
            <div class="carousel-item">
                <img src="../public/img/10-01.png" alt="">
            </div>
            <div class="carousel-item">
                <img src="../public/img/11-01.png" alt="">
            </div>
            <div class="carousel-item">
                <img src="../public/img/12-01.png" alt="">
            </div>
            <div class="carousel-item">
                <img src="../public/img/13-01.png" alt="">
            </div>
            <div class="carousel-item">
                <img src="../public/img/14-01.png" alt="">
            </div>
            <div class="carousel-item">
                <img src="../public/img/15-01.png" alt="">
            </div>
            <div class="carousel-item">
                <img src="../public/img/16-01.png" alt="">
            </div>
            <div class="carousel-item">
                <img src="../public/img/17-01.png" alt="">
            </div>
            <div class="carousel-item">
                <img src="../public/img/18-01.png" alt="">
            </div>
            <div class="carousel-item">
                <img src="../public/img/19-01.png" alt="">
            </div>
        </div>

        <!-- Left and right controls -->
        <a class="carousel-control-prev"  href="#login_slideshow" data-slide="prev" style="margin-left:-87px;">
            <span class="ccpi">
                <span class="carousel-control-prev-icon"></span>
            </span>
        </a>
        <a class="carousel-control-next" href="#login_slideshow" style="margin-right:-140px;" data-slide="next">
            <span class="ccni" style="margin-right:50px;">
                <span class="carousel-control-next-icon"></span>
            </span>
        </a>

        </div>
        </div>
    </div>
</div>
</div>
  <script src="../public/js/jquery.min.js"></script>
  <script src="../public/js/bootstrap.min.js"></script>
  <script>
    "user strict";
    function show2() {
    if (!document.all&&!document.getElementById)
    return
    thelement=document.getElementById? document.getElementById("tick2"): document.all.tick2
    var Digital=new Date()
    var hours=Digital.getHours()
    var minutes=Digital.getMinutes()
    var seconds=Digital.getSeconds()
    var dn="PM"
    if (hours<12)
    dn="AM"
    if (hours>12)
    hours=hours-12
    if (hours==0)
    hours=12
    if (minutes<=9)
    minutes="0"+minutes
    if (seconds<=9)
    seconds="0"+seconds
    var ctime=hours+":"+minutes+":"+seconds+" "+dn
    thelement.innerHTML=ctime
    setTimeout("show2()",1000)
    }
    $().ready(function() {
        show2();
    });

        $('#login').on('click', login);
        $(document).keyup(function(event) {
            var key = event.which;
            if(key == 13) {
                login();
            }
        });
        function login() {
            $.post('validate/login.php' , {
            username : $('#username').val(), 
            password : $('#password').val()
            } , function(data,status) {
                if(data) {
                    window.location.href = 'pages/index.php';
                } else {
                    $('#username, #password').addClass('errorAuth');
                }
            });
        }
</script>

</body>
</html>
<?php } else {
    header('Location:pages/index.php');    
}?>