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
        <title>PPS | Search</title>
        <style>
            #custom-filter select {
                border:0px;
                border-bottom:1px solid gray;
                outline:none;
                padding-top:5px;
                padding-bottom:2.9px;
            } #custom-filter input[type="number"]{
                border:0px;
                border-bottom:1px solid gray;
                outline:none;
            }
            .user-panel {
                background-image:url('../public/img/dar-bg.png');
                height:100px;
            }
            .user-panel {
                background-image:url('../logo/dar-bg.png');
                height:100px;
            }
            #example1_paginate  .paginate_button a {
                color: #1e282c !important;
                background-color:white;
                text-decoration:none;
            }
            #example1_paginate  .paginate_button a:hover {
                color: white !important;
                background-color:#00a65a !important;
                text-decoration:none;
            }
            #example1_paginate .paginate_button a:active {
                background-color:#00a65a !important;
                color:white !important;
            }
            
            .pagination .active a{
                border:1px solid #00a65a  !important;
                background-color:#00a65a !important;
            }

            #example1_paginate > ul > li.paginate_button.active > a {
                color:white !important;
            }
        </style>
    </head>
    <body class="skin-green fixed sidebar-mini sidebar-mini-expand-feature hold-transition">
        <!-- Site wrapper -->
        <div class="wrapper">
            <?php
            $page = 'view';
            include 'inc/header.php';
            include 'inc/sidebar.php';
            ?>
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content">

                    <div class="box box-success">
                        <div class="box-header with-border">
                        <br><center><h2 class="box-title">LIST OF ORGANIZATIONS</h2></center>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                        <div class="row" id="custom-filter">
                                <div class="col-lg-3">
                                    <label for="loans">LOANS: </label>
                                    <select class="" onchange="filter_arbo()" id="loan_filter">
                                        <option value="1">All</option>
                                        <option value="2">With</option>
                                        <option value="0">With out</option> 
                                    </select>
                                </div>
                                <div class="col-lg-5">
                                    <label for="asset_operator">Total Assets: </label>
                                    <select class="" id="asset_operator" onchange="filter_arbo()">
                                        <option value="All">ALL</option>
                                        <option value="=">Equal To</option>
                                        <option value=">">Greater Than</option>
                                        <option value="<">Less Than</option>
                                        <option value=">=">Greater or Equal To</option>
                                        <option value="<=">Less or Equal To</option>
                                    </select>
                                    <input type="number" placeholder="0" class="" onkeyup="filter_arbo()" id="asset_amount">
                                </div>
                                <div class="col-lg-4">
                                    <label for="trainings">Trainings: </label>
                                    <select class="" onchange="filter_arbo()" id="trainings_filter">
                                        <option value="1">All</option>
                                        <option value="2">With Training(s)</option>
                                        <option value="0">Without Training</option>
                                    </select>
                                </div>
                            </div> <hr>
                            <div id="org-table">

                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                </section>
            </div>
            <div class="control-sidebar-bg"></div>
        </div>

  <?php include 'inc/scripts.php' ;?>
        <script>
            let loan_filter = undefined;
            let asset_operator = undefined;
            let asset_amount = undefined;
            let trainings_filter = undefined;
            let flag = undefined;
            
            function filter_arbo() {
                flag = checkVal();
                    $.post("controller/po_profile_filter.php" , {
                        trainings: trainings_filter,
                        asset_amount: asset_amount,
                        asset_operator: asset_operator,
                        loan: loan_filter
                    }, function(data,status){
                        $('#org-table').html(data);
                        data_table_func();
                        // alert(status);
                    });
            }

            $().ready(function() {
                filter_arbo();
            });
            function checkVal() {
                loan_filter = $('#loan_filter').val();
                asset_operator = $('#asset_operator').val();
                asset_amount = $('#asset_amount').val();
                trainings_filter = $('#trainings_filter').val();

                if((loan_filter == undefined || loan_filter == 1)  && (asset_amount == undefined || asset_amount == '' || asset_amount === 0)
                    && (trainings_filter == undefined || trainings_filter == 1)) {
                        return 'def';
                    } else {
                        return 'custom';
                    }
            }
            function data_table_func() {
                $('#example1').DataTable({
                    'paging': true,
                    'lengthChange': true,
                    'searching': true,
                    'ordering': false,
                    'info': true,
                    'autoWidth': false,
                    "lengthMenu": [[8, 25, 50, -1], [8, 25, 50, "All"]]
                })
            }
            //tbl-org-list
        </script>
    </body>
</html>
<?php } else {
    header('Location:../index.php');
}?>