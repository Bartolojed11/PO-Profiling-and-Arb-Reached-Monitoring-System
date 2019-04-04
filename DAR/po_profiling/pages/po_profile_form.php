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
        <title>PPS | Register</title>
        <style>
            .associate_tbl td {
                text-align:center;
                min-width:100px;
            }
            .associate_tbl th {
                text-align:center;
            }
            .custom_input_lg{
                width:350px;
            }
            #abc:hover{
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
            .active_cust {
                font-weight:bolder;
                color:#00a65a;
            }
            .tt-suggestions{
                margin-left:20px;
                margin-top:5px;
                background-color:white;
            }
            #landsize_total{
                text-align: center;
            }
            .addbgcolor {
                background-color:rgba(212, 204, 204, .5);
                font-weight:bold;
            }

            .thisdiv table { border-collapse:separate;max-width:100px; }
            .thisdiv td, th {
                margin:0;
                border-top-width:0px; 
            }
            .thisdiv div {
                padding-bottom:1px;
                
            }
            .headcol , .headcol1, .headcol2, .headcol3, .headcol4 {
                position:sticky;
                background-color:white;
            }

            .headcol1 { 
                left:0px;
            }
            .headcol2 {
                left:190.8px;
            }
            .user-panel {
                background-image:url('../logo/dar-bg.png');
                height:100px;
            }
            input[type="checkbox"] {
                height:15px;
                width:15px;
            }
        </style>
    </head>
    <body class="skin-green fixed sidebar-mini sidebar-mini-expand-feature hold-transition">
        <!-- Site wrapper -->
        <div class="wrapper">
            <?php
$page = 'form';
include 'inc/header.php';
include 'inc/sidebar.php';
?>
<!--  -->
            <form action="controller/po_profile_reg.php" role="form" novalidate id="submit_form" name="submit_form" method="post" enctype="multipart/form-data">

                <!-- Content Wrapper. Contains page content -->

                <div class="content-wrapper">
                    <section class="content-header">
                        <h4>
                            <strong>PO PROFILE REGISTRATION</strong>
                        </h4>
                        <ol class="breadcrumb" id="abc">
                        </ol>
                    </section>
                    <!-- Main content -->
                    <section class="content">
                        <div class="row form-next">
                            <div class="col-xs-12">
                                <div class="box box-success">

                                    <div class="box-header with-border text-center">
                                        <h4><b>(ASK FOR CORRECT TITLE)</b></h4>
                                    </div>


                                    <div class="box-body">

                                        <div class="form-group col-sm-12">

                                            <div class="form-group inside-div">
                                            <br><br>
                                                <div class="form-group col-sm-2">
                                                   <label>As of</label>
                                                    <input type="text" class="form-control" name="part1_arbo_of" id="part1_arbo_of"  >
                                                </div>


                                                <div class="form-group col-sm-4">
                                                    <label>NAME OF ORGANIZATION</label>
                                                    <input type="text" class="form-control" name="part1_arbo_name" id="part1_arbo_name"  >
                                                    <small id="org_error"></small>
                                                </div>

                                                <div class="form-group col-sm-4">
                                                    <label>ACRONYM</label>
                                                    <input type="text" class="form-control" name="part1_acro_name" id="part1_acronym"  >
                                                </div>
                                                <div class="form-group col-sm-2">
                                                    <label>FORM IMAGE</label>
                                                    <input type="file" class="form-control" name="arbo_form_image" id="arbo_form_image">
                                                </div>

                                                <div class="form-group col-sm-12">
                                                    <label>ARBO ADDRESS: </label>
                                                </div>

                                                <div class="form-group col-sm-3">
                                                    <label for="arbo_province">PROVINCE</label>
                                                    <select class="form-control select_brdr_btm" id="arbo_province" name="arbo_province" required>
                                                        <option value="Negros Occidental" selected>Negros Occidental</option>
                                                    </select>
                                                </div>

                                                <div class="form-group col-sm-3">
                                                    <label for="arbo_municipal">MUNICIPALITY</label>
                                                    <select class="form-control select_brdr_btm" id="arbo_municipal"
                                                        name="arbo_municipal" required onchange="show_barangay()">
                                                        <!-- check js -->
                                                    </select>
                                                </div>

                                                <div class="form-group col-sm-3">
                                                    <label for="arbo_barangay">BARANGAY</label>
                                                    <select class="form-control select_brdr_btm" id="arbo_barangay" name="arbo_barangay" required >

                                                    </select>
                                                </div>

                                                <div class="form-group col-sm-3">
                                                    <label>D. SITIO/PUROK/STREET</label>
                                                    <input type="text" class="form-control" name="arbo_sps" id="arbo_sps"  >
                                                </div>

                                                <div class="form-group col-sm-12">
                                                    <label>AREA OF OPERATION: </label>
                                                </div>

                                                <div class="form-group col-sm-3">
                                                    <label for="ope_prov">PROVINCE</label>
                                                    <select class="form-control select_brdr_btm" id="ope_prov"  name="ope_prov" required>
                                                        <option value="Negros Occidental" selected>Negros Occidental</option>
                                                    </select>
                                                </div>

                                                <div class="form-group col-sm-3">
                                                    <label for="ope_municipal">MUNICIPALITY</label>
                                                    <select class="form-control select_brdr_btm" id="ope_city" onchange="show_ope_barangay()"  name="ope_city" required onchange="municipal1()">
                                                    </select>
                                                </div>

                                                <div class="form-group col-sm-3">
                                                    <label for="ope_brgy">BARANGAY</label>
                                                    <select class="form-control select_brdr_btm" id="ope_brgy"  name="ope_brgy" required>
                                                    </select>
                                                </div>


                                                <div class="form-group col-sm-3">
                                                    <label>D. SITIO/PUROK/STREET</label>
                                                    <input type="text" class="form-control" name="ope_sps" id="ope_sps"  >
                                                </div>

                                                <div class="form-group col-sm-4">

                                                    <label>CONTACT PERSON</label>
                                                    <input type="text" class="form-control" name="contact_person" id="contact_person"  >
                                                </div>

                                                <div class="form-group col-sm-4">
                                                    <label>DATE ORGANIZED</label>
                                                    <input type="text" class="form-control" name="date_organized" id="date_organized"  >
                                                </div>

                                                <div class="form-group col-sm-4">
                                                    <label>DATE REGISTERED</label>
                                                    <input type="text" class="form-control" name="date_reg" id="date_reg"  >
                                                </div>

                                                <div class="form-group col-sm-6">
                                                    <label>REGISTRATION NO.</label>
                                                    <input type="text" class="form-control" name="reg_num" id="reg_num" >
                                                </div>

                                                <div class="form-group col-sm-6">
                                                    <label>AGENCY/ENTITY REGISTERED</label>
                                                    <input type="text" class="form-control" name="agency_registered" id="agency_registered"  >
                                                </div>

                                                <div class="form-group col-sm-6">
                                                    <label>TYPE OF ORGANIZATION</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="text" class="form-control" name="oranization_type" id="oranization_type"  >
                                                </div>

                                                <div class="form-group col-sm-6">
                                                    <label> AFFILIATION</label>
                                                    <input type="text" class="form-control" name="affliation" id="affliation" >
                                                </div>


                                                <div class="col-sm-12 table-responsive">
                                                <br><br><br>
                                                <table class="table table-bordered">

                                                    <thead class="bg-success-custom">
                                                        <tr>
                                                            <th colspan="6" style="padding:0px;"><center style="background-color:#00a65a;padding:2px;color:white;">
                                                            <h5><b>MEMBERSHIP</b></h5></center></th>
                                                        </tr>
                                                    </thead>
                                                    <thead>
                                                        <tr>
                                                            <td>ARB</td>
                                                            <td><input type="number" disabled class="form-control" name="part3_arb1_members" id="part3_arb1_members"  ></td>
                                                            <td>MALE</td>
                                                            <td><input type="number" min="0" class="form-control" name="part3_arb1_male" id="part3_arb1_male" onkeyup="sumMale()"   ></td>
                                                            <td>FEMALE</td>
                                                            <td><input type="number" min="0" class="form-control" name="part3_arb1_female" id="part3_arb1_female" onkeyup="sumFemale()"   ></td>
                                                        </tr>
                                                    </thead>

                                                    <thead>
                                                        <tr>
                                                            <td>NON-ARB</td>
                                                            <td><input type="number" disabled min="0" class="form-control" name="part3_arb2_members" id="part3_arb2_members" ></td>
                                                            <td>MALE</td>
                                                            <td><input type="number" min="0" class="form-control" name="part3_arb2_male" id="part3_arb2_male" onkeyup="sumMale()"  ></td>
                                                            <td>FEMALE</td>
                                                            <td><input type="number" min="0" class="form-control" name="part3_arb2_female" id="part3_arb2_female" onkeyup="sumFemale()"  ></td>
                                                        </tr>
                                                    </thead>

                                                    <thead>
                                                        <tr>
                                                            <td>ARB-HH</td>
                                                            <td><input type="number" disabled min="0" class="form-control" name="total_hh_arb" id="total_hh_arb" ></td>
                                                            <td>MALE</td>
                                                            <td><input type="number" min="0" class="form-control" name="male_hh_arb" id="male_hh_arb" onkeyup="sumMale()"  ></td>
                                                            <td>FEMALE</td>
                                                            <td><input type="number" min="0" class="form-control" name="female_hh_arb" id="female_hh_arb" onkeyup="sumFemale()"  ></td>
                                                        </tr>
                                                    </thead>
                                                    <!-- class="bg-primary" style="background-color:mediumseagreen" -->
                                                    <thead>
                                                        <tr>
                                                            <td>TOTAL </td>
                                                            <td><input type="number" class="form-control" name="part3_total_members" id="part3_total_members" disabled ></td>
                                                            <td>TOTAL MALE</td>
                                                            <td><input type="number" class="form-control" name="part3_total_male" id="part3_total_male" disabled ></td>
                                                            <td>TOTAL FEMALE</td>
                                                            <td><input type="number" class="form-control" name="part3_total_female" id="part3_total_female" disabled ></td>
                                                        </tr>
                                                    </thead>

                                                </table>

                                                </div>


                                            </div>

                                        </div>



                                    </div>


                                    <div class="box-footer clearfix">
                                        <button type="button" onclick="plusDivs( + 1, 2)" class="btn btn-sm btn-success pull-right" id="jump1" form="add_francise_form">
                                            Next <i class="fa fa-chevron-right"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row form-next">
                            <div class="col-xs-12">
                                <div class="box box-success">

                                    <div class="box-header with-border text-center">
                                        <h4><b>CURRENT SERVICES PROVIDED</b></h4>
                                    </div>

                                    <div class="box-body">

                                        <div class="form-group col-sm-12">

                                            <div class="form-group inside-div">

                                                <div class="class=form-group col-sm-12">

                                                    <table class="table table-bordered"  style="background-color: white;">
                <thead class="bg-primary" style="background-color:mediumseagreen">
                    <tr>
                        <th></th>
                        <th></th>
                        <th colspan="3" class="text-center" style="vertical-align: middle;">Clients Served</th>
                    </tr>

                </thead>

                <thead class="bg-primary" style="background-color:mediumseagreen">
                    <tr>
                        <th class="text-center" style="vertical-align: middle;">SERVICES</th>
                        <th class="text-center" style="vertical-align: middle;">Units / Heads</th>
                        <th class="text-center" style="vertical-align: middle;">Members </th>
                        <th class="text-center" style="vertical-align: middle;">Non Members</th>
                        <th style="max-width:100px;"></th>
                    </tr>
                </thead>


                <tbody>
                    <tr style="background-color:rgb(189, 255, 189);">
                        <td colspan="6"><b>Pre Harvest Facilities</b></td>
                    </tr>
                </tbody>
                <?php
                    $arbo_services = array(1,2,3,4,5);
                    $sql = 'SELECT id,description,arbo_service_main_id FROM arbo_service_sub where arbo_service_main_id = ? LIMIT 3';
                    $run_sql = $conn->prepare($sql);
                    $run_sql->bind_param('i',$arbo_services[0]);
                    $run_sql->execute();
                    $run_sql->bind_result($servcs_id, $description,$mainserv_id);
                    $run_sql->store_result();
                    if($run_sql->num_rows() > 0) {
                        while($run_sql->fetch()) {
                            echo '<tbody class="pre_hrvst_fcl">
                            <tr>
                                <td>'.$description.'</td>
                                <td>
                                <input type="hidden" name="pre_harv_id[]" value="'.$servcs_id.'"><input type="text" class="form-control" name="pre_harv_units[]"   ></td>
                                <td><input type="text" class="form-control" name="pre_harv_mem[]"  ></td>
                                <td><input type="text" class="form-control" name="pre_harv_nonmem[]"  ></td>
                                <td></td>
                            </tr>
                            </tbody>';
                        }
                    }
                ?>
                    <tr><td colspan="12"><button class="btn btn-success btn-sm" type="button"
                        onclick="add_services('pre_hrvst_fcl','pre_harv_id[]',<?php echo $mainserv_id; ?>,'pre_harv_units[]','pre_harv_mem[]','pre_harv_nonmem[]')">
                        Other Services</button></td></tr>
                

                <tbody>
                    <tr style="background-color:rgb(189, 255, 189);">
                        <td colspan="6"><b>Livestock</b></td>
                    </tr>
                </tbody>

                <?php
                    $sql = 'SELECT id,description,arbo_service_main_id FROM arbo_service_sub where arbo_service_main_id = ? LIMIT 4';
                    $run_sql = $conn->prepare($sql);
                    $run_sql->bind_param('i',$arbo_services[1]);
                    $run_sql->execute();
                    $run_sql->bind_result($servcs_id, $description,$mainserv_id);
                    $run_sql->store_result();
                    if($run_sql->num_rows() > 0) {
                        while($run_sql->fetch()) {
                            echo '<tbody class="lvstck">
                            <tr>
                                <td>'.$description.'</td>
                                <td>
                                <input type="hidden" name="livestock[]" value="'.$servcs_id.'"><input type="text" class="form-control" name="livestock_unit[]"   ></td>
                                <td><input type="text" class="form-control" name="livestock_mem[]"  ></td>
                                <td><input type="text" class="form-control" name="livestock_nonmem[]"  ></td>
                                <td></td>
                            </tr>
                        </tbody>';
                        }
                    }
                ?>
                <tr><td colspan="12"><button class="btn btn-success btn-sm" type="button"
                    onclick="add_services('lvstck','livestock[]',<?php echo $mainserv_id; ?>,'livestock_unit[]','livestock_mem[]','livestock_nonmem[]')">
                    Other Services</button></td></tr>

                <tbody>
                    <tr style="background-color:rgb(189, 255, 189);">
                        <td colspan="6"><b>Poultry / Broiler Raising</b></td>
                    </tr>
                </tbody>
                <?php
                    $sql = 'SELECT id,description,arbo_service_main_id FROM arbo_service_sub where arbo_service_main_id = ? LIMIT 3';
                    $run_sql = $conn->prepare($sql);
                    $run_sql->bind_param('i',$arbo_services[2]);
                    $run_sql->execute();
                    $run_sql->bind_result($servcs_id, $description,$mainserv_id);
                    $run_sql->store_result();
                    if($run_sql->num_rows() > 0) {
                        while($run_sql->fetch()) {
                            echo '<tbody class="pltry">
                            <tr>
                                <td>'.$description.'</td>
                                <td>
                                <input type="hidden" name="poultry[]" value="'.$servcs_id.'"><input type="text" class="form-control" name="poultry_unit[]"   ></td>
                                <td><input type="text" class="form-control" name="poultry_mem[]"  ></td>
                                <td><input type="text" class="form-control" name="poultry_nonmem[]"  ></td>
                                <td></td>
                            </tr>
                        </tbody>';
                        }
                    }

                ?>
                <tr><td colspan="12"><button class="btn btn-success btn-sm" type="button"
                    onclick="add_services('pltry','poultry[]',<?php echo $mainserv_id; ?>,'poultry_unit[]','poultry_mem[]','poultry_nonmem[]')">
                    Other Services</button></td></tr>

                <tbody>
                    <tr style="background-color:rgb(189, 255, 189);">
                        <td colspan="6"><b>Post Harvest Facilities</b></td>
                    </tr>
                </tbody>

                <?php
                    $sql = 'SELECT id,description,arbo_service_main_id FROM arbo_service_sub where arbo_service_main_id = ? LIMIT 7';
                    $run_sql = $conn->prepare($sql);
                    $run_sql->bind_param('i',$arbo_services[3]);
                    $run_sql->execute();
                    $run_sql->bind_result($servcs_id, $description,$mainserv_id);
                    $run_sql->store_result();
                    if($run_sql->num_rows() > 0) {
                        while($run_sql->fetch()) {
                            echo '<tbody class="post_hrv_fcl">
                            <tr>
                                <td>'.$description.'</td>
                                <td>
                                <input type="hidden" name="post_harv[]" value="'.$servcs_id.'"><input type="text" class="form-control" name="post_harv_unit[]"   ></td>
                                <td><input type="text" class="form-control" name="post_harv_mem[]"  ></td>
                                <td><input type="text" class="form-control" name="post_harv_nonmem[]"  ></td>
                                <td></td>
                            </tr>
                        </tbody>';
                        }
                    }
                ?>
                <tr><td colspan="12"><button class="btn btn-success btn-sm" type="button"
                    onclick="add_services('post_hrv_fcl','post_harv[]',<?php echo $mainserv_id; ?>,'post_harv_unit[]','post_harv_mem[]','post_harv_nonmem[]')">
                    Other Services</button></td></tr>

                <tbody>
                    <tr style="background-color:rgb(189, 255, 189);">
                        <td colspan="6"><b>Other Projects</b></td>
                    </tr>
                </tbody>
                <?php
                    $sql = 'SELECT id,description,arbo_service_main_id FROM arbo_service_sub where arbo_service_main_id = ? LIMIT 6';
                    $run_sql = $conn->prepare($sql);
                    $run_sql->bind_param('i',$arbo_services[4]);
                    $run_sql->execute();
                    $run_sql->bind_result($servcs_id, $description,$mainserv_id);
                    $run_sql->store_result();
                    if($run_sql->num_rows() > 0) {
                        while($run_sql->fetch()) {
                            echo '<tbody class="other_proj_field">
                            <tr>
                                <td>'.$description.'</td>
                                <td>
                                <input type="hidden" name="other_proj[]" value="'.$servcs_id.'"><input type="text" class="form-control" name="other_proj_unit[]"   ></td>
                                <td><input type="text" class="form-control" name="other_proj_mem[]"  ></td>
                                <td><input type="text" class="form-control" name="other_proj_nonmem[]"  ></td>
                                <td></td>
                            </tr>
                        </tbody>';
                        }
                    }
                ?>
            <tr><td colspan="12"><button class="btn btn-success btn-sm" type="button"
                onclick="add_services('other_proj_field','other_proj[]',<?php echo $mainserv_id; ?>,'other_proj_unit[]','other_proj_mem[]','other_proj_nonmem[]')">
                Other Services</button></td></tr>
            </table>

                                                </div>

                                            </div>

                                        </div>




                                    </div>
                                    <div class="box-footer clearfix">

                                        <div class="btn-group pull-right">
                                            <button type="button" onclick="plusDivs( - 1, 1)" class="btn btn-primary btn-sm" style="background-color:green">
                                                <i class="fa fa-chevron-left"></i> Previous
                                            </button>
                                            <button type="button" onclick="plusDivs( + 1, 3)" class="btn btn-success btn-sm">
                                                Next <i class="fa fa-chevron-right"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>





                        <div class="row form-next">
                            <div class="col-xs-12">
                                <div class="box box-success">


                                    <div class="box-header ">

                                    </div>
                                    <div class="box-body">
                                    <div class="col-sm-12 table-responsive">
                                                    <label></label>
                                                    <table class="table table-bordered">
                                                    <thead class="bg-success-custom">
                                                        <tr>
                                                            <th colspan="6" style="padding:0px;"><center style="background-color:#00a65a;padding:2px;color:white;">
                                                            <h5><b>ASSISTING ORGRANIZATION</b></h5></center></th>
                                                        </tr>
                                                    </thead>
                                                    <thead style="background-color:rgb(189, 255, 189);">
                                                            <tr>
                                                                <th rowspan="3" class="text-center"  style="vertical-align: middle;" >NAME OF NGO/ORGANIZATION ASSISTING</th>
                                                                <th rowspan="3" class="text-center" style="vertical-align: middle;">YEAR</th>
                                                                <th></th>
                                                            </tr>

                                                        </thead>

                                                        <tbody id="add_row_1">
                                                            <tr id="rw_0">
                                                                <td><input type="text" class="form-control" id="td_rw_0" name="par1_name_org_assiting[]"></td>
                                                                <td><input type="number" min="1900" max="3000" class="form-control" placeholder="1900" name="part1_year[]" ></td>
                                                                <td></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <button type="button" class="btn btn-success btn-sm" onclick="adding_row()"><i class="fa fa-plus"></i> Add</button>
                                                    <br><br>
                                                </div>


                                        <div class="form-group col-sm-12">

                                            <div class="col-sm-12 table-responsive">

                                                <table class="table table-bordered">
                                                    <thead class="bg-success-custom">
                                                        <tr>
                                                            <th colspan="6" style="padding:0px;"><center style="background-color:#00a65a;padding:2px;color:white;">
                                                            <h5><b>FINANCIAL STATUS</b></h5></center></th>
                                                        </tr>
                                                    </thead>
                                                    <thead style="background-color:rgb(189, 255, 189);">
                                                        <tr>
                                                            <th></th>
                                                            <th rowspan="3" class="text-center" style="vertical-align: middle;">AMOUNT</th>
                                                            <th></th>
                                                            <th rowspan="3" class="text-center" style="vertical-align: middle;">NO. OF SAVERS</th>

                                                        </tr>

                                                    </thead>

                                                    <tbody>
                                                        <tr>
                                                            <td>Capital Build Up:</td>
                                                            <td><input type="text" class="form-control input-cap-amount" name="part3_capital_amount" id="part3_capital_amount"  ></td>
                                                            <td></td>
                                                            <td><input type="text" class="form-control" name="part3_capital_savers" id="part3_capital_savers"  ></td>
                                                        </tr>
                                                    </tbody>

                                                    <tbody>
                                                        <tr>
                                                            <td>Savings:</td>
                                                            <td><input type="text" class="form-control input-savings" name="part3_savings_amount" id="part3_savings_amount"  ></td>
                                                            <td></td>
                                                            <td><input type="text" class="form-control" name="part3_savings_savers" id="part3_savings_savers"  ></td>
                                                        </tr>
                                                    </tbody>

                                                    <tbody>
                                                        <tr>
                                                            <td>Total Assets:</td>
                                                            <td><input type="text" class="form-control input-total-amount" name="part3_total_amount" id="part3_totall_amount"  ></td>
                                                            <td></td>
                                                            <td><input type="text" class="form-control" name="part3_total_savers" id="part3_totall_savers"  ></td>
                                                        </tr>
                                                    </tbody>

                                                    <tbody>
                                                        <tr>
                                                            <td>Total Liabilities:</td>
                                                            <td><input type="text" class="form-control input-liab-amount" name="part3_liability_amount" id="part3_liability_amount"  ></td>
                                                            <td></td>
                                                            <td><input type="text" class="form-control" name="part3_liability_savers" id="part3_liability_savers"  ></td>
                                                        </tr>
                                                    </tbody>


                                                    <tbody>
                                                        <tr>
                                                            <td>Networth:</td>
                                                            <td><input type="text" class="form-control input-net-amount" name="part3_networth_amount" id="part3_total_amount"  ></td>
                                                            <td></td>
                                                            <td><input type="text" class="form-control" name="part3_networth_savers" id="part3_total_savers"   ></td>
                                                        </tr>
                                                    </tbody>

                                                </table>
                                                <br>
                                            </div>
                                        </div>

                                        <div class="form-group col-sm-12">
                                            <div class="col-sm-12">
                                            <div style="background-color:#00a65a;padding:2px;color:white;">
                                            <center><h5><b>LOANS AVALIED IF ANY</b></h5></center>
                                            </div>
                                                <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead style="background-color:rgb(189, 255, 189);">
                                                        <tr>
                                                            <th rowspan="3" style="width:230px;" class="text-center" style="vertical-align: middle;">NATURE / PURPOSE OF LOAN</th>
                                                            <th rowspan="4" style="width:230px;" class="text-center" style="vertical-align: middle;">AMOUNT</th>
                                                            <th rowspan="3" style="width:230px;" class="text-center" style="vertical-align: middle;">SOURCE</th>
                                                            <th rowspan="2" class="text-center" style="vertical-align: middle;">DATE RELEASED</th>
                                                            <th rowspan="2" class="text-center" style="vertical-align: middle;">DATE AVAILED</th>
                                                            <th rowspan="3" class="text-center" style="vertical-align: middle;">TERMS OF PAYMENT</th>
                                                            <th rowspan="3" style="width:230px;" class="text-center" style="vertical-align: middle;">AMOUNT PAID</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>

                                                    <tbody id="add_row_7">
                                                        <tr id="rw2_0">
                                                            <td><input type="text" style="width:230px;" class="form-control" name="purpose_of_loan[]"  ></td>
                                                            <td><input type="text" style="width:230px;" class="form-control" name="loan_amount[]"  ></td>
                                                            <td><input type="text" style="width:230px;" class="form-control" name="loan_source[]"  ></td>
                                                            <td><input type="date" class="form-control" name="loan_date_released[]"></td>
                                                            <td><input type="date" class="form-control" name="loan_date_availed[]"></td>
                                                            <td>

                                                            <input type="text" style="width:230px;" class="form-control" name="loan_terms_payment[]"  >
                                                            </td>
                                                            <td><input type="text" style="width:230px;" class="form-control input-amount-paid" name="loan_amount_paid[]"  ></td>
                                                            <td></td>
                                                        </tr>
                                                    </tbody>

                                                    <!-- <tfoot>
                                                        <tr>
                                                            <th colspan="12"></th>
                                                        </tr>
                                                    </tfoot> -->
                                                </table>
                                                </div>
                                                <br>
                                                <button type="button" class="btn btn-success btn-sm" onclick="adding_rows()"><i class="fa fa-plus"></i> ADD</button>
                                                <br>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 table-responsive">
                                            <div class="col-sm-12 table-responsive">

                                                <table class="table table-bordered">
                                                    <thead class="bg-success-custom">
                                                        <tr>
                                                            <th colspan="12" style="padding:0px;"><center style="background-color:#00a65a;padding:2px;color:white;">
                                                            <h5><b>TRAININGS ATTENDED</b></h5></center></th>
                                                        </tr>
                                                    </thead>
                                                    <thead style="background-color:rgb(189, 255, 189);">
                                                        <tr>
                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
                                                            <th colspan="2" class="text-center" style="vertical-align: middle;">NUMBER OF PAX</th>
                                                            <th></th>
                                                        </tr>

                                                    </thead>

                                                    <thead style="background-color:rgb(189, 255, 189);">
                                                        <tr>
                                                            <th class="text-center" style="vertical-align: middle;">TITLE OF TRAINING</th>
                                                            <th class="text-center" style="vertical-align: middle;">DATE CONDUCTED</th>
                                                            <th class="text-center" style="vertical-align: middle;">CONDUCTED BY</th>
                                                            <th class="text-center" style="vertical-align: middle;">OFFICERS</th>
                                                            <th class="text-center" style="vertical-align: middle;">MEMBERS</th>
                                                            <th></th>
                                                        </tr>

                                                    </thead>

                                                    <tbody id="add_row_8">
                                                        <tr id="rw3_0">
                                                            <td><input type="text" class="form-control" name="part3_title[]"  ></td>
                                                            <td><input type="text" class="form-control" name="part3_date_conducted[]"  ></td>
                                                            <td><input type="text" class="form-control" name="part3_conducted_by[]" placeholder=""></td>
                                                            <td><input type="text" class="form-control" name="part3_officers[]"  ></td>
                                                            <td><input type="text" class="form-control" name="part3_members[]"  ></td>
                                                            <td></td>
                                                        </tr>
                                                    </tbody>

                                                    <!-- <tfoot>
                                                        <tr>
                                                            <th colspan="7"></th>
                                                        </tr>
                                                    </tfoot> -->

                                                </table>
                                                <button type="button" class="btn btn-success btn-sm" onclick="adding_rowsy()"><i class="fa fa-plus"></i> ADD</button>
                                            </div>
                                            
                                        </div>


                                        <div class="box-footer clearfix">
                                            <div class="btn-group pull-right">
                                                <button type="button" onclick="plusDivs( - 1, 2)" class="btn btn-success btn-sm" style="background-color:green">
                                                    <i class="fa fa-chevron-left"></i> Previous
                                                </button>
                                                <button type="button" onclick="plusDivs( + 1, 4)" class="btn btn-success btn-sm">
                                                    Next <i class="fa fa-chevron-right"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>


                        <div class="row form-next">
                            <div class="col-lg-12">
                                <div class="box box-success">
                                    <div class="box-body">
                                        <div class="form-group col-lg-12">
                                            <div class="row">
                                                <div class="col-lg-12 table-responsive">
                                                    <br><br>
                                                    <table class="table table-bordered">
                                                    <thead class="bg-success-custom">
                                                        <tr>
                                                            <th colspan="6" style="padding:0px;"><center style="background-color:#00a65a;padding:2px;color:white;">
                                                            <h5><b>LIST OF OFFICERS AND BOARD OF DIRECTORS</b></h5></center></th>
                                                        </tr>
                                                    </thead>
                                                        <thead style="background-color:rgb(189, 255, 189);">
                                                            <tr>
                                                                <th rowspan="3" class="text-center" style="vertical-align: middle;">FIRSTNAME</th>
                                                                <th rowspan="3" class="text-center" style="vertical-align: middle;">LASTNAME</th>
                                                                <th rowspan="3" class="text-center" style="vertical-align: middle;">MIDDLENAME</th>
                                                                <th rowspan="3" class="text-center" style="vertical-align: middle;">POSITION</th>
                                                            </tr>

                                                        </thead>

                                                        <tbody id="add_row_9">
                                                            <tr id="rw4_0">
                                                                <td><input type="text" class="form-control" id="off_bod_fname" name="off_bod_fname[]"></td>
                                                                <td><input type="text" class="form-control" id="off_bod_lname" name="off_bod_lname[]"></td>
                                                                <td><input type="text" class="form-control" id="off_bod_mname" name="off_bod_mname[]"></td>
                                                                <td><input type="text" class="form-control" name="offcrs_and_bod_position[]"></td>
                                                            </tr>
                                                        </tbody>

                                                        <tfoot>
                                                            <tr>
                                                                <th colspan="7">
                                                                <button type="button" class="btn btn-success btn-sm pull-right" onclick="adding_list()"><i class="fa fa-plus"></i> ADD</button></th>
                                                            </tr>
                                                        </tfoot>

                                                    </table>
                                                </div>
                                            </div>

                                            <div class="form-group col-lg-12" id="com_and_mems">
                                                <div class="box-header">
                                                    <center><h4><b>LIST OF COMMITTEES AND MEMBERS</b></h4></center>
                                                </div>
                                                <div class="col-lg-12 table-responsive" id="committee_members">
                                                    <table class="table table-bordered">
                                                        <thead style="background-color:#00a65a;padding:2px;color:white;">
                                                        <th colspan="2">COMMITTEE</th>
                                                        <th colspan="2"><input type="text" class="form-control custom-input-white" name="committee_type[]" placeholder="Input Committee..." ></th>
                                                        <th style="width:40px;"></th>
                                                        </thead>
                                                        <thead style="background-color:rgb(189, 255, 189);">
                                                        <tr class="text-center">
                                                        <th>FIRSTNAME</th>
                                                        <th>LASTNAME</th>
                                                        <th>MIDDLENAME</th>
                                                            <th>POSITION</th>
                                                            <th></th>
                                                        </tr>
                                                        </thead>

                                                        <tbody id="comm_tbl_0">
                                                            <tr id="comm_row_0">
                                                            <td>
                                                            <input type="hidden" name="committee_where[]" value="0_add">
                                                            <input type="text" class="form-control" name="com_mem_fname0[]"  ></td>
                                                            <td><input type="text" class="form-control" name="com_mem_lname0[]"  ></td>
                                                            <td><input type="text" class="form-control" name="com_mem_mname0[]"  ></td>
                                                                <td><select class="form-control select_brdr_btm" name="committee_pos0[]">
                                                                    <option value="1">CHAIRPERSON</option>
                                                                    <option value="2">MEMBER</option></select>
                                                                </td>
                                                                <td>
                                                                </td>
                                                            </tr>
                                                        </tbody>

                                                        <tfoot>
                                                            <tr>
                                                                <th colspan="7">
                                                                    <button type="button" class="btn btn-success btn-sm pull-right" onclick="adding_comm(0)"><i class="fa fa-plus"></i> ADD</button></th>
                                                                </tr>
                                                        </tfoot>
                                                    </table>
                                                    <br>
                                                </div>

                                                <div class="text-center" id="prep">
                                                    <button type="button" class="btn btn-success" onclick="add_committee(1)">Add committee</button>
                                                </div>
                                            </div>
                                            <div class="form-group col-lg-12" id="programs_accessed">
                                                <div class="col-lg-12 table-responsive" id="">
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
                                                            echo '<tr>
                                                                    <td class="'.$id.'">' . $i . '</td>
                                                                    <td class="'.$id.'">' . $description . '</td>
                                                                    <td class="'.$id.'"><input type="checkbox" onclick="addbg(this.value)" value="' . $id . '" name="q79[]"/></td>
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
                                                                echo '<tr>
                                                                        <td class="'.$id.'">' . $i . '</td>
                                                                        <td class="'.$id.'">' . $description . '</td>
                                                                        <td class="'.$id.'"><input type="checkbox" onclick="addbg(this.value)" value="' . $id . '" name="q95[]"/></td>
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
                                                                echo '<tr>
                                                                    <td class="'.$id.'">' . $i . '</td>
                                                                    <td class="'.$id.'">' . $description . '</td>
                                                                    <td class="'.$id.'"><input type="checkbox" onclick="addbg(this.value)" value="' . $id . '" name="q96[]"/></td>
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
                                                            echo '<tr>
                                                                <td class="'.$id.'">' . $i . '</td>
                                                                <td class="'.$id.'">' . $description . '</td>
                                                                <td class="'.$id.'"><input type="checkbox" value="' . $id . '" onclick="addbg(this.value)" name="q97[]"/></td>
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
                                                        <td colspan="5"style="background-color:rgb(189, 255, 189);" class="text-center" id="98"><strong> Partner Agencies</strong></td>
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
                                                                echo '<tr>
                                                                    <td class="'.$id.'">' . $i . '</td>
                                                                    <td class="'.$id.'">' . $description . '</td>
                                                                    <td class="'.$id.'"><input style="background-color:rgba(255, 255, 255, .0);" class="select_brdr_btm" type="text" id="' . $id . '" placeholder="&nbsp;&nbsp;&nbsp;specify" disabled name="q98_spec[]"/></td>
                                                                    <td class="'.$id.'"><input type="checkbox" onclick="enable(this.value)" value="' . $id . '" name="q98[]"/></td>
                                                                    <td class="'.$id.'"><input type="hidden" value="' . $id . ' name="q98_spec_id[]"> </td>
                                                                    </tr>';
                                                        }
                                                    }
                                                    ?>
                                                </tbody>
                                                </table>
                                                </div>
                                                
                                            </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="box-footer clearfix">
                                        <div class="btn-group pull-right">
                                            <button type="button" onclick="plusDivs( - 1, 3)" class="btn btn-success btn-sm" style="background-color:green">
                                                <i class="fa fa-chevron-left"></i> Previous
                                            </button>
                                            <button type="button" onclick="plusDivs( + 1, 5)" class="btn btn-success btn-sm">
                                                Next <i class="fa fa-chevron-right"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <div class="row form-next">
                            <div class="col-xs-12">
                                <div class="box box-success">
                                <div class="container-fluid">
                                    <div class="row">
                                            <div class="form-group">
                                                <div class="form-group col-sm-12">
                                                <center><h4>MEMBERS</h4></center>
                                                Total Land Size : <input type="text" disabled id="landsize_total" >
                                                <div class="table-responsive thisdiv" style="max-height:500px;">
                                                    <table class="table table-bordered associate_tbl">
                                                        <thead>
                                                            <tr>
                                                                <th class="">ORGS</th>
                                                                <th class="headcol1">LAST NAME</th>
                                                                <th class="headcol2">FIRST NAME</th>
                                                                <th>MIDDLE NAME</th>
                                                                <th>POSITION</th>
                                                                <th>GENDER</th>
                                                                <th>STATUS</th>
                                                                <th>ACTIVE</th>
                                                                <th>CLOA #</th>
                                                                <th>LANDSIZE</th>
                                                                <th>CROPS</th>
                                                                <th>CBU</th>
                                                                <th>MONTHLY DUE</th>
                                                                <th>PRODUCTION</th>
                                                                <th>MARKETING</th>
                                                                <th>CREDIT</th>
                                                                <th>PHF</th>
                                                                <th>MICRO ENT</th>
                                                                <th>SERVICE</th>
                                                                <th>OTHERS</th>
                                                                <th>TRAININGS ATTENDED</th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="assoc_tbl">
                                                            <tr id="assoc_0">
                                                                <td  class="" style="min-width:20px;pading-top:3em;">
                                                                    <button class="btn btn-sm btn-default show_org_count" type="button" data-toggle="modal" data-target="" >
                                                                        <span id="org_count_1">0</span>
                                                                    </button>
                                                                </td>
                                                                <td class="headcol1" >
                                                                    <input type="text" class="custom_input assoc_lastname" 
                                                                    onkeyup="checkArb($('.assoc_lastname').index(this))" name="assoc_lastname[]" id="assoc_lastname">
                                                                </td>
                                                                <td class="headcol2" >
                                                                    <input type="text" class="custom_input assoc_firstname" 
                                                                    onkeyup="checkArb($('.assoc_firstname').index(this))" name="assoc_firstname[]" id="assoc_firstname">
                                                                </td>
                                                                <td class="" >
                                                                    <input type="text" class="custom_input assoc_mi" onkeyup="checkArb($('.assoc_mi').index(this))" name="assoc_mi[]" id="assoc_mi">
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="custom_input" name="assoc_position[]" placeholder="" id="assoc_position">
                                                                </td>
                                                                <td style="min-width:150px;">
                                                                        <input type="radio" class="custom_radio_padd_sm" checked value="1" name="assoc_gender[0]" id="assoc_gender[]"> M &nbsp; 
                                                                        <input type="radio" class="custom_radio_padd_sm" value="0" name="assoc_gender[0]" id="assoc_gender[]"> F
                                                                </td>
                                                                <td>
                                                                    <select class="select_brdr_btm assoc_arb_type vldt_arb" name="assoc_arb_type[]" onchange="validate_arb()">
                                                                        <option value="1">ARB</option>
                                                                        <option value="0">NON-ARB</option>
                                                                        <option value="2">HH-ARB</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <input type="checkbox" name="assoc_status[]" id="assoc_status" value="1">
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="custom_input assoc_cloa_number fill_cloa" name="assoc_cloa_number[]"
                                                                    onkeyup="validate_arb()" id="assoc_cloa_number">
                                                                </td>
                                                                <td>
                                                                    <input type="number" class="custom_input landsize assoc_landsize fill_land"
                                                                    onkeyup="add_land()" onkeydown="validate_arb()" name="assoc_landsize[]">
                                                                </td>
                                                                <!-- review -->
                                                                <td>
                                                                    <input type="text" class="custom_input_lg assoc_crop fill_crop" onkeyup="validate_arb()" name="assoc_crop[]" id="assoc_crop">
                                                                </td>
                                                                <td>
                                                                    <input type="checkbox" name="assoc_cbu[]" id="assoc_cbu" value="1">
                                                                </td>
                                                                <td>
                                                                    <input type="checkbox" class="custom_input_lg" value="1" name="assoc_saving[]" id="assoc_saving">
                                                                </td>
                                                                <td>
                                                                    <input type="checkbox" name="assoc_production[]" id="assoc_production" value="1">
                                                                </td>
                                                                <td>
                                                                    <input type="checkbox" name="assoc_mrktng[]" id="assoc_mrktng" value="1">
                                                                </td>
                                                                <td>
                                                                    <input type="checkbox" name="assoc_credit[]" id="assoc_credit" value="1">
                                                                </td>
                                                                <td>
                                                                    <input type="checkbox" name="assoc_phf[]" id="assoc_phf" value="1">
                                                                </td>
                                                                <td>
                                                                    <input type="checkbox" name="assoc_micro[]" id="assoc_micro" value="1">
                                                                </td>
                                                                <td>
                                                                    <input type="checkbox" name="assoc_srvce[]" id="assoc_srvce" value="1">
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="custom_input_lg" name="assoc_others[]" id="assoc_others">
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="custom_input_lg" placeholder="kindly put > after every new trainings" name="assoc_train_attended[]" id="assoc_train_attended">
                                                                </td>
                                                                <td></td>
                                                            </tr>

                                                        </tbody>
                                                    </table>

                                                </div>
                                                <button class="btn btn-success btn-sm pull-left" type="button" style="margin-top:0.5em;" onclick="add_association_mem()">
                                                                    <span class="glyphicon glyphicon-plus">
                                                </span> ADD
                                                </button>
                                                <br><br><br><br>
                                                <div class="container">
                                                 
                                                </div>
                                            </div>




                                    </div>
                                    </div>
                                    <div class="container">
                                    <center>
                                    
                                    <button type="submit" name="submit" class="btn btn-success" form="submit_form" id="save" disabled >
                                        <i class="fa fa-save"></i> Save
                                    </button>
                                    </center>
                                    </div>
                                    <br><br>
                                    <div class="box-footer clearfix">


                                        <div class="btn-group pull-right">
                                            <button type="button" onclick="plusDivs( - 1, 4)" class="btn btn-primary btn-sm" style="background-color:green">
                                                <i class="fa fa-chevron-left"></i> Previous
                                            </button>
                                        </div>
                                    </div>
                                    </form>
                                </div>
                                <!-- /.box -->
                            </div>
                            <!-- /.col -->
                        </div>

                    </section>
                </div>
            <!------------------================End of a Form====================-------------------------------->
            <!-- Main content -->

            <!-- /.content -->
        </div>
    </div>


    <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<?php include 'inc/scripts.php';?>
<script src="../js/arbo-form.js"></script>
<script src="../js/adding-form-js.js"></script>
<script>
    function enable(id){
        $('#' + id).removeAttr('disabled', 'disabled');
        $('.' + id).toggleClass('addbgcolor');
    }
    function addbg(val) {
        $('.' + val).toggleClass('addbgcolor');
    }
    $('.removethis').click(function(){
        $(this).parents('tr').first().remove();
    });

    var trs;
    var other_mem = 0;
    function add_services(cust_class, field_name1, id, field_name2, field_name3, field_name4){
        trs = `<tr id="other_${other_mem}">
                <td><input type="text" class="form-control" name="${id}_${field_name1}" placeholder="Please Specify"></td>
                <td>
                <input type="hidden" name="oth_${field_name1}" value="${id}">
                <input type="text" class="form-control" name="${field_name2}"   ></td>
                <td><input type="text" class="form-control" name="${field_name3}"  ></td>
                <td><input type="text" class="form-control" name="${field_name4}"  >
                <td><button type="button" onclick="removez('other_${other_mem}')" class="btn btn-sm btn-danger btn-sm removethis">-</button></td>
                </td>
            </tr>`;
        $(`.${cust_class}`).last().append(trs);
        other_mem++;
    }

// var sum = 0;
// function add_land(val) {
//     if($(this).val() != "") {
//         sum += parseFloat($(this).val());   
//     }
//     console.log(sum);
// }
        // $(".landsize").keyup(function(){
            function add_land() {
            var sum=0;
            $(".landsize").each(function() {
                if($(this).val() != "") {
                    sum += parseFloat(Number($(this).val()));   
                }
                $("#landsize_total").val(sum);
            });
            $("#landsize_total").val(sum);
        }

    var flag1_ = 0;
    var flag2_ = 0;
    var flag3_ = 0;

    validate_arb();

    function validate_arb() {
        $("#assoc_tbl .assoc_arb_type").each(function(i) {
            if($(this).val() == 1) {
                $(this).addClass('vldt_arb');
                $(this).closest('tbody#assoc_tbl ').find('input[name="assoc_cloa_number"]').addClass('fill_cloa');
                $('.assoc_cloa_number').eq(i).addClass('fill_cloa');
                $('.assoc_crop').eq(i).addClass('fill_crop');
                $('.assoc_landsize ').eq(i).addClass('fill_land');
                
                //check if or 1 ang 0 i return
                flag1_ = vldt_cloa($('.fill_cloa').length);
                flag2_ = vldt_lnd($('.fill_crop').length);
                flag3_ = vldt_crop($('.fill_land').length);
                // alert(flag1_ + 'f1 ' + flag2_ + 'f2 ' flag3_);
                // console.log('w ' + flag1_ + flag2_ + flag3_);
                if(flag1_ == 0 && flag2_ == 0 && flag3_ == 0 && $('#org_exist').length == 0 && $.trim($('#part1_arbo_name').val()) != '' ) {
                    $('#save').removeAttr('disabled','disabled');
                    
                } else {
                    $('#save').attr('disabled', 'disabled');
                }
            } else {
                $(this).removeClass('vldt_arb');
                $('.assoc_cloa_number').eq(i).removeClass('fill_cloa');
                $('.assoc_crop').eq(i).removeClass('fill_crop');
                $('.assoc_landsize ').eq(i).removeClass('fill_land');

                flag1_ = vldt_cloa($('.fill_cloa').length);
                flag2_ = vldt_lnd($('.fill_crop').length);
                flag3_ = vldt_crop($('.fill_land').length);
                // console.log('w/o ' + flag1_ + flag2_ + flag3_);
                if(flag1_ == 0 && flag2_ == 0 && flag3_ == 0 && $('#org_exist').length == 0 && $.trim($('#part1_arbo_name').val()) != '') {
                    $('#save').removeAttr('disabled','disabled');
                } else {
                    $('#save').attr('disabled' , 'disabled');
                }
            }
            // check_cloa();
        });
    }



// checker if ang gina return kay 1 or 0
// ang i kay length sang tanan nga input nga may fill cloa
function vldt_cloa(i) {
    var fl1 =  0;
    for(var j = 0; j < i ; j++) {
        if($('.fill_cloa').eq(j).val() == '') {
            // kng ang cloa kay 1 ma end na ang loop
            fl1 = 1;
            break;
        } else {
            if(j == (i - 1) && fl1 == 0) {
                fl1 = 0;
            }
        }
    }
    return fl1;
}

function vldt_crop(i) {
    var fl2  = 0;
    for(var j = 0; j < i ; j++) {
        if($('.fill_crop').eq(j).val() == '') {
            fl2 = 1;
            break;
        } else {
            if(j == (i - 1) && fl2 == 0) {
                fl2 = 0;
            }
        }
    }
    return fl2;
}

function vldt_lnd(i) {
    var fl3 = 0;
    for(var j = 0; j < i ; j++) {
        if($('.fill_land').eq(j).val() == '') {
            fl3 = 1;
            break;
        } else {
            if(j == (i - 1) && fl3 == 0) {
                fl3 = 0;
            }
        }
    }
    return fl3;
}
function checkArb(index) {
    var fname = $('.assoc_firstname').eq(index).val();
    var lname = $('.assoc_lastname').eq(index).val();
    var mi = $('.assoc_mi').eq(index).val();
    // var index = $(this).index('.assoc_firstname');
    // index = $(".assoc_firstname").index(this);
    $('.assoc_firstname').eq(index).val()
    $.post('controller/show_mem_org.php', {
        fname : fname,
        lname : lname,
        mi : mi
    } , function(data,status) {
        $('.show_org_count').eq(index).replaceWith(data);
    });
}

    $('#part1_arbo_name').keyup(function() {
        validate_arb();
        var part1_arbo_name = $('#part1_arbo_name').val();
        $.post('controller/check_po_profile.php' , {
            part1_arbo_name : part1_arbo_name
        } , function(data, status) {
            if(data != 0) {
                $('#org_error').replaceWith(data);
                $('#part1_arbo_name').css({"border-bottom" : "1px solid red"});
                $('#jump1,#part1,#part2,#part3,#part4,#part5,#save').attr("disabled");

            } else {
                $('#org_exist').replaceWith('<p id="org_error"></p>'); 
                $('#part1_arbo_name').css({"border-bottom" : "1px solid gray"});
                $('#jump1,#part1,#part2,#part3,#part4,#part5').removeAttr("disabled","disabled");
            }
        });
    });
</script>
</body>
</html>
<?php } else {
    header('Location:../index.php');
}?>