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
<?php include 'inc/cssLinks.php'; ?>
        <link href="../public/img/logo.png" rel="icon" type="image">
    <title>ARB REACHED</title>
    <style>
            .user-panel {
                background-image:url('../public/img/dar-bg.png');
                height:100px;
            }
            input[type="text"]:disabled {
                background-color:white;
                border:0px;
                border-bottom:1px solid gray;
            }
            #reached-arb_paginate  .paginate_button a {
                color: #1e282c !important;
                background-color:white;
                text-decoration:none;
            }
            #reached-arb_paginate  .paginate_button a:hover {
                color: white !important;
                background-color:#00a65a !important;
                text-decoration:none;
            }
            #reached-arb_paginate .paginate_button a:active {
                background-color:#00a65a !important;
                color:white !important;
            }
            
            .pagination .active a{
                border:1px solid #00a65a  !important;
                background-color:#00a65a !important;
            }
            #reached-arb_paginate > ul > li.paginate_button.active > a {
                color:white !important;
            }
    </style>
</head>
<body class="skin-green fixed sidebar-mini sidebar-mini-expand-feature hold-transition">
        <!-- Site wrapper -->
        <div class="wrapper">
        <?php
            $page = 'arb-reached';
            $get_city = isset($_GET['city']) ? $_GET['city'] : '' ;
            $get_city = htmlspecialchars($get_city);
            include 'inc/navbar.php';
            include 'inc/sidebar.php';
        ?>
        <div class="content-wrapper">
                <section class="content">
                    <div class="box box-success">
                        <div class="box-header with-border">
                            <center><h2 class="box-title">LIST OF REACHED ARB</h2></center>
                        </div><br>
                        
                        <div class="row container">
                        <div class="form-group col-lg-3 col-sm-3">
                            <label for="arb_position">Municipality</label>
                                <select class="form-control select_brdr_btm" id="arb_municipal"
                                        name="arb_municipal" required onchange="show_barangay()"
                                        style="border:0px;border-bottom:1px solid gray;">
                                    <?php
                                    $sql = 'SELECT id,city FROM city ORDER BY CITY ASC';
                                    $sql = $conn->prepare($sql);
                                    $sql->execute();
                                    $sql->bind_result($id,$city);
                                    $sql->store_result();
                                    if($sql->num_rows() > 0) {
                                    while($sql->fetch()) {
                                        echo "<option value='$id'>$city</option>";
                                        }
                                    }
                                    ?>
                                </select>
                        </div>
                        <div class="form-group col-lg-3 col-sm-3">
                            <label for="arbo_barangay">BARANGAY</label>
                            <input type="hidden" name="upd_cid" value="0">
                            <select class="form-control select_brdr_btm" id="arb_barangay" onchange="show_arb_vbrgy(this.value)" name="arb_barangay"
                                    required style="border:0px;border-bottom:1px solid gray;">

                            </select>
                        </div>
                        <div class="form-group col-lg-2 col-sm-2">
                            <label for="ttl_landsize">TOTAL LANDSIZE(ha)</label>
                            <input type="text" disabled class="form-control" id="ttl_landsize" >
                        </div>  
                        </div>
                        <hr style="margin-bottom:0px;margin-top:0px;">
                        
                        <!-- /.box-header -->
                        <div class="box-body">
                       

                                <div class="arb_table">
                                
                                </div>
                            
                        </div>
                        <!-- /.box-body -->
                    </div>
                </section>
            </div>
    </div>


    <?php include 'inc/js.php' ; ?>
    <script>
    let city = undefined;
    let arb_reached_flag = 0;
    let brgy = undefined;
        data_table_cust();
        show_barangay();
        function show_barangay() {
            city = $('#arb_municipal').val();
            arb_reached_flag = 1;

            $.post('controller/disp_brgy.php' , {
                cid : city,
                arb_reached_flag : arb_reached_flag
            } , function(data,status) {
                $('#arb_barangay').html(data);
            }).done(function() {
                brgy = $('#arb_barangay').val();
                $.post('controller/show_reached_arb.php' , {
                    cid : city,
                    bid : brgy
                } , function(data,status) {                  
                    $('.arb_table').html(data);
                    data_table_cust();
                    $('#ttl_landsize').val($('#ttl_land_hid').val());
                });
            });;
        }

        function show_arb_vbrgy(val) {
            city = $('#arb_municipal').val();
            $.post('controller/show_reached_arb.php' , {
                bid : val,
                cid : city
            } , function(data,status) {
                $('.arb_table').html(data);
                data_table_cust();
                $('#ttl_landsize').val($('#ttl_land_hid').val());
            });
        }
        function data_table_cust() {
            $('#reached-arb').DataTable({
                'paging': true,
                'lengthChange': true,
                'searching': true,
                'ordering': false,
                'info': true,
                'autoWidth': false,
                "lengthMenu": [[8, 25, 50, -1], [8, 25, 50, "All"]]
            });
        }
        </script>
    </body>
</html>
<?php } else {
    header('Location:../index.php');    
}?>