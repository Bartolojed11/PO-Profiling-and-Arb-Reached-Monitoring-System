<?php
session_start();
require 'controller/connectdb.php';
require 'controller/user_functions.php';
$_COOKIE['username'] = isset($_COOKIE['username']) ? $_COOKIE['username'] : '';
$_COOKIE['ssid'] = isset($_COOKIE['ssid']) ? $_COOKIE['ssid'] : '';
    if(authUser($_COOKIE['username'],$_COOKIE['ssid'], $conn)) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        #custom-filter select {
                border:0px;
                border-bottom:1px solid gray;
                outline:none;
                padding-top:5px;
                padding-bottom:2.9px;
            }
            #custom-filter input[type="number"] {
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
                background-image:url('../public/img/dar-bg.png');
                height:100px;
            }
    </style>
    <?php include 'inc/cssLinks.php'; ?>
    <link href="../public/img/logo.png" rel="icon" type="image">
    <title>ARB REACHED</title>
</head>
<body class="skin-green fixed sidebar-mini sidebar-mini-expand-feature hold-transition">
        <!-- Site wrapper -->
        <div class="wrapper">
        <?php
            $page = 'index';
            $get_city = isset($_GET['city']) ? $_GET['city'] : '' ;
            include 'inc/navbar.php';
            include 'inc/sidebar.php';

            $sql = 'SELECT count(id) from arb_org';
            $run_sql = $conn->prepare($sql);
            $run_sql->execute();
            $run_sql->bind_result($arbo_count);
            $run_sql->store_result();
            $run_sql->num_rows();
            $run_sql->fetch();

            // $sql = "SELECT distinct(count(*))
            // FROM arb_information as arb
            // inner join city on city.id = arb.city_id
            // inner join barangay as brgy on brgy. id = arb.brgy_id
            // inner join arb_org as arbo on arbo.id = arb.arbo_id
            // WHERE ((SELECT count(*) FROM arb_trainings_attended WHERE arb_id = arb.id) > 0)
            // and ((SELECT COUNT(*) FROM arb_acquired_intervention WHERE arb_id = arb.id) > 0)";
            $sql = 'SELECT COUNT(*) from arb_information';
            $sql = $conn->prepare($sql);
            $sql->execute();
            $sql->bind_result($reachedarb_count);
            $sql->store_result();
            $sql->num_rows();
            $sql->fetch();

            $sql = "SELECT distinct(arb.id),
                    (CASE
                        WHEN mi IS not NULL THEN concat_ws(' ' , lname, fname, mi)
                        ELSE concat_ws(' ' , arb.lname, arb.fname)
                    END) as fullname, arb.land_size ,  arb_org.arbo_name
                    from arb_information as arb inner join arb_org as arb_org
                    on arb_org.id = arb.arbo_id
                    order by land_size desc limit 5";
            $sql = $conn->prepare($sql);
            $sql->execute();
            $sql->bind_result($arb_id, $arb_fullname, $arb_landsize, $arb_organization);
            $sql->store_result();
            $sql->num_rows();
            
        ?>
            <div class="content-wrapper container-fluid" >
                <section class="content">
            <span style="font-size:20px;font-weight:bolder;margin-left:1.2%;color:green;">ARB Reached Home</span>
            <div class="row"><br>
                        <div class="col-lg-9">
                        <div class="box" style="width:97.5%;margin-left:0%;margin-right:1.2%;">
                            <div class="box-body" >
                            <div class="col-lg-12">
                                <table class="table table-bordered table-striped table-hover">
                                <thead style="background-color:#00a65a;padding:2px;color:white;padding:10px;">
                                        <tr>
                                            <th colspan="12" class="text-center" >ARB with highest amount of Landsize</th>
                                        </tr>
                                    </thead>
                                    <thead>
                                        <tr style="background-color:rgb(189, 255, 189);">
                                            <th class="text-center" style="width:200px;">FULLNAME</th>
                                            <th class="text-center">ORGANIZATION</th>
                                            <th class="text-center" style="width:120px">ARB LANDSIZE(ha)</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                            while($sql->fetch()) {
                                                echo "<tr>
                                                        <td><a href='$arb_id'>$arb_fullname</a></td>
                                                        <td>$arb_organization</td>
                                                        <td class='text-center'>$arb_landsize</td>
                                                    </tr>";
                                            }
                                        ?>
                                    </tbody>
                                </table>
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3" >
                            <div class="row">
                            <div class="box" style="width:95.2%;%;padding-top:2.2%;">
                            <div class="box-body" >
                                <div class="col-lg-12 col-xs-12">
                                    <div class="small-box bg-green">
                                        <div class="inner">

                                            <h3><?php echo $arbo_count ; ?></h3>

                                            <h4>ORGANIZATION(S)</h4>
                                        </div>
                                        <div class="icon">
                                            <i class="fa fa-users"></i>
                                        </div>
                                        <a href="#" class="small-box-footer"><i class="fa fa-users"></i></a>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-xs-12">
                                    <div class="small-box bg-green">
                                        <div class="inner">
                                            <h3><?php echo $reachedarb_count ; ?></h3>

                                            <h4>REACHED ARB(S)</h4>
                                        </div>
                                        <div class="icon">
                                            <i class="fa fa-user"></i>
                                        </div>
                                        <a href="#" class="small-box-footer"><i class="fa fa-user"></i></a>
                                    </div>
                                </div>
                            </div>
                            </div>
                            </div>
                            <!-- <p>Bootstrap is the most popular HTML, CSS...</p>  -->
                               
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="box" style="width:97.5%;margin-left:1.2%;margin-right:1.2%;">
                            <!-- /.box-header -->
                            <div class="box-body" >
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="table-responsive"><br>
                                            <table class="table table-hover table-striped table-bordered">
                                                <thead style="background-color:#00a65a;padding:2px;color:white;padding:10px;">
                                                    <tr>
                                                        <th colspan="12" class="text-center" >
                                                            TOP 5 ORGANIZATION WITH <select name="" id="highlow_filter" onchange="show_org_list()">
                                                                <option value="desc">HIGHEST NUMBER OF MEMBERS</option>
                                                                <option value="asc">LOWEST NUMBER OF MEMBERS</option>
                                                            </select></th>
                                                    </tr>
                                                </thead>
                                                <thead>
                                                    <tr style="background-color:rgb(189, 255, 189);">
                                                        <th class="text-center" colspan="3">ORGANIZATION</th>
                                                        <th class="text-center" style="width:120px" colspan="1">TOTAL MEMBERS</th>
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




                </section>
                
            </div>
        
        </div>
    <?php
        include 'inc/footer.php';
        include 'inc/js.php' ;
    ?>
    <script>
            $(document).ready(function () {
                show_org_list();
            });
            function show_org_list() {
                let org_filter = $('#highlow_filter').val();
                $.post('controller/top_arb.php'
                    , {
                        org_filter: org_filter
                    } , function (data, status) {
                    //   alert(status);
                    $('#top_list').html(data);
                });
            }
        </script>
    </body>
</html>
<?php } else {
    // echo "here" . $_SESSION['username'] . ' cookies ' . $_COOKIES['username'];
    header('Location:../index.php');    
}?>