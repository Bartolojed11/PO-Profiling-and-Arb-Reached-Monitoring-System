<?php
session_start();
require 'controller/connectdb.php';
require 'controller/user_functions.php';
$_COOKIE['username'] = isset($_COOKIE['username']) ? $_COOKIE['username'] : '';
$_COOKIE['ssid'] = isset($_COOKIE['ssid']) ? $_COOKIE['ssid'] : '';
    if(authUser($_COOKIE['username'],$_COOKIE['ssid'], $conn)) {
        $user = $_COOKIE['username'] ;
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

            .box {
                border:0px;
            }
            .active_cust {
                font-weight:bolder;
                color:#00a65a;
            }
            #arb_page li:hover,.active_cust  {
                cursor:pointer;
            }
            input[type="text"] , input[type="number"], input[type="date"]{
                border:0px;
                border-bottom:1px solid gray;
            }
            input[type="file"] {
                border:0px;
                outline:none;
            }
            .select_brdr_btm {
                background-color:black;
                border:0px;
                border-bottom:1px solid gray;
            }
            .select_brdr_btm:focus {
                outline:none;
                border-bottom:1.5px solid green;
            }
            .select_brdr_btm:disabled{
                background-color:rgba(255,255,255,0.8);
            }
            input[type="text"]:focus , input[type="number"]:focus, input[type="date"]:focus{
                border-bottom:1.5px solid green;
                outline:none;
            }
            input[type="checkbox"]{
                border-color:#00a65a;
            }
            .bg-success-custom{
                background-color:#00a65a;color:white;
            }
            input[type="text"]:disabled , input[type="number"]:disabled, input[type="date"]:disabled{
                background-color:white;
            }
            .custom-input-white{
                background-color:#00a65a;
                color:white;
            }
            .custom-input-white:focus{
                background-color:rgb(189, 255, 189,0.5);
                border:0px;
                border-bottom:1.5px solid white;
                color:black;
                outline:none;
            }
            .custom-input-white::placeholder{
                color:white;
            }
            .addbgcolor{
                background-color:rgba(212, 204, 204, .5);
                font-weight:bold;
            }
            :disabled{
                background-color:rgba(255,255,255,.2);
            }
            .user-panel {
                background-image:url('../public/img/dar-bg.png');
                height:100px;
            }
            .ifError {
                color:red;
            }
            input[type="checkbox"] {
                height:15px;
                width:15px;
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
            $page = 'add_arb';
            include 'inc/navbar.php';
            include 'inc/sidebar.php';
            ?>
            <div class="content-wrapper container-fluid" >
                <section class="content-header">
                    <h1>&nbsp;&nbsp;&nbsp;ARB REACHED FORM</h1>
                    <ol class="breadcrumb" id="arb_page">
                    </ol>
                </section>
                <section class="content">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-next">
                                <div class="box box-success" style="width:97.5%;margin-left:1.2%;margin-right:1.2%;">

                                    <!-- PAGE I -->


                                    <!-- content -->
                            
                                    <div class="box-body">
                                        <div class="row">
                                        <div style="padding-left:4%;padding-right:4%;">
                        <form action="controller/add_arb_process.php" method="post" novalidate id="register-arb">
<br><br>
                            <div class="form-group col-lg-6 col-sm-6">
                                <label for="arbo_municipal">MUNICIPALITY</label>
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

                            <div class="form-group col-lg-6 col-sm-6">
                                <label for="arbo_barangay">BARANGAY</label>
                                <input type="hidden" name="upd_cid" value="0">
                                <select class="form-control select_brdr_btm" id="arb_barangay" name="arb_barangay"
                                        required style="border:0px;border-bottom:1px solid gray;">

                                </select><br>
                            </div>

                            <div class="col-lg-12">
                                <b>PART I : ARB Information</b> <br><br>
                                <b>NAME OF ARB</b> &nbsp;&nbsp;&nbsp;<span class="error_mess"></span>
                            </div> <br>
                            <div class="form-group col-lg-4 col-sm-4" style="height:70px;">
                                <label for="arb_lname">Last Name</label>
                                <input type="text" class="form-control" name="arb_lname" id="arb_lname"  >
                            </div>
                            <div class="form-group col-lg-4 col-sm-4" style="height:70px;">
                                <label for="arb_fname">First Name</label>
                                <input type="text" class="form-control" name="arb_fname" id="arb_fname">
                            </div>
                            <div class="form-group col-lg-2 col-sm-4" style="height:70px;">
                                <label for="arbo_barangay">MI</label>
                                <input type="text" class="form-control" name="arb_mi" id="arb_mi"  >
                            </div> <br>
                            <div class="form-group col-lg-2 col-sm-2">
                                <label for="gender">Gender</label>
                                <select style="border:0px;border-bottom:1px solid gray;" class="form-control select_brdr_btm" name="gender" id="gender">
                                    <option value="M">Male</option>
                                    <option value="F">Female</option>
                                </select>
                            </div>

                            <div class="form-group col-lg-4 col-sm-4">
                                <label for="civil_status">Civil Status</label>
                                <select class="form-control select_brdr_btm" name="civil_status" id="civil_status"
                                        style="border:0px;border-bottom:1px solid gray;">
                                    <?php
                                        $sql = 'SELECT status from civil_status';
                                        $sql = $conn->prepare($sql); 
                                        $sql->execute();
                                        $sql->bind_result($status);
                                        $sql->store_result();
                                        if($sql->num_rows() > 0) {
                                            while($sql->fetch()) {
                                                echo "<option value='$status'>$status</option>";
                                            }
                                        }
                                        ?>
                                </select>
                            </div>
                            <div class="form-group col-lg-4 col-sm-4">
                                <label for="arb_bdate">Birthdate</label>
                                <input type="date" class="form-control" name="arb_bdate" id="arb_bdate"
                                max="2005-01-01" min="1880-01-01" onblur="set_age();">
                            </div>
                            <div class="form-group col-lg-2 col-sm-4">
                                <label for="arbo_barangay">Age : </label>
                                <input type="text" class="form-control" disabled id="age"  >
                            </div>

                            <div class="col-lg-12">
                                <b>NAME OF SPOUSE</b>
                            </div> <br><br>
                            <div class="form-group col-lg-4 col-sm-4">
                                <label for="arbo_barangay">Last Name</label>
                                <input type="text" class="form-control" name="spouse_lname" id="spouse_lname"  >
                            </div>
                            <div class="form-group col-lg-4 col-sm-4">
                                <label for="arbo_barangay">First Name</label>
                                <input type="text" class="form-control" name="spouse_fname" id="spouse_fname"  >
                            </div>
                            <div class="form-group col-lg-2 col-sm-4">
                                <label for="arbo_barangay">MI</label>
                                <input type="text" class="form-control" name="spouse_mi" id="spouse_mi"  >
                            </div>

                            <div class="form-group col-lg-4 col-sm-4">
                                <label for="arb_cloa">Cloa #</label>
                                <input type="text" class="form-control" name="arb_cloa" id="arb_cloa"  >
                            </div>
                            <div class="form-group col-lg-2 col-sm-4">
                                <label for="arb_landsize">Landsize(ha) : </label>
                                <input type="number" min="0" class="form-control" name="arb_landsize" id="arb_landsize"  >
                            </div>


                            <div class="col-lg-12"><br>
                                <b>PART II : Membership to Agrarian Reform Beneficiaries Orgnization (ARBOs)</b> <br><br>
                            </div> <br>
                            <div class="form-group col-lg-12 col-sm-12">
                                <label for="arbo_barangay">Name of ARBO </label>
                                <input type="text" class="form-control" name="arb_arbo" id="arb_arbo"
                                    placeholder="(PLease Provide CORRECT Name of ARBO with ACRONYM (IF APPLICABLE) )" >
                            </div>
                            <div class="form-group col-lg-4 col-sm-4">
                                <label for="arb_position">Position</label>
                                <input type="text" class="form-control" name="arb_position" id="arb_position" >
                            </div>
                            <div class="form-group col-lg-4 col-sm-4">
                                <label for="date_of_mem">Date of Mem : </label>
                                <input type="text" class="form-control" name="date_of_mem" id="date_of_mem"  >
                            </div>
                            <div class="form-group col-lg-4 col-sm-4">
                                <label for="civil_status">STATUS</label>
                                <select class="form-control select_brdr_btm" name="status" id="status"
                                        style="border:0px;border-bottom:1px solid gray;">
                                    <option value="active">ACTIVE</option>
                                    <option value="inactive">INACTIVE</option>
                                </select>
                            </div>


                            </div>
                            </div>
                            </div>
                            <div class="box-footer clearfix">
                            <button type="button" onclick="plusDivs(+1, 2)" class="btn btn-success btn-sm pull-right next" id="jump1" form="add_francise_form">
                            Next <i class="fa fa-chevron-right"></i>
                            </button>
                            </div>
                            </div>
                            </div>
                            </div>
                            </div>


                            <!-- PAGE II -->

                            <!-- PAGE III -->
                            <div class="row">
                            <div class="col-lg-12">
                            <div class="form-next">
                            <div class="box box-success" style="width:97.5%;margin-left:1.2%;margin-right:1.2%;">

                            <!-- PAGE I -->


                            <!-- content -->
                            <div class="box-body">
                            <div style="padding-left:4%;padding-right:4%;">
                            <div class="row" id="asd">

                            <div class="col-lg-12"><br><br>
                            <b>PART III : Trainings Attended</b> <br><br>
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr style="background-color:#00a65a;padding:2px;color:white;">
                                        <th style="width:4%;"></th>
                                        <th style="width:86%;" class="text-center">A. For Coops / Non-Cops Trainings</th>
                                        <th style="width:10%;" class="text-center">Attended(/)</th>
                                    </tr>
                                </thead>
                                <?php
                                $i = 0;
                                $sql = 'SELECT * from arb_trainings';
                                $sql = $conn->prepare($sql);
                                $sql->execute();
                                $sql->bind_result($id,$trainings);
                                $sql->store_result();
                                if($sql->num_rows() > 0) {
                                    while($sql->fetch()) {
                                        $i++;
                                            echo "<tr class='trainings_cl'>
                                                    <td class='$id$id text-center $i'>$i</td>
                                                    <td class='$id$id'>$trainings</td>
                                                    <td class='text-center $id$id'><input name='arb_trainings[]'
                                                    onclick='addbg(this.value , this.value)' class='cust_check' type='checkbox' value='$id'></td>
                                                </tr>";
                                        }
                                }
                                ?>
                            </table><br><br>
                            </div>

                            <div class="col-lg-12">
                            <b>PART IV : Support Services Availed</b> <br><br>
                            </div>
                            <div class="col-lg-12">
                            <table class="table table-bordered">
                                <thead>
                                    <tr style="background-color:#00a65a;padding:2px;color:white;">
                                        <th style="" class="text-center">Credit</th>
                                        <th style="" class="text-center">Name Of Institution</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>a. Production</td>
                                        <td><input type="text" class="form-control" name="arb_name_prod" id="p4_1"></td>
                                        <td><input type="text" class="form-control" name="arb_prod_amount" id="p4_2"  ></td>
                                    </tr>

                                    <tr>
                                        <td>b. Micro</td>
                                        <td><input type="text" class="form-control" name="arb_name_micro" id="p4_3"  ></td>
                                        <td><input type="text" class="form-control" name="arb_micro_amount" id="p4_4"  ></td>
                                    </tr>

                                    <tr>
                                        <td>c. Livelihood</td>
                                        <td><input type="text" class="form-control" name="arb_name_lhood" id="p4_5"  ></td>
                                        <td><input type="text" class="form-control" name="arb_lhood_amount" id="p4_6"  ></td>
                                    </tr>
                                </tbody>
                            </table>
                            </div>
                            </div>
                            </div>
                            </div>
                            <div class="box-footer clearfix">
                            <div class="btn-group pull-right">
                            <button type="button" onclick="plusDivs(-1, 1)" class="btn btn-sm btn-primary" style="background-color:green">
                            <i class="fa fa-chevron-left"></i> Previous
                            </button>
                            <button type="button" onclick="plusDivs(+1, 3)" class="btn btn-success btn-sm pull-right next" id="jump2" form="add_francise_form">
                            Next <i class="fa fa-chevron-right"></i>
                            </button>
                            </div>
                            </div>
                            </div>
                            </div>



                            </div>
                            </div>

                            <div class="row">
                            <div class="col-lg-12">
                            <div class="form-next">
                            <div class="box box-success" style="width:97.5%;margin-left:1.2%;margin-right:1.2%;">

                            <!-- PAGE I -->


                            <!-- content -->
                            
                            <br><br>
                            <div class="box-body">
                            <div style="padding-left:4%;padding-right:4%;">
                            <div class="row">
                            <div class="col-lg-12">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead class="bg-success-custom">
                                        <tr>
                                            <th colspan="6" style="padding:0px;"><center style="background-color:#00a65a;padding:2px;color:white;">
                                        <h5><b>PROGRAMS ACCESSED FROM DAR</b></h5></center></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th style="width: 10px">Code</th>
                                            <th class="text-center">Is your organization a beneficiary of [mention program]?</th>
                                            <th style="width:10px;">Yes</th>
                                        </tr>
                                        <tr>
                                            <td colspan="3"style="background-color:rgb(189, 255, 189);" class="text-center" id="79"><strong>Agrarian Reform Community Connectivity and Economic Support Services</strong></td>
                                        </tr>

                                        <?php
                                        $qid = array(79, 95, 96, 97, 98);
                                        $sql_qid = $conn->prepare('SELECT * from arbo_sub_intervention where main_id = ?');
                                        $i = 0;

                                        $sql_qid->bind_param('i', $qid[0]);
                                        $sql_qid->execute();
                                        $sql_qid->bind_result($id, $description, $q79_id);
                                        $sql_qid->store_result();
                                        if ($sql_qid->num_rows() > 0) {
                                        while ($sql_qid->fetch()) {
                                        $i++;
                                        echo '<tr class="part5_cl">
                                        <td class="'.$id.'">' . $i . '</td>
                                        <td class="'.$id.'">' . $description . '</td>
                                        <td class="'.$id.'"><input type="checkbox" onclick="addbg(this.value, 0)" value="' . $id . '" name="q79[]"/></td>
                                        </tr>';
                                        }
                                        }
                                        ?>
                                        <tr>
                                            <td colspan="3"style="background-color:rgb(189, 255, 189);" class="text-center" id="95"><strong>Partnership Development Projects</strong></td>
                                        </tr>
                                        <?php
                                        $i = 0;
                                        $sql_qid->bind_param('i', $qid[1]);
                                        $sql_qid->execute();
                                        $sql_qid->bind_result($id, $description, $q95_id);
                                        $sql_qid->store_result();
                                        if ($sql_qid->num_rows() > 0) {
                                        while ($sql_qid->fetch()) {
                                        $i++;
                                        echo '<tr class="part5_cl">
                                        <td class="'.$id.'">' . $i . '</td>
                                        <td class="'.$id.'">' . $description . '</td>
                                        <td class="'.$id.'"><input type="checkbox" onclick="addbg(this.value, 0)" value="' . $id . '" name="q95[]"/></td>
                                        </tr>';
                                        }
                                        }
                                        ?>
                                        <tr>
                                            <td colspan="3"style="background-color:rgb(189, 255, 189);" class="text-center" id="96"><strong> Foreign Assisted Projects</strong></td>
                                        </tr>
                                        <?php
                                        $i = 0;
                                        $sql_qid->bind_param('i', $qid[2]);
                                        $sql_qid->execute();
                                        $sql_qid->bind_result($id, $description, $q96_id);
                                        $sql_qid->store_result();
                                        if ($sql_qid->num_rows() > 0) {
                                        while ($sql_qid->fetch()) {
                                        $i++;
                                        echo '<tr class="part5_cl">
                                        <td class="'.$id.'">' . $i . '</td>
                                        <td class="'.$id.'">' . $description . '</td>
                                        <td class="'.$id.'"><input type="checkbox" onclick="addbg(this.value, 0)" value="' . $id . '" name="q96[]"/></td>
                                        </tr>';
                                        }
                                        }
                                        ?>
                                        <tr>
                                            <td colspan="3"style="background-color:rgb(189, 255, 189);" class="text-center" id="97"><strong> Microfinance and Credit Programs</strong></td>
                                        </tr>
                                        <?php
                                        $i = 0;
                                        $sql_qid->bind_param('i', $qid[3]);
                                        $sql_qid->execute();
                                        $sql_qid->bind_result($id, $description, $q97_id);
                                        $sql_qid->store_result();
                                        if ($sql_qid->num_rows() > 0) {
                                        while ($sql_qid->fetch()) {
                                        $i++;
                                        echo '<tr class="part5_cl">
                                        <td class="'.$id.'">' . $i . '</td>
                                        <td class="'.$id.'">' . $description . '</td>
                                        <td class="'.$id.'"><input type="checkbox" value="' . $id . '" onclick="addbg(this.value, 0)" name="q97[]"/></td>
                                        </tr>';
                                        }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <tbody>
                                            <tr>
                                                <td colspan="12"style="background-color:rgb(189, 255, 189);" class="text-center" id="98"><strong> Partner Agencies</strong></td>
                                            </tr>
                                            <?php
                                            $i = 0;
                                            $sql_qid->bind_param('i', $qid[4]);
                                            $sql_qid->execute();
                                            $sql_qid->bind_result($id, $description, $q98_id);
                                            $sql_qid->store_result();
                                            if ($sql_qid->num_rows() > 0) {
                                            while ($sql_qid->fetch()) {
                                            $i++;
                                            echo '<tr class="part5_cl">
                                            <td class="'.$id.' p">' . $i . '</td>
                                            <td class="'.$id.' p">' . $description . '</td>
                                            <td class="'.$id.' p"><input style="background-color:rgba(255, 255, 255, .0);" class="select_brdr_btm" type="text" id="' . $id . '" placeholder="&nbsp;&nbsp;&nbsp;specify" disabled name="q98_spec[]"/></td>
                                            <td class="'.$id.' p"><input type="checkbox" onclick="enable(this.value)" value="' . $id . '" name="q98[]"/></td>
                                            <td class="'.$id.' p"><input type="hidden" value="' . $id . ' name="q98_spec_id[]"> </td>
                                            </tr>';
                                            }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                            </div>
                            <div class="col-lg-6">
                            <div class="row">
                                <div class="col-lg-6 pull-left">
                                    <label for="attestedby">Attested By: </label>
                                    <input style="background-color:rgba(255,255,255,.2);" readonly type="text" class="form-control" name="attestedby" id="attestedby">
                                </div>
                            </div>

                            </div>
                            <div class="col-lg-6">
                            <div class="row">
                                <div class="col-lg-6 pull-right">
                                    <label for="interviewedby">Interviewed By: </label>
                                    <input style="background-color:rgba(255,255,255,.2);" readonly type="text" class="form-control" value="<?php echo $user ?>" name="interviewedby" id="interviewedby"  >
                                </div>
                            </div>
                            </div>

                            <div class="col-lg-12 text-center">
                            <br><br>
                            <button type="submit" name="save" id="save" disabled class="btn btn-success" >Save</button><br><br>
                            </div>
                            </div>
                            </div>
                            </form>
                                    </div>
                                    <div class="box-footer clearfix">
                                        <div class="btn-group pull-right">
                                            <button type="button" onclick="plusDivs(-1, 2)" class="btn btn-sm btn-primary" style="background-color:green">
                                                <i class="fa fa-chevron-left"></i> Previous
                                            </button>
                                        </div>
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
        <script src="../public/js/arb_js.js"></script>
    <script>
       var arb_lname = undefined;
        var arb_fname = undefined;
        var arb_arbo = undefined;
        var arb_cloa = undefined;
        var land_size = undefined;
        var p1 = p2 = p3 = p4 = p5 = p6 = undefined;
        var ps_fl = undefined;
        var train_count = 0;
        var p5_count = 0;
        var fpage = 0;
        var fname = undefined;
        var lname = undefined;
        var mname = undefined;

        function targetz(l, m) {
            showDivs(slideIndex = l, m);
            clicked_con();
        }

        $(document).ready(function() {
            arb_lname = $('#arb_lname').val();
            arb_fname = $('#arb_fname').val();
            arb_arbo = $('#arb_arbo').val();
            arb_cloa = $('#arb_cloa').val();
            arb_landsize = $('#arb_landsize').val();
            p5_count = $('.part5_cl td').find('.checked_cl_p5').length;
            train_count = $('.trainings_cl').find('.checked_cl').length;

            if((arb_lname != '' && arb_fname != '' && arb_arbo != '' && arb_cloa != ''  && arb_landsize != '')) {
                $('#jump1').removeAttr('disabled' , 'disabled');
            } else {
                $('#jump1').attr('disabled' , 'disabled');
            }
            clicked_con();
            $('#attestedby').val($('#arb_lname').val() + ' ' + $('#arb_fname').val() + ' ' + $('#arb_mi').val());
        });

        $('#arb_lname, #arb_fname , #arb_mi, #arb_arbo ,#arb_cloa, #arb_landsize').keyup(function() {
            arb_lname = $('#arb_lname').val();
            arb_fname = $('#arb_fname').val();
            arb_arbo = $('#arb_arbo').val();
            arb_cloa = $('#arb_cloa').val();
            arb_landsize = $('#arb_landsize').val();
            // checkArb();
            clicked_con();
            if((arb_lname != '' && arb_fname != '' && arb_arbo != '' && arb_cloa != ''  && arb_landsize != '')) {
                $('#jump1').removeAttr('disabled' , 'disabled');
            } else {
                $('#jump1').attr('disabled' , 'disabled');
            }

        });

        $('.trainings_cl input[type="checkbox"]').click(function() {
            $(this).toggleClass('checked_cl');
                train_count = $('.trainings_cl').find('.checked_cl').length;
                clicked_con();
        });
        
        $('.part5_cl input[type="checkbox"]').click(function() {
            $(this).toggleClass('checked_cl_p5');
            p5_count = $('.part5_cl td').find('.checked_cl_p5').length;
            clicked_con();
        });

        $('#jump1, #jump2, #jump3').click(function() {
            clicked_con();
        });

        $('#jump1, #jump2, #jump3').keyup(function() {
            clicked_con();
        });

        function clicked_con() {
            checkArb();
            ps_fl = 0;
            fpage = 0;
            p1 = $('#p4_1').val();
            p2 = $('#p4_2').val();
            p3 = $('#p4_3').val();
            p4 = $('#p4_4').val();
            p5 = $('#p4_5').val();
            p6 = $('#p4_6').val();

            if((p1 != '' && p2 != '') || (p3 != '' && p4 != '') || (p5 != '' && p6 != '')) {
                ps_fl = 1;
            }
            if((arb_lname != '' && arb_fname != '' && arb_arbo != '' && arb_cloa != ''  && arb_landsize != '')) {
                fpage = 1;
            }

            if(((train_count > 0 || ps_fl == 1) || (p5_count > 0)) && (fpage == 1)) {
                console.log('s1');
                $('#save').removeAttr('disabled');
            } else {
                console.log('s3');
                $('#save').attr('disabled','disabled');
            }
            console.log(`psfl ${ps_fl} fpage ${fpage} traincount ${train_count} p5 count ${p5_count}`);
        }

        function checkArb() {
            arb_lname = $('#arb_lname').val();
            arb_fname = $('#arb_fname').val();
            mname = $('#arb_mi').val();

            $.post('controller/checkArb.php' , {
                fname : arb_fname,
                lname : arb_lname,
                mname : mname,
                arb_id : 0
            } , function(data, status) {
                console.log(data + ' ' + status);
                if(data == 'false') {
                    $('.error_mess').html('<span class="ifError"><b>ARB Already Recorded!</b></span>');
                    $('#jump1').attr('disabled','disabled');
                    console.log('ss1');
                } else {
                    $('.ifError').remove();
                    // $('#save').removeAttr('disabled');
                    console.log('ss2');
                }
            });
        }
    </script>
    </body>
</html>
<?php } else {
        header('location:../index.php');
}?>