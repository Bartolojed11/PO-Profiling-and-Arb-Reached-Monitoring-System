<?php
session_start();
require 'controller/connection.php';
require 'controller/user_functions.php';
$_COOKIE['username'] = isset($_COOKIE['username']) ? $_COOKIE['username'] : '';
$_COOKIE['ssid'] = isset($_COOKIE['ssid']) ? $_COOKIE['ssid'] : '';
    if(authUser($_COOKIE['username'],$_COOKIE['ssid'], $conn)) {
        $user = $_COOKIE['username'] ;
?>
<!DOCTYPE html>
<html>
    <head>
        <?php include 'inc/css_and_meta.php';?>
        <title>PPS | Home</title>
        <style>
            #custom-filter select {
                border:0px;
                border-bottom:1px solid gray;
                outline:none;
                padding-top:5px;
                padding-bottom:2.9px;
            }
            #custom-filter input[type="number"]{
                border:0px;
                border-bottom:1px solid gray;
                outline:none;
            }
            #highlow_filter {
                border:0px;
                border-bottom:1px solid white;
                outline:none;
                padding-top:5px;
                padding-bottom:2.9px;
                background-color:rgba(0,0,0,.0);
                color:white;
            }
            #highlow_filter option {
                color:black;
            }
            table a {
                color:black;
            }
            table a:hover{
                color:green;
            }
            #top_list tr td{
                border-bottom:1px solid lightgray;
            }
            .table-bordered {
                border-color:1px solid lightgray;
            }
            .box {
                border:0px;
            }
            .user-panel {
                background-image:url('../logo/dar-bg.png');
                height:100px;
            }
        </style>
    </head>
    <body class="skin-green fixed sidebar-mini sidebar-mini-expand-feature hold-transition">
        <!-- Site wrapper -->
        <div class="wrapper">
            <?php
            $page = 'home';
            include 'inc/header.php';
            include 'inc/sidebar.php';
            $sql = 'SELECT count(id) from arbo_profile';
            $run_sql = $conn->prepare($sql);
            $run_sql->execute();
            $run_sql->bind_result($arbo_count);
            $run_sql->store_result();
            $run_sql->num_rows();
            $run_sql->fetch();

            $sql = 'SELECT count(id) from arbo_association_members where arbo_arb_type_id = 1';
            $run_sql = $conn->prepare($sql);
            $run_sql->execute();
            $run_sql->bind_result($arb_count);
            $run_sql->store_result();
            $run_sql->num_rows();
            $run_sql->fetch();

            $sql = 'SELECT count(id) from arbo_association_members where arbo_arb_type_id = 0';
            $run_sql = $conn->prepare($sql);
            $run_sql->execute();
            $run_sql->bind_result($non_arbcount);
            $run_sql->store_result();
            $run_sql->num_rows();
            $run_sql->fetch();
            

            ?>
            <div class="content-wrapper container-fluid" >
                <!-- Content Header (Page header) -->
                <section class="content">
                    <div class="row"><br>
                        <div class="col-lg-12" >
                            <div class="row">
                                <div class="col-lg-4 col-xs-12">
                                    <div class="small-box bg-green">
                                        <div class="inner">
                                            <h3><?php echo $arbo_count ; ?></h3>
                                            
                                            <h4>ORGANIZATION(S)</h4>
                                        </div>
                                        <div class="icon">
                                            <i class="fa fa-users"></i>
                                        </div>
                                        <a href="po_profile_search.php" class="small-box-footer">SHOW ORGANIZATION(S) <i class="fa fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-xs-12">
                                    <div class="small-box bg-green">
                                        <div class="inner">
                                            <h3><?php echo $arb_count ; ?></h3>

                                            <h4>ARB(S)</h4>
                                        </div>
                                        <div class="icon">
                                            <i class="fa fa-user"></i>
                                        </div>
                                        <a href="#" class="small-box-footer"><i class="fa fa-user"></i></a>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-xs-12">
                                    <div class="small-box bg-green">
                                        <div class="inner">
                                            <h3><?php echo $non_arbcount ; ?></h3>

                                            <h4>NON ARB(S)</h4>
                                        </div>
                                        <div class="icon">
                                            <i class="fa fa-user"></i>
                                        </div>
                                        <a href="#" class="small-box-footer"><i class="fa fa-user"></i></a>
                                    </div>
                                </div>
                            </div>
                            <!-- <p>Bootstrap is the most popular HTML, CSS...</p>  -->
                               
                        </div>
                    </div>
                    <div class="row">
                        <div class="box" style="width:97.5%;margin-left:1.2%;margin-right:1.2%;">
                            <!-- /.box-header -->
                            <div class="box-body" >
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="table-responsive"><br>
                                            <table class="table table-hover table-striped table-bordered">
                                                <thead style="background-color:#00a65a;padding:2px;color:white;padding:10px;">
                                                    <tr>
                                                        <th colspan="4" class="text-center" >
                                                            TOP 5 ORGANIZATION WITH <select name="" id="highlow_filter" onchange="show_org_list()">
                                                                <option value="desc">HIGHEST NUMBER OF MEMBER</option>
                                                                <option value="asc">LOWEST NUMBER OF MEMBER</option>
                                                            </select></th>
                                                        <th  class="text-center" colspan="2">ARB</th>
                                                        <th  class="text-center" colspan="2">NON-ARB</th>
                                                    </tr>
                                                </thead>
                                                <thead>
                                                    <tr style="background-color:rgb(189, 255, 189);">
                                                        <th class="text-center" colspan="3">ORGANIZATION</th>
                                                        <th class="text-center" style="width:120px" colspan="1">TOTAL MEMBERS</th>
                                                        <th class="text-center" style="width:120px" colspan="1">MALE</th>
                                                        <th class="text-center" style="width:120px" colspan="1">FEMALE</th>
                                                        <th class="text-center" style="width:120px" colspan="1">MALE</th>
                                                        <th class="text-center" style="width:120px" colspan="1">FEMALE</th>
                                                    </tr>
                                                </thead>

                                                <tbody id="top_list">

                                                </tbody>
                                            </table>
                                            <br>
                                        </div>
                                    </div>
                               
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="box" style="width:97.5%;margin-left:1.2%;margin-right:1.2%;">
                            <!-- /.box-header -->
                            <div class="box-body" >
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <div class="table-responsive"><br>
                                            <table class="table table-hover table-striped table-bordered">
                                                <thead style="background-color:#00a65a;padding:2px;color:white;padding:10px;">
                                                    <tr>
                                                        <th colspan="4" class="text-center" >TOP 5 ORGANIZATION WITH HIGHEST AMOUNT OF TOTAL ASSET</th>
                                                    </tr>
                                                </thead>
                                                <thead>
                                                    <tr style="background-color:rgb(189, 255, 189);">
                                                        <th class="text-center" colspan="2">ORGANIZATION</th>
                                                        <th class="text-center" style="width:120px" colspan="1">TOTAL ASSET</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $sql = 'SELECT distinct(arbo.id) ,arbo.name, fin_stat.amount from arbo_profile as arbo
                                                                inner join arbo_financial_status as fin_stat
                                                                on arbo.id = fin_stat.arbo_profile_id
                                                                WHERE fin_stat.arbo_financial_type_id = 3
                                                                ORDER BY fin_stat.amount DESC LIMIT 5';
                                                        $run_sql = $conn->prepare($sql);
                                                        $run_sql->execute();
                                                        $run_sql->bind_result($arbo_id,$arbo,$asset);
                                                        $run_sql->store_result();
                                                        if($run_sql->num_rows()) {
                                                            while($run_sql->fetch()) {
                                                                echo '<tr>
                                                                        <td colspan="2"><a href="po_profile.php?id='.$arbo_id.'">'.$arbo.'</a></td>
                                                                        <td>'.$asset.'</td>
                                                                     </tr>';
                                                            }
                                                        } 
                                                    ?>
                                                </tbody>
                                            </table>
                                            <br>
                                        </div>
                                    </div>
                               
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <div class="table-responsive"><br>
                                            <table class="table table-hover table-striped table-bordered">
                                                <thead style="background-color:#00a65a;padding:2px;color:white;padding:10px;">
                                                    <tr>
                                                        <th colspan="4" class="text-center" >TOP 5 ORGANIZATION WITH LOWEST AMOUNT OF TOTAL ASSET</th>
                                                    </tr>
                                                </thead>
                                                <thead>
                                                    <tr style="background-color:rgb(189, 255, 189);">
                                                        <th class="text-center" colspan="2">ORGANIZATION</th>
                                                        <th class="text-center" style="width:120px" colspan="1">TOTAL ASSET</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $sql = 'SELECT distinct(arbo.id) ,arbo.name, fin_stat.amount from arbo_profile as arbo
                                                                inner join arbo_financial_status as fin_stat
                                                                on arbo.id = fin_stat.arbo_profile_id
                                                                WHERE fin_stat.arbo_financial_type_id = 3
                                                                ORDER BY fin_stat.amount ASC LIMIT 5';
                                                        $run_sql = $conn->prepare($sql);
                                                        $run_sql->execute();
                                                        $run_sql->bind_result($arbo_id,$arbo,$asset);
                                                        $run_sql->store_result();
                                                        if($run_sql->num_rows()) {
                                                            while($run_sql->fetch()) {
                                                                echo '<tr>
                                                                        <td colspan="2"><a href="po_profile.php?id='.$arbo_id.'">'.$arbo.'</a></td>
                                                                        <td>'.$asset.'</td>
                                                                      </tr>';
                                                            }
                                                        } 
                                                    ?>
                                                </tbody>
                                            </table>
                                            <br>
                                        </div>
                                    </div>

                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <div class="control-sidebar-bg"></div>
        </div>

        <?php include 'inc/scripts.php' ;?>
        <script>
            $(document).ready(function () {
                show_org_list();
            });
            function show_org_list() {
                let org_filter = $('#highlow_filter').val();
                $.post('controller/top_org.php'
                        , {
                            org_filter: org_filter
                        }, function (data, status) {
                    //   alert(status);
                    $('#top_list').html(data);
                });
            }
        </script>
    </body>
</html>
<?php } else {
    header('Location:../index.php');
}?>