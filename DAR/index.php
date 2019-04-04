<!DOCTYPE html>
<html lang="en">
<head>
    <title>Department of Agrarian Reform</title>
    <link rel="stylesheet" href="public/css/style.css" >
    <link rel="stylesheet" href="public/css/admin/bootstrap.min.css">
    <link rel="stylesheet" href="public/font-awesome/css/font-awesome.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="public/img/logo.png">
    <style>
        body {
            margin-top:3.5%;
        }
        .container:hover{
            cursor:pointer;
        }
        .container{
            box-shadow:4px 4px 4px 0px gray;
            margin-bottom:0px;
        }
    </style>
</head>
<body>
    <div class="container">
    <div id="phead">
        <img src="public/img/Header (Revised).jpg" style="width:100%;" alt="">
        <!-- <img src="logo/dar_header.jpg" alt="head" id="head">
        <img src="logo/trans-seal.png" alt="transeal" id="seal"> -->
    </div><div class="row">
        <div class="col-lg-9">
    <div id="afterhead">
        <img src="public/img/bg.jpg" class="img-responsive" alt="background">
    </div><br><br>
<center>
    <div id="index">
        <div class="row">
            <div class="col-sm-4 col-xs-4" id="profiling">
                <img src="public/img/prof.png" alt="profiling" class="img-responsive">
                <em><p>ARBO <u>P</u>rofiling System</p></em>
            </div>
            <div class="col-sm-4 col-xs-4" id="inventory">
                <img src="public/img/inv.png" alt="inventory"  class="img-responsive">
                <em><p>ARB <u>I</u>nventory System</p></em>
            </div>
            <div class="col-sm-4  col-xs-4" id="monitor">
                <img src="public/img/mon.png" alt="monitoring"  class="img-responsive">
                <em><p>ARB Reached <u>M</u>onitoring System</p></em>
            </div>
        </div>
    </div>
</center>
</div>
<div class="col-lg-3" id="elib">
    <div id="">
        <span class="pull-right"><button type="button" class="btn btn-success btn-xs " data-toggle="collapse" data-target="#elogin,#ecancel">
            <span class="fa fa-cog"></span>
        </button>
        <a style="color:white;font-size:13px;" id="elogin" href="yob-master/index.php" class="collapse">Log in</a>
        <a style="color:white;font-size:13px;" id="ecancel" href="#" class="collapse" data-target="#elogin,#ecancel" data-toggle="collapse">Cancel</a></span>
        <center><span><h4><b><em><u>e</u>-Library</em></b></h4></center><span>

    <!-- <div class="form-group">
      <label for="disabledSelect" class="col-sm-2 control-label"></label>
      <div class="col-sm-5"> -->
        <select id="disabledSelect" class="form-control form-control-lg" id="art_type" name="art_type" onchange="getArt(this.value)">
          <option value="11">Land Acquisition and Distribution</option>
          <option value="12">Voluntary Land Transfer</option>
          <option value="13">Compulsory Land Acquisition</option>
          <option value="14">Agrarian Legal Assistance</option>
          <option value="15">Burueau of Agrarian Legal Assistance</option>
          <option value="16">DAR Adjustification Board</option>
          <option value="17">Agrarian Production and Credit</option>
          <option value="18">Agrarian Insurance program</option>
          <option value="19">Agrarian Reform Beneficiaries</option>
        </select>
      <!-- </div>
    </div> -->
        <hr>
        <div id="contents"></div>
        
    </div>
</div>
<div class="col-lg-12">
</div>
    </div>
</div>
<script src="public/js/jquery.min.js"></script>
<script src="public/js/bootstrap.min.js"></script>
<script src="public/js/key.js"></script>
<script>
    function getArt(id) {
        $.post('controller/getArticles.php' , {
            id : id
        } , function(data,status){
            $('#contents').html(data);
        });
    }
    $().ready(function(){
        getArt(11);
    });
</script>
</body>
</html>