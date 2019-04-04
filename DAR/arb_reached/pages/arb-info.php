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
            input[type="checkbox"] {
                height:15px;
                width:15px;
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
            :disabled{
                background-color:rgba(255,255,255,.2);
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
                $arb_id = isset($_GET['id']) ? htmlspecialchars($_GET['id']) : 0;
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

                $other_org = array();
                $other_pos = array();
                $other_stat = array();
                $other_org1 = array();
                $other_pos1 = array();
                $other_stat1 = array();

                $sql = 'SELECT arbo.name , pos.description, assoc.arbo_status_id
                        FROM arbo_profile as arbo
                        inner join arbo_association_members as assoc on assoc.arbo_profile_id = arbo.id
                        inner join part1_arb_household as hhold on hhold.hhold_id = assoc.arbo_mem_id
                        inner join arbo_position_type as pos on assoc.arbo_position_type_id = pos.id
                        WHERE hhold.ln_arb = ? and hhold.fn_arb = ? and hhold.mn_arb = ? and arbo.name != ?
                        GROUP BY arbo.name';
                $sql = $conn->prepare($sql);
                $sql->bind_param('ssss', $arb_lname, $arb_fname, $arb_mi, $arbo);
                $sql->execute();
                $sql->bind_result($arbo_frm_ppfile, $pos_frm_ppfile,  $stat_frm_ppfile);
                $sql->store_result();
                if($sql->num_rows() > 0) {
                    while($sql->fetch()) {
                        array_push($other_org, $arbo_frm_ppfile);
                        array_push($other_pos, $pos_frm_ppfile);
                        array_push($other_stat, $stat_frm_ppfile);
                    }
                }

                $sql = 'SELECT arbo.arbo_name, arbo.position , arbo.status 
                        FROM part4_arbo as arbo
                        inner join  part1_arb_household as hhold on hhold.hhold_id = arbo.hhold_id
                        WHERE hhold.ln_arb = ? and hhold.fn_arb = ? and hhold.mn_arb = ? and arbo.arbo_name != ?
                        GROUP BY arbo.arbo_name';
                $sql = $conn->prepare($sql);
                $sql->bind_param('ssss', $arb_lname, $arb_fname, $arb_mi, $arbo);
                $sql->execute();
                $sql->bind_result($arbo_frm_ppfile1, $pos_frm_ppfile1,  $stat_frm_ppfile1);
                $sql->store_result();
                if($sql->num_rows() > 0) {
                    while($sql->fetch()) {
                        array_push($other_org1, $arbo_frm_ppfile1);
                        array_push($other_pos1, $pos_frm_ppfile1);
                        array_push($other_stat1, $stat_frm_ppfile1);
                    }
                }

                if(count($other_org1) > 0) {
                    for($i = 0 ; $i < count($other_org1) ; $i++) {
                        if(!in_array($other_org1[$i],  $other_org)) {
                            array_push($other_org, $other_org1[$i]);
                            array_push($other_pos, $other_pos1[$i]);
                            array_push($other_stat, $other_stat1[$i]);
                        }
                        
                    }
                }
                $arb_bdate = $arb_bdate == 0000-00-00 ? 'N/A' : $arb_bdate;
                
            ?>
            <div class="content-wrapper container-fluid" >
                <section class="content-header">
                    &nbsp;&nbsp;&nbsp;&nbsp;<a href="arb-reached.php"><button class="btn btn-success btn-sm">
                    <i class="fa fa-arrow-circle-left"></i> Back</button></a>
                    <a href="arb-update.php?id=<?php echo $arb_id; ?>">
                    <button class="btn btn-primary btn-sm">Update</button>
                    </a>
                    <span style="font-size:20px;">ARB FORM</span>
                    <ol class="breadcrumb" id="arb_page">
                    </ol>
                </section>
                <section class="content">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-next">
                                <div class="box box-success" style="width:97.5%;margin-left:1.2%;margin-right:1.2%;">
                                    <!-- content -->
                                    <div class="box-header with-border text-center">
                                        <h4><b>REACHED ARB</b></h4>
                                    </div>
                                    <br>
                                    <div class="box-body">
                                    <div style="padding-left:4%;padding-right:4%;">
                                        <div class="row">

                                            

                                            <div class="form-group col-lg-6 col-sm-6">
                                                    <label for="arb_lname">Municipality</label>
                                                    <input type="text" disabled class="form-control" name="city" value="<?php echo htmlspecialchars($get_city); ?>" id="city"  >
                                            </div>

                                            <div class="form-group col-lg-6 col-sm-6">
                                                <label for="arb_lname">BARANGAY</label>
                                                    <input type="text" disabled class="form-control" name="city" value="<?php echo htmlspecialchars($brgy); ?>" id="city"  >
                                            </div>
                                            <div class="col-lg-12">
                                                <b>PART I : ARB Information</b> <br><br>
                                                <b>NAME OF ARB</b>
                                            </div> <br>
                                            <div class="form-group col-lg-4 col-sm-4">
                                                    <label for="arb_lname">Last Name</label>
                                                    <input type="text" disabled class="form-control" value="<?php echo htmlspecialchars($arb_lname) ; ?>"  name="arb_lname" id="arb_fname"  >
                                            </div>
                                            <div class="form-group col-lg-4 col-sm-4">
                                                    <label for="arb_fname">First Name</label>
                                                    <input type="text" disabled class="form-control" value="<?php echo htmlspecialchars($arb_fname) ; ?>" name="arb_fname" id="arb_fname"  >
                                            </div>
                                            <div class="form-group col-lg-2 col-sm-4">
                                                    <label for="arbo_barangay">MI</label>
                                                    <input type="text" disabled class="form-control" value="<?php echo htmlspecialchars($arb_mi) ; ?>" name="arb_mi" id="arb_mi"  >
                                            </div>
                                            <div class="form-group col-lg-2 col-sm-2">
                                                    <label for="gender">Gender</label>
                                                    <input type="text" disabled class="form-control" value="<?php echo $arb_gender = htmlspecialchars($arb_gender) == 'F' ? 'Female' : 'Male' ; ?>" name="gender" id="gender"  >
                                            </div>

                                            <div class="form-group col-lg-4 col-sm-4">
                                                    <label for="civil_status">Civil Status</label>
                                                    <input type="text" disabled class="form-control" value="<?php echo htmlspecialchars($civil_status) ; ?>" name="civil_status" id="civil_status"  >
                                            </div>
                                            <div class="form-group col-lg-4 col-sm-4">
                                                    <label for="arbo_barangay">Birthdate</label>
                                                    <input type="text" disabled class="form-control" value="<?php echo $arb_bdate ; ?>" name="arb_bdate" id="arb_bdate"  >
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
                                                    <input type="text" disabled class="form-control" name="spouse_lname" value="<?php echo htmlspecialchars($spouse_lname) ; ?>" id="spouse_lname"  >
                                            </div>
                                            <div class="form-group col-lg-4 col-sm-4">
                                                    <label for="arbo_barangay">First Name</label>
                                                    <input type="text" disabled class="form-control" name="spouse_fname" value="<?php echo htmlspecialchars($spouse_fname) ; ?>" id="spouse_fname"  >
                                            </div>
                                            <div class="form-group col-lg-2 col-sm-4">
                                                    <label for="arbo_barangay">MI</label>
                                                    <input type="text" disabled class="form-control" name="spouse_mi" value="<?php echo htmlspecialchars($spouse_mi) ; ?>" id="spouse_mi"  >
                                            </div>
                                            
                                            <div class="form-group col-lg-4 col-sm-4">
                                                    <label for="arb_cloa">Cloa #</label>
                                                    <input type="text" disabled class="form-control" value="<?php echo htmlspecialchars($arb_cloa) ; ?>" name="arb_cloa" id="arb_cloa"  >
                                            </div>
                                            <div class="form-group col-lg-2 col-sm-4">
                                                    <label for="arb_landsize">Landsize(ha) : </label>
                                                    <input type="text" disabled class="form-control"  value="<?php echo htmlspecialchars($arb_landsize) ; ?>"
                                                        name="arb_landsize" id="arb_landsize"  >
                                            </div>

                                            <div class="col-lg-12"><br>
                                            
                                            <b>PART II : Membership to Agrarian Reform Beneficiaries Orgnization (ARBOs)</b> <br><br>
                                            </div> <br>
                                            <div class="form-group col-lg-12 col-sm-12">
                                                    <label for="arbo_barangay">Name of ARBO </label>
                                                    <input type="text" disabled class="form-control" value="<?php echo htmlspecialchars($arbo) ; ?>" name="arb_arbo" id="arb_laarb_arbondsize"
                                                    placeholder="(PLease Provide CORRECT Name of ARBO with ACRONYM (IF APPLICABLE) )" >
                                            </div>
                                            <div class="form-group col-lg-4 col-sm-4">
                                                    <label for="arb_position">Position</label>
                                                    <input type="text" disabled class="form-control" value="<?php echo htmlspecialchars($arb_position) ; ?>" name="arb_position" id="arb_position" >
                                            </div>
                                            <div class="form-group col-lg-4 col-sm-4">
                                                    <label for="date_of_mem">Date of Mem : </label>
                                                    <input type="text" disabled class="form-control" value="<?php echo $date_of_mem ; ?>" name="date_of_mem" id="date_of_mem"  >
                                            </div>
                                            <div class="form-group col-lg-4 col-sm-4">
                                                    <label for="status">STATUS</label>
                                                    <input type="text" disabled class="form-control" value="<?php echo htmlspecialchars($status) ; ?>" name="status" id="status"  >
                                            </div>
                                            
                                            <div class="form-group col-lg-12 col-sm-12">
                                            <button type="button" class="btn btn-success btn-md" data-toggle="collapse" data-target="#otherOrganization">Other Organization(<?php echo count($other_org) ; ?>)</button>
                                            <?php
                                                if(count($other_org) > 0) {
                                                    echo "<div id='otherOrganization' class='collapse'><br>";
                                                    for($i = 0 ; $i < count($other_org) ; $i++) {
                                                        $other_stat_ = $other_stat[$i] == 1 ? 'ACTIVE' : 'INACTIVE';
                                                        echo "<div class='form-group col-lg-12 col-sm-12'>
                                                            ".($i+1)."<label>.&nbsp;&nbsp;&nbsp;ORGANIZATION </label>
                                                            <input type='text' disabled class='form-control' value='$other_org[$i]'>
                                                            </div>
                                                            <div class='form-group col-lg-4 col-sm-4'>
                                                                    <label>Position</label>
                                                                    <input type='text' disabled class='form-control' value='$other_pos[$i]'>
                                                            </div>
                                                            <div class='form-group col-lg-4 col-sm-4'>
                                                                    <label for='status'>STATUS</label>
                                                                    <input type='text' disabled class='form-control' value='$other_stat_'>
                                                            </div>
                                                            <div class='form-group col-lg-12' style='margin-top:-10px;margin-bottom:-10px;'><hr></div>";
                                                    }        
                                                    echo "</div>";
                                                }
                                            ?>


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
                                    <div class="box-header with-border text-center">
                                        <h4><b>(ASK FOR CORRECT LABEL)</b></h4>
                                    </div>
                                    <br>
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
                                                                    $sql = 'SELECT arb_train.*
                                                                    from arb_trainings_attended as acq_train
                                                                    inner join arb_trainings as arb_train on arb_train.id = acq_train.trainings_id
                                                                    WHERE acq_train.arb_id = ?';
                                                                    $sql = $conn->prepare($sql);
                                                                    $sql->bind_param('i',$arb_id);
                                                                    $sql->execute();
                                                                    $sql->bind_result($id,$trainings);
                                                                    $sql->store_result();
                                                                    if($sql->num_rows() > 0) {
                                                                        while($sql->fetch()) {
                                                                            $i++;
                                                                            echo "<tr>
                                                                                    <td class='$id text-center $i'>$i</td>
                                                                                    <td class='$id'>$trainings</td>
                                                                                    <td class='text-center $id'><input disabled name='arb_trainings[]' checked class='cust_check' type='checkbox' value='$id'></td>
                                                                                  </tr>";
                                                                        }
                                                                    } else {
                                                                        echo "<tr>
                                                                                <td colspan='12' class='text-center' style='color:gray;'> < Empty ></td>
                                                                              </tr>";
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
                                                            if(($amount == 0 || empty($amount)) && empty($instite)) {
                                                                $amount = '';
                                                            }

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
                                                                    <td><input type="text" class="form-control" disabled name="arb_name_prod" value="<?php echo htmlspecialchars($instite) ; ?>" id="arb_name_prod"></td>
                                                                    <td><input type="text" class="form-control" disabled name="arb_prod_amount" value="<?php echo htmlspecialchars($amount) ; ?>" id="arb_prod_amount"  ></td>
                                                                </tr>
                                                                <?php
                                                                    $sql->bind_param('is', $arb_id,$ssa[1]);
                                                                    $sql->execute();
                                                                    $sql->bind_result($instite,$amount);
                                                                    $sql->store_result();
                                                                    $sql->fetch();
                                                                    if(($amount == 0 || empty($amount)) && empty($instite)) {
                                                                        $amount = '';
                                                                    }
                                                                ?> 
                                                                <tr>
                                                                    <td>b. Micro</td>
                                                                    <td><input type="text" class="form-control" disabled value="<?php echo htmlspecialchars($instite) ; ?>" name="arb_name_micro" id="arb_name_micro"  ></td>
                                                                    <td><input type="text" class="form-control" disabled value="<?php echo htmlspecialchars($amount) ; ?>" name="arb_micro_amount" id="arb_micro_amount"  ></td>
                                                                </tr>
                                                                <?php
                                                                    $sql->bind_param('is', $arb_id, $ssa[2]);
                                                                    $sql->execute();
                                                                    $sql->bind_result($instite,$amount);
                                                                    $sql->store_result();
                                                                    $sql->fetch();
                                                                    if(($amount == 0 || empty($amount)) && empty($instite)) {
                                                                        $amount = '';
                                                                    }
                                                                ?>
                                                                <tr>
                                                                    <td>c. Livelihood</td>
                                                                    <td><input type="text" class="form-control" disabled value="<?php echo htmlspecialchars($instite) ; ?>" name="arb_name_lhood" id="arb_name_lhood"  ></td>
                                                                    <td><input type="text" class="form-control" disabled value="<?php echo htmlspecialchars($amount) ; ?>" name="arb_lhood_amount" id="arb_lhood_amount"  ></td>
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
                                            <button type="button" onclick="plusDivs(+1, 3)" class="btn btn-success btn-sm pull-right next" form="add_francise_form">
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
                                    <div class="box-header with-border text-center">
                                        <h4><b>(ASK FOR CORRECT LABEL)</b></h4>
                                    </div>
                                    <br>
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
                                                    

                                                <?php
                                                    $flag = 0 ;
                                                    $qid = array(79, 95, 96, 97, 98);
                                                    $sql_qid = $conn->prepare('SELECT arbo_sub.*
                                                    from arbo_sub_intervention as arbo_sub
                                                    inner join arb_acquired_intervention as acq_inter on acq_inter.sub_id = arbo_sub.id
                                                    where arbo_sub.main_id = ? and acq_inter.arb_id = ?');
                                                    $i = 0;

                                                    $sql_qid->bind_param('ii', $qid[0], $arb_id);
                                                    $sql_qid->execute();
                                                    $sql_qid->bind_result($id, $description, $q79_id);
                                                    $sql_qid->store_result();
                                                    if ($sql_qid->num_rows() > 0) {
                                                        $flag++;
                                                        echo '<tr>
                                                                <td colspan="3"style="background-color:rgb(189, 255, 189);" class="text-center" id="79"><strong>Agrarian Reform Community Connectivity and Economic Support Services</strong></td>
                                                            </tr>';
                                                        while ($sql_qid->fetch()) {
                                                            $i++;
                                                            echo '<tr>
                                                                    <td class="'.$id.'">' . $i . '</td>
                                                                    <td class="'.$id.'">' . $description . '</td>
                                                                    <td class="'.$id.'"><input disabled type="checkbox" checked onclick="addbg(this.value)" value="' . $id . '" name="q79[]"/></td>
                                                                  </tr>';
                                                        }
                                                    }
                                                    ?>
                                                    
                                                    <?php
                                                        $i = 0;
                                                        $sql_qid->bind_param('ii', $qid[1] , $arb_id );
                                                        $sql_qid->execute();
                                                        $sql_qid->bind_result($id, $description, $q95_id);
                                                        $sql_qid->store_result();
                                                        if ($sql_qid->num_rows() > 0) {
                                                            $flag++;
                                                            echo '<tr>
                                                                    <td colspan="3"style="background-color:rgb(189, 255, 189);" class="text-center" id="95"><strong>Partnership Development Projects</strong></td>
                                                                </tr>';
                                                            while ($sql_qid->fetch()) {
                                                                $i++;
                                                                echo '<tr>
                                                                        <td class="'.$id.'">' . $i . '</td>
                                                                        <td class="'.$id.'">' . $description . '</td>
                                                                        <td class="'.$id.'"><input disabled type="checkbox" checked onclick="addbg(this.value)" value="' . $id . '" name="q95[]"/></td>
                                                                        </tr>';
                                                            }
                                                        }
                                                        ?>
                                                    
                                                    <?php
                                                        $i = 0;
                                                        $sql_qid->bind_param('ii', $qid[2] , $arb_id );
                                                        $sql_qid->execute();
                                                        $sql_qid->bind_result($id, $description, $q96_id);
                                                        $sql_qid->store_result();
                                                        if ($sql_qid->num_rows() > 0) {
                                                            $flag++;
                                                            echo '<tr>
                                                                    <td colspan="3"style="background-color:rgb(189, 255, 189);" class="text-center" id="96"><strong> Foreign Assisted Projects</strong></td>
                                                                </tr>';
                                                            while ($sql_qid->fetch()) {
                                                                $i++;
                                                                echo '<tr>
                                                                    <td class="'.$id.'">' . $i . '</td>
                                                                    <td class="'.$id.'">' . $description . '</td>
                                                                    <td class="'.$id.'"><input disabled type="checkbox" checked onclick="addbg(this.value)" value="' . $id . '" name="q96[]"/></td>
                                                                    </tr>';
                                                            }
                                                        }
                                                        ?>
                                                
                                                <?php
                                                    $i = 0;
                                                    $sql_qid->bind_param('ii', $qid[3] , $arb_id );
                                                    $sql_qid->execute();
                                                    $sql_qid->bind_result($id, $description, $q97_id);
                                                    $sql_qid->store_result();
                                                    if ($sql_qid->num_rows() > 0) {
                                                        $flag++;
                                                        echo '<tr>
                                                                <td colspan="3"style="background-color:rgb(189, 255, 189);" class="text-center" id="97"><strong> Microfinance and Credit Programs</strong></td>
                                                            </tr>';
                                                        while ($sql_qid->fetch()) {
                                                            $i++;
                                                            echo '<tr>
                                                                <td class="'.$id.'">' . $i . '</td>
                                                                <td class="'.$id.'">' . $description . '</td>
                                                                <td class="'.$id.'"><input disabled type="checkbox" checked value="' . $id . '" onclick="addbg(this.value)" name="q97[]"/></td>
                                                                </tr>';
                                                        }
                                                    }
                                                    ?>
                                                        </tbody>
                                                    </table>
                                                    <div class="table-responsive">
                                                    <table class="table table-striped">
                                                    <tbody>
                                                     
                                                    <?php
                                                        $sql_qid = $conn->prepare('SELECT arbo_sub.*, acq_inter.specify_intervention
                                                        from arbo_sub_intervention as arbo_sub
                                                        inner join arb_acquired_intervention as acq_inter on acq_inter.sub_id = arbo_sub.id
                                                        where arbo_sub.main_id = ? and acq_inter.arb_id = ?');

                                                        $i = 0;
                                                        $sql_qid->bind_param('ii', $qid[4] , $arb_id );
                                                        $sql_qid->execute();
                                                        $sql_qid->bind_result($id, $description, $q98_id, $spec_intervene);
                                                        $sql_qid->store_result();
                                                        if ($sql_qid->num_rows() > 0) {
                                                            $flag++;
                                                            echo '<tr>
                                                                    <td colspan="12"style="background-color:rgb(189, 255, 189);" class="text-center" id="98"><strong> Partner Agencies</strong></td>
                                                                </tr>';
                                                            while ($sql_qid->fetch()) {
                                                                $i++;
                                                                echo '<tr>
                                                                    <td class="'.$id.'">' . $i . '</td>
                                                                    <td class="'.$id.'">' . $description . '</td>
                                                                    <td class="'.$id.'"><input disabled style="background-color:rgba(255, 255, 255, .0);" class="select_brdr_btm" type="text" id="' . $id . '"
                                                                        value="'.$spec_intervene.'" placeholder="&nbsp;&nbsp;&nbsp;specify" disabled name="q98_spec[]"/></td>
                                                                    <td class="'.$id.'"><input disabled type="checkbox" checked onclick="enable(this.value)" value="' . $id . '" name="q98[]"/></td>
                                                                   
                                                                    </tr>';
                                                        }
                                                    }
                                                   
                                                    
                                                    
                                                    ?>
                                                </tbody>
                                                </table>
                                                <?php
                                                    if($flag < 1) {
                                                        echo "<div style='margin-bottom:250px;margin-top:-20px;' class='text-center'>
                                                                <p colspan='12' style='color:gray;'> < Empty > </p>
                                                            </div>";
                                                    }
                                                ?>
                                                
                                                <br><br>
                                                </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="row">
                                                        <div class="col-lg-6 pull-left">
                                                            <label for="attestedby">Attested By: </label>
                                                            <input type="text" disabled class="form-control" name="attestedby" id="attestedby" value="<?php echo htmlspecialchars($attestedby); ?>" >
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="row">
                                                            <div class="col-lg-6 pull-right">
                                                                <label for="interviewedby">Interviewed By: </label>
                                                                <input type="text" disabled class="form-control" value="<?php echo htmlspecialchars($interviewedby); ?>" name="interviewedby" id="interviewedby"  ><br><br>
                                                            </div>
                                                        </div>
                                                </div>
                                                    </div>
                                                </div>
                                                
                                        </div>
                                    </div>
                                    <div class="box-footer clearfix">
                                        <div class="btn-group pull-right">
                                            <button type="button" onclick="plusDivs(-1, 1)" class="btn btn-sm btn-primary" style="background-color:green">
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
        function targetz(l, m) {
            showDivs(slideIndex = l, m);
        }
        </script>
    </body>
</html>
<?php } else {
    header('location:../index.php');
}?>