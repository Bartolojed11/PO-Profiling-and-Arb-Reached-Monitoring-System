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
            .addbgcolor {
                background-color:rgba(212, 204, 204, .5);
                font-weight:bold;
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
                $arb_id = isset($_GET['id']) ? $_GET['id'] : 0;
                $sql = "SELECT arb.city_id, arb.brgy_id, arb_pos.description, arb.fname, arb.lname, arb.mi, arb.gender, arb.bdate,arb.spouse_fname,
                arb.spouse_lname, arb.spouse_mi, arb.cloa_num, arb.land_size, arb.date_of_mem, arb.attested_by,
                arb.interviewed_by, arb.civil_status, arb.arb_status , arbo.arbo_name ,city.city, brgy.brgy
                FROM arb_information as arb
                inner join city on city.id = arb.city_id
                inner join barangay as brgy on brgy.id = arb.brgy_id
                inner join arb_org as arbo on arbo.id = arb.arbo_id
                left join arbo_position_type as arb_pos on arb.pos_id = arb_pos.id
                WHERE arb.id = ?";

                $sql = $conn->prepare($sql);
                $sql->bind_param('i', $arb_id);
                $sql->execute();
                $sql->bind_result($arb_cid, $arb_bid, $arb_position, $arb_fname, $arb_lname, $arb_mi, $arb_gender, $arb_bdate, $spouse_fname, $spouse_lname, $spouse_mi, $arb_cloa,
                $arb_landsize, $date_of_mem, $attestedby, $interviewedby, $civil_status, $status, $arbo, $city, $brgy);
                $sql->store_result();
                $sql->num_rows();
                $sql->fetch();
                $get_city = $city;

                $page = 'arb-reached';
                include 'inc/navbar.php';
                include 'inc/sidebar.php';
            ?>
            <div class="content-wrapper container-fluid" >
                <section class="content-header">
                    &nbsp;&nbsp;&nbsp;&nbsp;<a href="arb-reached.php"><button class="btn btn-success btn-sm">
                    <i class="fa fa-arrow-circle-left"></i> Back</button></a>
                    <span style="font-size:20px;">ARB REACHED FORM</span>
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

                                    <br> <br>
                                    
                                    <div class="box-body">
                                    <div style="padding-left:4%;padding-right:4%;">
                                        <div class="row">
                                       

                                            <form action="controller/arb-update-process.php" method="post" novalidate>

                                                <div class="form-group col-lg-6 col-sm-6">
                                                    <label for="arb_lname">Municipality</label>
                                                    <input type="hidden" name="arb_id" id="arb_id" value="<?php echo $arb_id;?>">
                                                    <select class="form-control" id="arb_municipal"
                                                        name="arb_municipal" style="border:0px;border-bottom:1px solid gray;" required onchange="show_barangay()">
                                                        <?php
                                                            echo "<option value='$arb_cid'>$get_city</option>";
                                                            $sql = 'SELECT id,city FROM city WHERE city != ? ORDER BY city ASC';
                                                            $sql = $conn->prepare($sql);
                                                            $sql->bind_param('s',$get_city);
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
                                                    <label for="arb_lname">BARANGAY</label>
                                                        <input type="hidden" name="upd_bid" id="arb_bid" value="<?php echo $arb_bid ; ?>">
                                                        <select style="border:0px;border-bottom:1px solid gray;" class="form-control" id="arb_barangay" name="arb_barangay" required >
                                                            
                                                        </select><br>
                                                </div>

                                            <div class="col-lg-12">
                                            <b>PART I : ARB Information</b> &nbsp;&nbsp;&nbsp;<span class="error_mess">A</span> <br><br>
                                            <b>NAME OF ARB</b>
                                            </div> <br>
                                            <div class="form-group col-lg-4 col-sm-4">
                                                    <label for="arb_lname">Last Name</label>
                                                    <input type="text" class="form-control" value="<?php echo $arb_lname ; ?>"  name="arb_lname" id="arb_lname"  >
                                            </div>
                                            <div class="form-group col-lg-4 col-sm-4">
                                                    <label for="arb_fname">First Name</label>
                                                    <input type="text" class="form-control" value="<?php echo $arb_fname ; ?>" name="arb_fname" id="arb_fname"  >
                                            </div>
                                            <div class="form-group col-lg-2 col-sm-4">
                                                    <label for="arbo_barangay">MI</label>
                                                    <input type="text" class="form-control" value="<?php echo $arb_mi ; ?>" name="arb_mi" id="arb_mi"  >
                                            </div>
                                            <div class="form-group col-lg-2 col-sm-2">
                                                    <label for="gender">Gender</label>
                                                    <input type="text" class="form-control" value="<?php echo $arb_gender = $arb_gender == 'F' ? 'Female' : 'Male' ; ?>" name="gender" id="gender"  >
                                            </div>

                                            <div class="form-group col-lg-4 col-sm-4">
                                                    <label for="civil_status">Civil Status</label>
                                                    <select class="form-control select_brdr_btm" name="civil_status" id="civil_status"
                                                            style="border:0px;border-bottom:1px solid gray;">
                                                        <?php
                                                            echo "<option value='$civil_status'>$civil_status</option>";
                                                            $sql = 'SELECT status from civil_status where status != ?';
                                                            $sql = $conn->prepare($sql); 
                                                            $sql->bind_param('s',$civil_status);
                                                            $sql->execute();
                                                            $sql->bind_result($cstatus);
                                                            $sql->store_result();
                                                            if($sql->num_rows() > 0) {
                                                                while($sql->fetch()) {
                                                                    echo "<option value='$cstatus'>$cstatus</option>";
                                                                }
                                                            }
                                                            ?>
                                                    </select>
                                                </div>

                                            <div class="form-group col-lg-4 col-sm-4">
                                                    <label for="arbo_barangay">Birthdate</label>
                                                    <input type="date" class="form-control" onblur="set_age()"
                                                    max="2005-01-01" min="1880-01-01" value="<?php echo $arb_bdate ; ?>" name="arb_bdate" id="arb_bdate"  >
                                            </div>
                                            <div class="form-group col-lg-2 col-sm-4">
                                                    <label for="arbo_barangay">Age : </label>
                                                    <input type="text" disabled class="form-control" name="age" id="age">
                                            </div>

                                            <div class="col-lg-12">
                                            <b>NAME OF SPOUSE</b>
                                            </div> <br><br>
                                            <div class="form-group col-lg-4 col-sm-4">
                                                    <label for="arbo_barangay">Last Name</label>
                                                    <input type="text" class="form-control" name="spouse_lname" value="<?php echo $spouse_lname ; ?>" id="spouse_lname"  >
                                            </div>
                                            <div class="form-group col-lg-4 col-sm-4">
                                                    <label for="arbo_barangay">First Name</label>
                                                    <input type="text" class="form-control" name="spouse_fname" value="<?php echo $spouse_fname ; ?>" id="spouse_fname"  >
                                            </div>
                                            <div class="form-group col-lg-2 col-sm-4">
                                                    <label for="arbo_barangay">MI</label>
                                                    <input type="text" class="form-control" name="spouse_mi" value="<?php echo $spouse_mi ; ?>" id="spouse_mi"  >
                                            </div>
                                            
                                            <div class="form-group col-lg-4 col-sm-4">
                                                    <label for="arb_cloa">Cloa #</label>
                                                    <input type="text" class="form-control" value="<?php echo $arb_cloa ; ?>" name="arb_cloa" id="arb_cloa"  >
                                            </div>
                                            <div class="form-group col-lg-2 col-sm-4">
                                                    <label for="arb_landsize">Landsize(ha) : </label>
                                                    <input type="number" min="0" class="form-control"  value="<?php echo $arb_landsize ; ?>" name="arb_landsize" id="arb_landsize"  >
                                            </div>

                                            
                                            <div class="col-lg-12"><br>
                                            
                                            <b>PART II : Membership to Agrarian Reform Beneficiaries Orgnization (ARBOs)</b> <br><br>
                                            </div> <br>
                                            <div class="form-group col-lg-12 col-sm-12">
                                                    <label for="arbo_barangay">Name of ARBO </label>
                                                    <input type="text" class="form-control" value="<?php echo $arbo ; ?>" name="arb_arbo" id="arb_arbo"
                                                    placeholder="(PLease Provide CORRECT Name of ARBO with ACRONYM (IF APPLICABLE) )" >
                                            </div>
                                            <div class="form-group col-lg-4 col-sm-4">
                                                    <label for="arb_position">Position</label>
                                                    <input type="text" class="form-control" value="<?php echo $arb_position ; ?>" name="arb_position" id="arb_position" >
                                            </div>
                                            <div class="form-group col-lg-4 col-sm-4">
                                                    <label for="date_of_mem">Date of Mem : </label>
                                                    <input type="text" class="form-control" value="<?php echo $date_of_mem ; ?>" name="date_of_mem" id="date_of_mem"  >
                                            </div>
                                            <div class="form-group col-lg-4 col-sm-4">
                                                    <label for="status">STATUS</label>
                                                    <select class="form-control" name="status" id="status" style="border:0px;border-bottom:1px solid gray;">
                                                    <?php
                                                        if($status == 'active') {
                                                            echo "<option value='active'>ACTIVE</option>
                                                                <option value='inactive'>INACTIVE</option>";
                                                        } else {
                                                            echo "<option value='inactive'>INACTIVE</option>
                                                                <option value='active'>ACTIVE</option>";
                                                        }
                                                    ?>
                                                    </select>
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
</div>

                    <!-- PAGE II -->

                    <!-- PAGE III -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-next">
                                <div class="box box-success" style="width:97.5%;margin-left:1.2%;margin-right:1.2%;">

                                    <!-- PAGE I -->


                                    <!-- content -->
                                    
                                    <br><br>
                                    <div class="box-body">
                                    <div style="padding-left:4%;padding-right:4%;">
                                        <div class="row" id="asd">

                                            <div class="col-lg-12">
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
                                                                    $flag = 0;
                                                                    $j = 0;
                                                                    $acq_train_id = array();
                                                                    $arb_trainings = array();
                                                                    $arb_trainings_id = array();

                                                                    $sql = 'SELECT arb_train.id
                                                                    from arb_trainings_attended as acq_train
                                                                    inner join arb_trainings as arb_train on arb_train.id = acq_train.trainings_id
                                                                    WHERE acq_train.arb_id = ?';
                                                                    $sql = $conn->prepare($sql);
                                                                    $sql->bind_param('i',$arb_id);
                                                                    $sql->execute();
                                                                    $sql->bind_result($id);
                                                                    $sql->store_result();
                                                                    if($sql->num_rows() > 0) {
                                                                        while($sql->fetch()) {
                                                                            array_push($acq_train_id,$id);
                                                                        }
                                                                    }

                                                                    $sql = 'SELECT * from arb_trainings';
                                                                    $sql = $conn->prepare($sql);
                                                                    $sql->execute();
                                                                    $sql->bind_result($id,$desc);
                                                                    $sql->store_result();
                                                                    if($sql->num_rows() > 0) {
                                                                        while($sql->fetch()) {
                                                                            array_push($arb_trainings_id,$id);
                                                                            array_push($arb_trainings, $desc);
                                                                        }
                                                                    }

                                                                    for($i = 0 ; $i < count($arb_trainings_id); $i++) {
                                                                        if(count($acq_train_id) > 0) {
                                                                            for($j = 0; $j < count($acq_train_id); $j++) {
                                                                                if($acq_train_id[$j] == $arb_trainings_id[$i]) {
                                                                                    $flag++;
                                                                                    echo "<tr class='trainings_cl'>
                                                                                            <td class='addbgcolor text-center $arb_trainings_id[$i]$arb_trainings_id[$i]'>".($i+1)."</td>
                                                                                            <td class='addbgcolor $arb_trainings_id[$i]$arb_trainings_id[$i]'>$arb_trainings[$i]</td>
                                                                                            <td class='addbgcolor text-center $arb_trainings_id[$i]$arb_trainings_id[$i]'><input name='arb_trainings[]' checked class='cust_check checked_cl' type='checkbox'
                                                                                                value='$arb_trainings_id[$i]' onclick='addbg(this.value,this.value)'></td>
                                                                                          </tr>";
                                                                                } else {
                                                                                    if($flag > 0) {
                                                                                        if($j == (count($acq_train_id) - 1 ) && $arb_trainings_id[$i] != $acq_train_id[$flag-1]) {
                                                                                            echo "<tr class='trainings_cl'>
                                                                                                    <td class='text-center  $arb_trainings_id[$i]$arb_trainings_id[$i] text-center $i'>".($i+1)."</td>
                                                                                                    <td class='$arb_trainings_id[$i]$arb_trainings_id[$i]'>$arb_trainings[$i]</td>
                                                                                                    <td class='text-center $arb_trainings_id[$i]$arb_trainings_id[$i]'><input name='arb_trainings[]' onclick='addbg(this.value,this.value)'  class='cust_check' type='checkbox' value='$arb_trainings_id[$i]'></td>
                                                                                                </tr>";
                                                                                            }
                                                                                        }
                                                                                        else if ($flag == 0){
                                                                                            if($j == (count($acq_train_id) - 1 ) && $arb_trainings_id[$i] != $acq_train_id[$flag]) {
                                                                                                echo '<tr class="trainings_cl">
                                                                                                    <td class="text-center '.$arb_trainings_id[$i].$arb_trainings_id[$i].'">' . ($i+1) . '</td>
                                                                                                    <td class="'.$arb_trainings_id[$i].$arb_trainings_id[$i].'">' . $arb_trainings[$i] . '</td>
                                                                                                    <td class="text-center '.$arb_trainings_id[$i].$arb_trainings_id[$i].'">
                                                                                                    <input type="checkbox" value="'.$arb_trainings_id[$i].'" onclick="addbg(this.value,this.value)" name="arb_trainings[]"/></td> 
                                                                                                </tr>';
                                                                                            }
                                                                                        }
                                                                                }
                                                                            }
                                                                        } else {
                                                                            echo "<tr class='trainings_cl'>
                                                                                    <td class='text-center $arb_trainings_id[$i]$arb_trainings_id[$i]'>".($i+1)."</td>
                                                                                    <td class='$arb_trainings_id[$i]$arb_trainings_id[$i]'>$arb_trainings[$i]</td>
                                                                                    <td class='text-center $arb_trainings_id[$i]$arb_trainings_id[$i]'><input name='arb_trainings[]' onclick='addbg(this.value,this.value)' class='cust_check' type='checkbox'
                                                                                        value='$arb_trainings_id[$i]'></td>
                                                                                </tr>";
                                                                        }
                                                                    }
                                                                ?>
                                                            </table><br><br>
                                                        </div>

                                                        <div class="col-lg-12">
                                                            <b>PART IV : Support Services Availed</b> <br><br>
                                                        </div>
                                                        <?php
                                                            $ssa = array('production', 'micro', 'livelihood');
                                                            $sql = 'SELECT institution, amount from arb_support_serv_av where arb_id = ? and description = ?';
                                                            $sql = $conn->prepare($sql);
                                                            $sql->bind_param('is', $arb_id,$ssa[0]);
                                                            $sql->execute();
                                                            $sql->bind_result($instite,$amount);
                                                            $sql->store_result();
                                                            $sql->fetch();

                                                        ?>
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
                                                                    <td><input type="text" class="form-control" name="arb_name_prod" value="<?php echo $instite ; ?>" id="p4_1"></td>
                                                                    <td><input type="text" class="form-control" name="arb_prod_amount" value="<?php echo $amount ; ?>" id="p4_2"  ></td>
                                                                </tr>
                                                                <?php
                                                                    $sql->bind_param('is', $arb_id,$ssa[1]);
                                                                    $sql->execute();
                                                                    $sql->bind_result($instite,$amount);
                                                                    $sql->store_result();
                                                                    $sql->fetch();
                                                                ?>
                                                                <tr>
                                                                    <td>b. Micro</td>
                                                                    <td><input type="text" class="form-control" value="<?php echo $instite ; ?>" name="arb_name_micro" id="p4_3"  ></td>
                                                                    <td><input type="text" class="form-control" value="<?php echo $amount ; ?>" name="arb_micro_amount" id="p4_4"  ></td>
                                                                </tr>
                                                                <?php
                                                                    $sql->bind_param('is', $arb_id,$ssa[2]);
                                                                    $sql->execute();
                                                                    $sql->bind_result($instite,$amount);
                                                                    $sql->store_result();
                                                                    $sql->fetch();
                                                                ?>
                                                                <tr>
                                                                    <td>c. Livelihood</td>
                                                                    <td><input type="text" class="form-control" value="<?php echo $instite ; ?>" name="arb_name_lhood" id="p4_5"  ></td>
                                                                    <td><input type="text" class="form-control" value="<?php echo $amount ; ?>" name="arb_lhood_amount" id="p4_6"  ></td>
                                                                </tr>
                                                        </tbody>
                                                        </table> <br><br>
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
                                                    $flag = 0;
                                                    $qid = array(79,95,96,97,98);
                                                

                                                    $sql_show_arbo_inter = $conn->prepare('SELECT sub_id FROM arb_acquired_intervention where main_id = ? and arb_id = ?');
                                                    $sql_qid = $conn->prepare('SELECT * FROM arbo_sub_intervention where main_id = ?');
                                                    $sql_show_arbo_spec = $conn->prepare('SELECT sub_id, specify_intervention 
                                                        FROM arb_acquired_intervention where main_id = ? and arb_id = ? and specify_intervention is not null');

                                                    $q79_desc = array();
                                                    $q79_id = array();
                                                    $arbo_inter_qid = array();
                                                    $flag = 0;

                                                    $sql_show_arbo_inter->bind_param('ii', $qid[0] , $arb_id);
                                                    $sql_show_arbo_inter->execute();
                                                    $sql_show_arbo_inter->bind_result($id);
                                                    $sql_show_arbo_inter->store_result();
                                                    if($sql_show_arbo_inter->num_rows() > 0) {
                                                        while($sql_show_arbo_inter->fetch()) {
                                                            array_push($arbo_inter_qid,$id);
                                                        }
                                                    }
                                                    $sql_qid->bind_param('i', $qid[0]);
                                                    $sql_qid->execute();
                                                    $sql_qid->bind_result($id, $desc , $main_id);
                                                    $sql_qid->store_result();
                                                    if($sql_qid->num_rows() > 0) {
                                                        while($sql_qid->fetch()) {
                                                            array_push($q79_id,$id);
                                                            array_push($q79_desc,$desc);
                                                        }
                                                    }
                                                    
                                                    for($i = 0 ; $i < count($q79_id) ; $i++) {
                                                        if(count($arbo_inter_qid) > 0) {
                                                            for($j = 0 ; $j < count($arbo_inter_qid) ; $j++) {
                                                                if($q79_id[$i] == $arbo_inter_qid[$j]) {
                                                                    $flag++;
                                                                    echo '<tr class="part5_cl">
                                                                            <td class="'.$q79_id[$j].' addbgcolor">' . ($i+1) . '</td>
                                                                            <td class="'.$q79_id[$j].' addbgcolor">' . $q79_desc[$i] . '</td>
                                                                            <td class="'.$q79_id[$j].' addbgcolor">
                                                                            <input type="checkbox" checked  class="checked_cl_p5" onclick="addbg(this.value, 0)" value="'.$q79_id[$j].'" name="q79[]"/></td> 
                                                                        </tr>';
                                                                } else {
                                                                    if($flag > 0) {
                                                                        if($j == (count($arbo_inter_qid) - 1 ) && $q79_id[$i] != $arbo_inter_qid[$flag-1]) {
                                                                            echo '<tr class="part5_cl">
                                                                                <td class="'.$q79_id[$i].'">' . ($i+1) . '</td>
                                                                                <td class="'.$q79_id[$i].'">' . $q79_desc[$i] . '</td>
                                                                                <td class="'.$q79_id[$i].'"><input type="checkbox"  onclick="addbg(this.value, 0)" value="'.$q79_id[$i].'" name="q79[]"/></td> 
                                                                            </tr>';
                                                                        }
                                                                    } else if ($flag == 0){
                                                                        if($j == (count($arbo_inter_qid) - 1 ) && $q79_id[$i] != $arbo_inter_qid[$flag]) {
                                                                            echo '<tr class="part5_cl">
                                                                                <td class="'.$q79_id[$i].'">' . ($i+1) . '</td>
                                                                                <td class="'.$q79_id[$i].'">' . $q79_desc[$i] . '</td>
                                                                                <td class="'.$q79_id[$i].'"><input type="checkbox" onclick="addbg(this.value, 0)"  value="'.$q79_id[$i].'" name="q79[]"/></td> 
                                                                            </tr>';
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        } else {
                                                            echo '<tr class="part5_cl">
                                                                    <td class="'.$q79_id[$i].'" >' . ($i+1) . '</td>
                                                                    <td class="'.$q79_id[$i].'">' . $q79_desc[$i] . '</td>
                                                                    <td class="'.$q79_id[$i].'"><input type="checkbox"   value="'.$q79_id[$i].'" onclick="addbg(this.value, 0)" name="q79[]"/></td> 
                                                                </tr>';
                                                        }
                                                        
                                                    }
                                                    ?>
                                                    <tr>
                                                        <td colspan="3"style="background-color:rgb(189, 255, 189);" class="text-center" id="95"><strong>Partnership Development Projects</strong></td>
                                                    </tr>
                                                    <?php
                                                    $q95_desc = array();
                                                    $q95_id = array();
                                                    $arbo_inter_qid = array();
                                                    $flag = 0;
                                                    $sql_show_arbo_inter->bind_param('ii', $qid[1] , $arb_id);
                                                    $sql_show_arbo_inter->execute();
                                                    $sql_show_arbo_inter->bind_result($id);
                                                    $sql_show_arbo_inter->store_result();
                                                    if($sql_show_arbo_inter->num_rows() > 0) {
                                                        while($sql_show_arbo_inter->fetch()) {
                                                            array_push($arbo_inter_qid,$id);
                                                        }
                                                    }
                                                    $sql_qid->bind_param('i', $qid[1]);
                                                    $sql_qid->execute();
                                                    $sql_qid->bind_result($id, $desc , $main_id);
                                                    $sql_qid->store_result();
                                                    if($sql_qid->num_rows() > 0) {
                                                        while($sql_qid->fetch()) {
                                                            array_push($q95_id,$id);
                                                            array_push($q95_desc,$desc);
                                                        }
                                                    }
                                                    
                                                    for($i = 0 ; $i < count($q95_id) ; $i++) {
                                                        if(count($arbo_inter_qid) > 0) {
                                                            for($j = 0 ; $j < count($arbo_inter_qid) ; $j++) {
                                                                if($q95_id[$i] == $arbo_inter_qid[$j]) {
                                                                    $flag++;
                                                                    echo '<tr class="part5_cl">
                                                                            <td class="'.$q95_id[$j].' addbgcolor">' . ($i+1) . '</td>
                                                                            <td class="'.$q95_id[$j].' addbgcolor">' . $q95_desc[$i]  . '</td>
                                                                            <td class="'.$q95_id[$j].' addbgcolor">
                                                                            <input type="checkbox" checked class="checked_cl_p5"  value="'.$q95_id[$j].'" onclick="addbg(this.value, 0)" name="q95[]"/></td> 
                                                                        </tr>';
                                                                } else {
                                                                    if($flag > 0) {
                                                                        if($j == (count($arbo_inter_qid) - 1 ) && $q95_id[$i] != $arbo_inter_qid[$flag-1]) {
                                                                            echo '<tr class="part5_cl">
                                                                                <td class="'.$q95_id[$i].'">' . ($i+1) . '</td>
                                                                                <td class="'.$q95_id[$i].'">' . $q95_desc[$i] . '</td>
                                                                                <td class="'.$q95_id[$i].'"><input type="checkbox"   value="'.$q95_id[$i].'" onclick="addbg(this.value, 0)" name="q95[]"/></td> 
                                                                            </tr>';
                                                                        }
                                                                    } else if ($flag == 0){
                                                                        if($j == (count($arbo_inter_qid) - 1 ) && $q95_id[$i] != $arbo_inter_qid[$flag]) {
                                                                            echo '<tr class="part5_cl">
                                                                                <td class="'.$q95_id[$i].'">' . ($i+1) . '</td>
                                                                                <td class="'.$q95_id[$i].'">' . $q95_desc[$i] . '</td>
                                                                                <td class="'.$q95_id[$i].'"><input type="checkbox"   value="'.$q95_id[$i].'" onclick="addbg(this.value, 0)" name="q95[]"/></td> 
                                                                            </tr>';
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        } else {
                                                            echo '<tr class="part5_cl">
                                                                    <td class="'.$q95_id[$i].'">' . ($i+1) . '</td>
                                                                    <td class="'.$q95_id[$i].'">' . $q95_desc[$i] . '</td>
                                                                    <td class="'.$q95_id[$i].'"><input type="checkbox"   value="'.$q95_id[$i].'" onclick="addbg(this.value, 0)" name="q95[]"/></td> 
                                                                </tr>';
                                                        }
                                                        
                                                    }
                                                    ?>
                                                    <tr>
                                                        <td colspan="3"style="background-color:rgb(189, 255, 189);" class="text-center" id="96"><strong> Foreign Assisted Projects</strong></td>
                                                    </tr>
                                                    <?php
                                                    $q96_desc = array();
                                                    $q96_id = array();
                                                    $arbo_inter_qid = array();
                                                    $flag = 0;
                                                    $sql_show_arbo_inter->bind_param('ii', $qid[2] , $arb_id);
                                                    $sql_show_arbo_inter->execute();
                                                    $sql_show_arbo_inter->bind_result($id);
                                                    $sql_show_arbo_inter->store_result();
                                                    if($sql_show_arbo_inter->num_rows() > 0) {
                                                        while($sql_show_arbo_inter->fetch()) {
                                                            array_push($arbo_inter_qid,$id);
                                                        }
                                                    }
                                                    $sql_qid->bind_param('i', $qid[2]);
                                                    $sql_qid->execute();
                                                    $sql_qid->bind_result($id, $desc , $main_id);
                                                    $sql_qid->store_result();
                                                    if($sql_qid->num_rows() > 0) {
                                                        while($sql_qid->fetch()) {
                                                            array_push($q96_id,$id);
                                                            array_push($q96_desc,$desc);
                                                        }
                                                    }

                                                    for($i = 0 ; $i < count($q96_id) ; $i++) {
                                                        if(count($arbo_inter_qid) > 0) {
                                                            for($j = 0 ; $j < count($arbo_inter_qid) ; $j++) {
                                                                if($q96_id[$i] == $arbo_inter_qid[$j]) {
                                                                    $flag++;
                                                                    echo '<tr class="part5_cl">
                                                                            <td class="'.$q96_id[$i].' addbgcolor ">' . ($i+1) . '</td>
                                                                            <td class="'.$q96_id[$i].' addbgcolor ">' . $q96_desc[$i] . '</td>
                                                                            <td class="'.$q96_id[$i].' addbgcolor ">
                                                                            <input type="checkbox" checked class="checked_cl_p5"  value="'.$q96_id[$i].'" onclick="addbg(this.value,0)" name="q96[]"/></td> 
                                                                        </tr>';
                                                                } else {
                                                                    if($flag > 0) {
                                                                        if($j == (count($arbo_inter_qid) - 1 ) && $q96_id[$i] != $arbo_inter_qid[$flag-1]) {
                                                                            echo '<tr class="part5_cl">
                                                                                <td class="'.$q96_id[$i].'">' . ($i+1) . '</td>
                                                                                <td class="'.$q96_id[$i].'">' . $q96_desc[$i] . '</td>
                                                                                <td class="'.$q96_id[$i].'"><input type="checkbox"   value="'.$q96_id[$i].'" onclick="addbg(this.value,0)" name="q96[]"/></td> 
                                                                            </tr>';
                                                                        }
                                                                    } else if ($flag == 0){
                                                                        if($j == (count($arbo_inter_qid) - 1 ) && $q96_id[$i] != $arbo_inter_qid[$flag]) {
                                                                            echo '<tr class="part5_cl">
                                                                                <td class="'.$q96_id[$i].'">' . ($i+1) . '</td>
                                                                                <td class="'.$q96_id[$i].'">' . $q96_desc[$i] . '</td>
                                                                                <td class="'.$q96_id[$i].'"><input type="checkbox"   value="'.$q96_id[$i].'" onclick="addbg(this.value, 0)" name="q96[]"/></td> 
                                                                            </tr>';
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        } else {
                                                            echo '<tr class="part5_cl">
                                                                    <td class="'.$q96_id[$i].'">' . ($i+1) . '</td>
                                                                    <td class="'.$q96_id[$i].'">' . $q96_desc[$i] . '</td>
                                                                    <td class="'.$q96_id[$i].'"><input type="checkbox"   value="'.$q96_id[$i].'" onclick="addbg(this.value, 0)" name="q96[]"/></td> 
                                                                </tr>';
                                                        }
                                                        
                                                    }
                                                    ?>
                                                    <tr>
                                                        <td colspan="3"style="background-color:rgb(189, 255, 189);" class="text-center" id="97"><strong> Microfinance and Credit Programs</strong></td>
                                                    </tr>
                                                    <?php
                                                    $q97_desc = array();
                                                    $q97_id = array();
                                                    $arbo_inter_qid = array();
                                                    $flag = 0;
                                                    $sql_show_arbo_inter->bind_param('ii', $qid[3] , $arb_id);
                                                    $sql_show_arbo_inter->execute();
                                                    $sql_show_arbo_inter->bind_result($id);
                                                    $sql_show_arbo_inter->store_result();
                                                    if($sql_show_arbo_inter->num_rows() > 0) {
                                                        while($sql_show_arbo_inter->fetch()) {
                                                            array_push($arbo_inter_qid,$id);
                                                        }
                                                    }
                                                    $sql_qid->bind_param('i', $qid[3]);
                                                    $sql_qid->execute();
                                                    $sql_qid->bind_result($id, $desc , $main_id);
                                                    $sql_qid->store_result();
                                                    if($sql_qid->num_rows() > 0) {
                                                        while($sql_qid->fetch()) {
                                                            array_push($q97_id,$id);
                                                            array_push($q97_desc,$desc);
                                                        }
                                                    }

                                                    for($i = 0 ; $i < count($q97_id) ; $i++) {
                                                        if(count($arbo_inter_qid) > 0) {
                                                            for($j = 0 ; $j < count($arbo_inter_qid) ; $j++) {
                                                                if($q97_id[$i] == $arbo_inter_qid[$j]) {
                                                                    $flag++;
                                                                    echo '<tr class="part5_cl">
                                                                            <td class="'.$q97_id[$i].' addbgcolor ">' . ($i+1) . '</td>
                                                                            <td class="'.$q97_id[$i].' addbgcolor ">' . $q97_desc[$i] . '</td>
                                                                            <td class="'.$q97_id[$i].' addbgcolor ">
                                                                            <input type="checkbox" checked  class="checked_cl_p5" value="'.$q97_id[$i].'" onclick="addbg(this.value,0)" name="q97[]"/></td> 
                                                                        </tr>';
                                                                } else {
                                                                    if($flag > 0) {
                                                                        if($j == (count($arbo_inter_qid) - 1 ) && $q97_id[$i] != $arbo_inter_qid[$flag-1]) {
                                                                            echo '<tr class="part5_cl">
                                                                                <td class="'.$q97_id[$i].'">' . ($i+1) . '</td>
                                                                                <td class="'.$q97_id[$i].'">' . $q97_desc[$i] . '</td>
                                                                                <td class="'.$q97_id[$i].'"><input type="checkbox"   value="'.$q97_id[$i].'" onclick="addbg(this.value,0)" name="q97[]"/></td> 
                                                                            </tr>';
                                                                        }
                                                                    } else if ($flag == 0){
                                                                        if($j == (count($arbo_inter_qid) - 1 ) && $q97_id[$i] != $arbo_inter_qid[$flag]) {
                                                                            echo '<tr class="part5_cl">
                                                                                <td class="'.$q97_id[$i].'">' . ($i+1) . '</td>
                                                                                <td class="'.$q97_id[$i].'">' . $q97_desc[$i] . '</td>
                                                                                <td class="'.$q97_id[$i].'"><input type="checkbox"   value="'.$q97_id[$i].'" onclick="addbg(this.value,0)" name="q97[]"/></td> 
                                                                            </tr>';
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        } else {
                                                            echo '<tr class="part5_cl">
                                                                    <td class="'.$q97_id[$i].'">' . ($i+1) . '</td>
                                                                    <td class="'.$q97_id[$i].'">' . $q97_desc[$i] . '</td>
                                                                    <td class="'.$q97_id[$i].'"><input type="checkbox"   value="'.$q97_id[$i].'" onclick="addbg(this.value,0)"  name="q97[]"/></td> 
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
                                                        <td colspan="4"style="background-color:rgb(189, 255, 189);" class="text-center" id="98"><strong> Partner Agencies</strong></td>
                                                    </tr>
                                                        
                                                        <?php
                                                            $q98_desc = array();
                                                            $q98_id = array();
                                                            $arbo_inter_qid = array();
                                                            $arbo_inter_desc = array();
                                                            $arbo_inter_desc_id = array();
                                                            
                                                            $flag = 0;

                                                            $sql_qid->bind_param('i', $qid[4]);
                                                            $sql_qid->execute();
                                                            $sql_qid->bind_result($id, $desc , $main_id);
                                                            $sql_qid->store_result();
                                                            if($sql_qid->num_rows() > 0) {
                                                                while($sql_qid->fetch()) {
                                                                    array_push($q98_id,$id);
                                                                    array_push($q98_desc,$desc);
                                                                }
                                                            }

                                                            $sql_show_arbo_inter->bind_param('ii', $qid[4] , $arb_id);
                                                            $sql_show_arbo_inter->execute();
                                                            $sql_show_arbo_inter->bind_result($id);
                                                            $sql_show_arbo_inter->store_result();
                                                            if($sql_show_arbo_inter->num_rows() > 0) {
                                                                while($sql_show_arbo_inter->fetch()){
                                                                        array_push($arbo_inter_qid, $id);
                                                                    }
                                                                }

                                                                $sql_show_arbo_spec->bind_param('ii', $qid[4] , $arb_id);
                                                                $sql_show_arbo_spec->execute();
                                                                $sql_show_arbo_spec->bind_result($id,$arbo_specify);
                                                                $sql_show_arbo_spec->store_result();
                                                                if($sql_show_arbo_spec->num_rows() > 0) {
                                                                    while($sql_show_arbo_spec->fetch()){
                                                                        array_push($arbo_inter_desc , $arbo_specify);
                                                                        array_push($arbo_inter_desc_id, $id);
                                                                    }
                                                                }
                                                            
                                                            
                                                                $flag2 = 0 ; 
                                                                for($i = 0 ; $i < count($q98_id) ; $i++) {
                                                                    if(count($arbo_inter_qid) > 0) {
                                                                        for($j = 0 ; $j < count($arbo_inter_qid) ; $j++) {
                                                                            if($q98_id[$i] == $arbo_inter_qid[$j]) {
                                                                                $flag++;
                                                                                if(isset($arbo_inter_desc_id[$flag2]) && $arbo_inter_qid[$j] == $arbo_inter_desc_id[$flag2]) {
                                                                                    echo '<tr class="part5_cl">
                                                                                        <td class="'.$q98_id[$i].' addbgcolor ">' . ($i+1) . '</td>
                                                                                        <td class="'.$q98_id[$i].' addbgcolor ">' . $q98_desc[$i] . '</td>
                                                                                        <td class="'.$q98_id[$i].' addbgcolor "> <input type="text" style="background-color:rgba(255, 255, 255, .0);" id="'.$q98_id[$j].'" value="'.$arbo_inter_desc[$flag2].'" name="q98_spec[]" /></td>
                                                                                        <td class="'.$q98_id[$i].' addbgcolor ">
                                                                                        <input type="checkbox" class="checked_cl_p5" checked value="'.$q98_id[$i].'" onclick="enable(this.value)" name="q98[]"/></td>
                                                                                    </tr>';
                                                                                    $flag2++;
                                                                                } else {
                                                                                    echo '<tr class="part5_cl">
                                                                                        <td class="'.$q98_id[$i].'">' . ($i+1) . '</td>
                                                                                        <td class="'.$q98_id[$i].'">' . $q98_desc[$i] . '</td>
                                                                                        <td class="'.$q98_id[$i].'"><input type="text" style="background-color:rgba(255, 255, 255, .0);" id="'.$q98_id[$i].'" name="q98_spec[] "></td>
                                                                                        <td class="'.$q98_id[$i].'"><input type="checkbox" checked  value="'.$q98_id[$i].'" onclick="enable(this.value)" name="q98[]"/></td> 
                                                                                    </tr>';
                                                                                }
                                                                            } else {
                                                                                if($flag > 0) {
                                                                                    if($j == (count($arbo_inter_qid) - 1 ) && $q98_id[$i] != $arbo_inter_qid[$flag-1]) {
                                                                                        echo '<tr class="part5_cl">
                                                                                            <td class="'.$q98_id[$i].'">' . ($i+1) . '</td>
                                                                                            <td class="'.$q98_id[$i].'">' . $q98_desc[$i] . '</td>
                                                                                            <td class="'.$q98_id[$i].'"><input type="text" disabled style="background-color:rgba(255, 255, 255, .0);"  id="'.$q98_id[$i].'"   name="q98_spec[]" ></td>
                                                                                            <td class="'.$q98_id[$i].'"><input type="checkbox"  onclick="enable(this.value)" value="'.$q98_id[$i].'" name="q98[]"/></td> 
                                                                                        </tr>';
                                                                                    }
                                                                                } else if ($flag == 0){
                                                                                    if($j == (count($arbo_inter_qid) - 1 ) && $q98_id[$i] != $arbo_inter_qid[$flag]) {
                                                                                        echo '<tr class="part5_cl">
                                                                                            <td class="'.$q98_id[$i].'">' . ($i+1) . '</td>
                                                                                            <td class="'.$q98_id[$i].'">' . $q98_desc[$i] . '</td>
                                                                                            <td class="'.$q98_id[$i].'"><input type="text" disabled style="background-color:rgba(255, 255, 255, .0);" id="'.$q98_id[$i].'"   name="q98_spec[]"  ></td>
                                                                                            <td class="'.$q98_id[$i].'"><input type="checkbox"  onclick="enable(this.value)" value="'.$q98_id[$i].'" name="q98[]"/></td> 
                                                                                        </tr>';
                                                                                    }
                                                                                }
                                                                            }
                                                                        }
                                                                    } else {
                                                                        echo '<tr class="part5_cl">
                                                                                <td class="'.$q98_id[$i].'">' . ($i+1) . '</td>
                                                                                <td class="'.$q98_id[$i].'">' . $q98_desc[$i] . '</td>
                                                                                <td class="'.$q98_id[$i].'"><input type="text" disabled style="background-color:rgba(255, 255, 255, .0);" id="'.$q98_id[$i].'"   name="q98_spec[]" ></td>
                                                                                <td class="'.$q98_id[$i].'"><input type="checkbox" onclick="enable(this.value)"  value="'.$q98_id[$i].'" name="q98[]"/></td> 
                                                                            </tr>';
                                                                    }
                                                                }
                                                            ?>
                                                    </tbody>
                                                </table>
                                                        
                                                    </div>
                                                
                                                <br><br>
                                                </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="row">
                                                        <div class="col-lg-3 pull-right">
                                                            <label for="attestedby">Attested By: </label>
                                                            <input type="text" class="form-control" name="attestedby" id="attestedby" value="<?php echo $attestedby; ?>" >
                                                        </div>
                                                        <div class="col-lg-3 pull-left">
                                                                <label for="interviewedby">Interviewed By: </label>
                                                                <input type="text" class="form-control" value="<?php echo $interviewedby; ?>" name="interviewedby" id="interviewedby"  ><br><br>
                                                            </div>
                                                    </div>
                                                    
                                                </div>
                                            <div class="col-lg-12 text-center">
                                                <br><br>
                                                <button type="submit" name="update" id="update" disabled class="btn btn-success">Update</button><br><br>
                                            </div>
                            </div>
                                        </div>
                                    </div>
                                    <div class="box-footer clearfix">
                                        <div class="btn-group pull-right">
                                            <button type="button" onclick="plusDivs(-1, 1)" class="btn btn-sm btn-primary" id="jump3" style="background-color:green">
                                                <i class="fa fa-chevron-left"></i> Previous
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>



                        </div>
                    </div>

            </div>

        </form>
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

        $('#arb_lname, #arb_fname , #arb_arbo ,#arb_cloa, #arb_landsize').keyup(function() {
            arb_lname = $('#arb_lname').val();
            arb_fname = $('#arb_fname').val();
            arb_arbo = $('#arb_arbo').val();
            arb_cloa = $('#arb_cloa').val();
            arb_landsize = $('#arb_landsize').val();
            checkArb();
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
                $('#update').removeAttr('disabled');
            } else {
                $('#update').attr('disabled','disabled');
            }
        }

        function checkArb() {
            lname = $('#arb_lname').val();
            fname = $('#arb_fname').val();
            mname = $('#arb_mi').val();

            $.post('controller/checkArb.php' , {
                fname : fname,
                lname : lname,
                mname : mname,
                arb_id : $('#arb_id').val()
            } , function(data, status) {
                if(data == 'false') {
                    $('.error_mess').html('<span class="ifError"><b>ARB Already Recorded!</b></span>');
                    $('#save, #jump1').attr('disabled','disabled');
                    console.log(1);
                } else {
                    $('.ifError').remove();
                    $('#save').removeAttr('disabled');
                    console.log(0);
                }
            });
        }
</script>
</body>
</html>
<?php } else {
        header('location:../index.php');
}?>