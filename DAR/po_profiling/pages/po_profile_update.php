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
        <title>PPS | PO Profile Update</title>
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
            .select_brdr_btm {
                border:0px;
                border-bottom:1px solid gray;
            }
            .select_brdr_btm:focus {
                outline:none;
                border-bottom:1.5px solid green;
            }
            .select_brdr_btm: {
                background-color:rgba(255,255,255,0.1);
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
            input[type="text"]:  , input[type="number"]: , input[type="date"]: {
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
            .addbgcolor {
                background-color:rgba(212, 204, 204, .5);
                font-weight:bold;
            }
            .user-panel {
                background-image:url('../public/img/dar-bg.png');
                height:100px;
            }
            .headcol , .headcol1, .headcol2, .headcol3, .headcol4 {
                position:sticky;
                background-color:white;
            }

            .headcol1 { 
                left:0px;
            }
            .headcol2 {
                left:188.8px;
            }
            input[type="number"]:disabled{
                background-color:white;
            }
            #landsize_total{
                text-align: center;
            }
            #landsize_total{
                background-color:rgba(255,255,255,.0);
                border:0px;
                border-bottom:1px solid gray;
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
            $page = 'edit';
            include 'inc/header.php';
            include 'inc/sidebar.php';
            $count = 0;
                $org_id = isset($_GET['id']) ? $_GET['id'] : 0;
            ?>

            <!-- Content Wrapper. Contains page content -->
            <form action="controller/update_process.php" role="form" novalidate id="submit_form" name="submit_form" method="post" enctype="multipart/form-data">
            <div class="content-wrapper">
                <section class="content-header">
                    <a href="po_profile_search.php"><button class="btn btn-success btn-sm" type="button">
                    <i class="fa fa-arrow-circle-left"></i> Back</button></a>
                    <span style="font-size:20px;">ARBO PROFILE</span>
                    <ol class="breadcrumb" id="abc">
                    </ol>
                </section>  
                <!-- Main content -->
                <section class="content">
                    <div class="row form-next">
                        <div class="col-xs-12">
                            <div class="box box-success">
                                <div class="box-body">

                                    <div class="form-group col-sm-12">
                                    
                                        <div class="form-group inside-div">
                                            <center><h3><label>PO PROFILE</label></h3></center>
                                            <div class="row">
                                            <?php
                                                $sql_arbo_profile = 'SELECT * FROM arbo_profile where id = ?';
                                                $run_sql_arbo_profile = $conn->prepare($sql_arbo_profile);
                                                $run_sql_arbo_profile->bind_param('i' , $org_id);
                                                $run_sql_arbo_profile->execute();
                                                $run_sql_arbo_profile->bind_result($id ,$name , $as_of_date, $form_image, $acronym ,
                                                    $arbo_province , $arbo_city, $arbo_brgy, $arbo_addr_others,
                                                    $area_of_operation_prov, $area_of_operation_city, $area_of_operation_brgy,
                                                    $area_of_operation_others, $contact_person, $date_organized,
                                                    $date_registered, $registration_no, $agency_registered,
                                                    $type_of_organization, $affiliation, $date_created, $date_updated);
                                                $run_sql_arbo_profile->store_result();
                                                $run_sql_arbo_profile->num_rows();
                                                $run_sql_arbo_profile->fetch();

                                                //assisting organization
                                                $sql_arbo_or_org_assist = 'SELECT id, name_of_ngo_assisting, ngo_year_assisted
                                                from arbo_ngo_or_org_assist where arbo_profile_id = ?';
                                                $run_sql_arbo_or_org_assist = $conn->prepare($sql_arbo_or_org_assist);
                                                $run_sql_arbo_or_org_assist->bind_param('i' , $org_id);
                                                $run_sql_arbo_or_org_assist->execute();
                                                $run_sql_arbo_or_org_assist->bind_result($org_assist_id, $org_assstng, $org_yr_asstng);
                                                $run_sql_arbo_or_org_assist->store_result();

                                                $area_of_operation = $area_of_operation_brgy . ', '.
                                                $area_of_operation_city  . ', ' . $area_of_operation_prov;

                                                if(!empty($area_of_operation_others)) {
                                                    $area_of_operation = $area_of_operation_others . ', ' . $area_of_operation_brgy . ', '.
                                                    $area_of_operation_city  . ', ' . $area_of_operation_prov;
                                                }
                                                $arbo_address = $arbo_brgy . ', ' . $arbo_city . ', ' . $arbo_province;
                                                if(!empty($arbo_addr_others)) {
                                                    $arbo_address =  $arbo_addr_others . ', ' .$arbo_brgy . ', ' .
                                                     $arbo_city . ', ' . $arbo_province;
                                                }
                                                
                                                ?>
                                                <center style="margin-bottom:1.5em;"><h1></h1></center>
                                                <div class="form-group">
                                                <div class="form-group">
                                                    <div class="col-lg-2">
                                                        <label for="" class="this_label"> As of  </label>
                                                        <input type="hidden" name="prof_id" id="prof_id" value="<?php echo $org_id ; ?>">
                                                        <input type="text" class="form-control this_input"   name="part1_arbo_of" id="part1_arbo_of" value="<?php echo $as_of_date ; ?>">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-lg-4">
                                                        <label for="" class="this_label"> ORGANIZATION </label>
                                                        <input type="text" class="form-control this_input"   name="part1_arbo_name" id="part1_arbo_name" value="<?php echo $name ; ?>">
                                                        <p id="org_error"></p>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-lg-4">
                                                        <label for="" class="this_label"> ACRONYM </label>
                                                        <input type="text" class="form-control this_input"   name="part1_acro_name" id="part1_acronym" value="<?php echo $acronym ; ?>">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-lg-2">
                                                        <label for="" class="this_label">REGISTRATION IMAGE</label><br>
                                                        <input type="file" class="form-control" name="arbo_form_image" id="arbo_form_image">
                                                    </div>
                                                </div>
                                                <div class="form-group col-sm-12">
                                                    <label>ARBO ADDRESS: </label>
                                                </div>
                                                <div class="form-group col-sm-3 col-md-3 col-sm-6">
                                                    <label for="ope_prov">PROVINCE</label>
                                                    <select class="form-control select_brdr_btm" id="arbo_province" name="arbo_province" required>
                                                        <option value="Negros Occidental" selected>Negros Occidental</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-sm-3 col-md-3 col-sm-6">
                                                    <label for="ope_municipal">MUNICIPALITY</label>
                                                    <select class="form-control select_brdr_btm" id="arbo_municipal" name="arbo_municipal" onchange="show_barangay()">
                                                        <option value="<?php echo $arbo_city ; ?>"><?php echo $arbo_city ; ?></option>
                                                        
                                                    </select>
                                                </div>

                                                <div class="form-group col-sm-3 col-md-3 col-sm-6">
                                                    <label for="ope_brgy">BARANGAY</label>
                                                    <select class="form-control select_brdr_btm" id="arbo_barangay" name="arbo_barangay" required>
                                                        <option value="<?php echo $arbo_brgy ; ?>"><?php echo $arbo_brgy ; ?></option>
                                                    </select>
                                                </div>

                                                <div class="form-group col-sm-3 col-md-3 col-sm-6">
                                                    <label>D. SITIO/PUROK/STREET</label>
                                                    <input type="text" class="form-control" name="arbo_sps" id="arbo_sps" value="<?php echo $arbo_addr_others ; ?>">
                                                </div>

                                                <div class="form-group col-sm-12">
                                                    <label>AREA OF OPERATION: </label>
                                                </div>
                                                
                                                <div class="form-group col-lg-3 col-md-3 col-sm-6">
                                                    <label for="ope_prov">PROVINCE</label>
                                                    <select class="form-control select_brdr_btm" id="ope_prov"  name="ope_prov" required>
                                                        <option value="Negros Occidental" selected>Negros Occidental</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-lg-3 col-md-3 col-sm-6">
                                                    <label for="ope_municipal">MUNICIPALITY</label>
                                                    <select class="form-control select_brdr_btm" id="ope_city" onchange="show_ope_barangay()"  name="ope_city" required onchange="municipal1()">
                                                        <option value="<?php echo $area_of_operation_city ; ?>"><?php echo $area_of_operation_city ; ?></option>
                                                        <?php
                                                            $sql_city = 'SELECT city from city where city != ? order by city asc';
                                                            $run_sql_city = $conn->prepare($sql_city);
                                                            $run_sql_city->bind_param('s', $area_of_operation_city);
                                                            $run_sql_city->execute();
                                                            $run_sql_city->bind_result($city);
                                                            $run_sql_city->store_result();
                                                            if($run_sql_city->num_rows() > 0) {
                                                                while($run_sql_city->fetch()) {
                                                                    echo '<option value="'.$city.'">'.$city.'</option>';
                                                                }
                                                            }
                                                        ?>
                                                    </select>
                                                </div>

                                                <div class="form-group col-sm-6 col-md-3 col-lg-3">
                                                    <label for="ope_brgy">BARANGAY</label>
                                                    <select class="form-control select_brdr_btm" id="ope_brgy"  name="ope_brgy" required>
                                                        <option value="<?php echo $area_of_operation_brgy ; ?>"><?php echo $area_of_operation_brgy ; ?></option>
                                                        <?php
                                                            $sql = 'SELECT distinct(brgy) from barangay where brgy != ? order by brgy asc';
                                                            $run_sql = $conn->prepare($sql);
                                                            $run_sql->bind_param('s' , $area_of_operation_brgy);
                                                            $run_sql->execute();
                                                            $run_sql->bind_result($brgy);
                                                            $run_sql->store_result();
                                                            if($run_sql->num_rows() > 0) {
                                                                while($run_sql->fetch()) {
                                                                    echo '<option value="'.$brgy.'">'.$brgy.'</option>';
                                                                }
                                                            }
                                                        ?>
                                                    </select>
                                                </div>

                                                <div class="form-group col-sm-6 col-md-3 col-lg-3">
                                                    <label>D. SITIO/PUROK/STREET</label>
                                                    <input type="text" class="form-control" name="ope_sps" id="ope_sps" value="<?php echo $area_of_operation_others ; ?>">
                                                </div>

                                                <div class="form-group">

                                                    <div class="col-lg-4">
                                                        <label for="" class="this_label">CONTACT PERSON</label>
                                                        <input type="text" class="form-control this_input" name="contact_person" id="contact_person" value="<?php echo $contact_person ; ?>">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-lg-4">
                                                        <label for="" class="this_label"> DATE ORGANIZED </label>
                                                        <input type="text" class="form-control this_input" name="date_organized" id="date_organized" value="<?php echo $date_organized ; ?>">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-lg-4">
                                                        <label for="" class="this_label"> DATE REGISTERED </label>
                                                        <input type="text" class="form-control this_input" name="date_reg" id="date_reg" value="<?php echo $date_registered ; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div><br></div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-lg-6">
                                                        <label for="" class="this_label"> REGISTRATION NO. </label>
                                                        <input type="text" class="form-control this_input"  name="reg_num" id="reg_num" value="<?php echo $registration_no ; ?>">
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <div class="col-lg-6">
                                                        <label for="" class="this_label"> AGENCY/ENTITY REGISTERED </label>
                                                        <input type="text" class="form-control this_input" name="agency_registered" id="agency_registered" value="<?php echo $agency_registered ; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div><br></div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-lg-6">
                                                        <label for="" class="this_label"> TYPE OF ORGANIZATION </label>
                                                        <input type="text" class="form-control this_input" name="organization_type" id="organization_type" value="<?php echo $type_of_organization ; ?>">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-lg-6">
                                                        <label for="" class="this_label"> AFFILIATION </label>
                                                        <input type="text" class="form-control this_input" name="affliation" id="affliation" value="<?php echo $affiliation ; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 table-responsive">
                                                <br><br><br>
                                                    
                                                    <?php
                                                    $sql_membership = 'SELECT  total_arb_male , total_arb_female,  total_non_arb_male,
                                                    total_non_arb_female, male_hh_arb, female_hh_arb
                                                    FROM arbo_membership WHERE ARBO_PROFILE_ID = ?';
                                                    $run_sql_membership = $conn->prepare($sql_membership);
                                                    $run_sql_membership->bind_param('i' , $org_id);
                                                    $run_sql_membership->execute();
                                                    $run_sql_membership->bind_result($arb_male, $arb_female, 
                                                    $non_arb_male,  $non_arb_female, $male_hh_arb, $female_hh_arb );
                                                    $run_sql_membership->store_result();
                                                    $run_sql_membership->num_rows();
                                                    $run_sql_membership->fetch();
                                                    $total_arb = $arb_male + $arb_female;
                                                    $total_non_arb = $non_arb_male + $non_arb_female;
                                                    $total_hh_arb = $male_hh_arb +$female_hh_arb;
                                                    ?>
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
                                                                <td><input type="number" min="0" class="form-control" name="part3_arb1_members" disabled value="<?php echo $total_arb; ?>" id="part3_arb1_members"  placeholder="Enter..."  ></td>
                                                                <td>MALE</td>
                                                                <td><input type="number" min="0" class="form-control" name="part3_arb1_male" id="part3_arb1_male" value="<?php echo $arb_male?>" onkeyup="sumMale()" placeholder="Enter..."  ></td>
                                                                <td>FEMALE</td>
                                                                <td><input type="number" min="0" class="form-control" name="part3_arb1_female" id="part3_arb1_female" value="<?php echo $arb_female?>" onkeyup="sumFemale()" placeholder="Enter..."  ></td>
                                                            </tr>
                                                        </thead>

                                                        <thead>
                                                            <tr>
                                                                <td>NON-ARB</td>
                                                                <td><input type="number" min="0" class="form-control" name="part3_arb2_members" disabled id="part3_arb2_members" value="<?php echo $total_non_arb; ?>"  placeholder="Enter..."  ></td>
                                                                <td>MALE</td>
                                                                <td><input type="number" min="0" class="form-control" name="part3_arb2_male" id="part3_arb2_male" value="<?php echo $non_arb_male?>" onkeyup="sumMale()" placeholder="Enter..."  ></td>
                                                                <td>FEMALE</td>
                                                                <td><input type="number" min="0" class="form-control" id="part3_arb2_female" name="part3_arb2_female" value="<?php echo $non_arb_female?>" onkeyup="sumFemale()" placeholder="Enter..."  ></td>
                                                            </tr>
                                                        </thead>

                                                        <thead>
                                                            <tr>
                                                                <td>ARB-HH</td>
                                                                <td><input type="number" min="0" class="form-control" name="total_hh_arb" id="total_hh_arb" disabled value="<?php echo $total_hh_arb; ?>" placeholder="Enter..."  ></td>
                                                                <td>MALE</td>
                                                                <td><input type="number" min="0" class="form-control" name="male_hh_arb" id="male_hh_arb" value="<?php echo $male_hh_arb; ?>" onkeyup="sumMale()"  placeholder="Enter..."  ></td>
                                                                <td>FEMALE</td>  
                                                                <td><input type="number" min="0" class="form-control" name="female_hh_arb" id="female_hh_arb" onkeyup="sumFemale()" value="<?php echo $female_hh_arb; ?>"placeholder="Enter..."  ></td>
                                                            </tr>
                                                        </thead>

                                                        <thead>
                                                            <tr>
                                                                <td>TOTAL </td>
                                                                <td><input type="number" min="0" disabled  class="form-control" name="part3_total_members" id="part3_total_members"
                                                                    value=""></td>
                                                                <td>TOTAL MALE</td>
                                                                <td><input type="number" min="0" disabled  class="form-control" name="part3_total_male" id="part3_total_male" 
                                                                value="" ></td>
                                                                <td>TOTAL FEMALE</td>
                                                                <td><input type="number" min="0"  disabled  class="form-control" name="part3_total_female" id="part3_total_female"
                                                                value="<?php echo $arb_female + $non_arb_female + $female_hh_arb;?>"></td>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                                
                                            </div>  


                                        </div>

                                    </div>

                                </div>

                                <div class="box-footer clearfix">
                                    <button type="button" onclick="plusDivs( + 1, 2)" class="btn btn-success btn-sm pull-right" id="addorupdate" form="add_francise_form">
                                        Next <i class="fa fa-chevron-right"></i>
                                    </button>
                                </div>
                                
                            </div>
                        </div>
                    </div></div>
                    <div class="row form-next">
                        <div class="col-xs-12">
                            <div class="box box-success">
                            <div class="box-header with-border text-center">
                                        <h4><b>CURRENT SERVICES PROVIDED</b></h4>
                                    </div>
                                <div class="box-body">

                                    <div class="form-group col-sm-12">

                                        <div class="form-group inside-div">

                                            <div class="form-group col-sm-12">

                                                <?php
                                                $count_services = 0;
                                                    $serv_type = array(1,2,3,4,5);
                                                    $sql_services = 'SELECT distinct(sub.description) ,sub.id, srvce_prvded.units_or_heads
                                                    , srvce_prvded.client_served_members, srvce_prvded.client_served_non_members
                                                    from arbo_services_provided as srvce_prvded
                                                    inner join arbo_service_sub as sub on sub.id = srvce_prvded.arbo_service_sub_id
                                                    inner join arbo_sevice_main as main on main.id = sub.arbo_service_main_id
                                                    where srvce_prvded.arbo_profile_id = ? and  main.id = ?';
                                                ?>
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
                                                            <th></th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        <tr style="background-color:rgb(189, 255, 189);">
                                                            <td colspan="12"><b>Pre Harvest Facilities</b></td>
                                                        </tr>
                                                    </tbody>

                                                    <tbody class="pre_hrvst_fcl">
                                                        <?php
                                                        $sql = 'SELECT id,description FROM arbo_service_sub WHERE arbo_service_main_id = ? order by id ASC';
                                                        $serv_id1 = array();
                                                        $serv_desc1 = array();
                                                        
                                                        $run_sql = $conn->prepare($sql);
                                                        $run_sql->bind_param('i',$serv_type[0]);
                                                        $run_sql->execute();
                                                        $run_sql->bind_result($id, $desc);
                                                        $run_sql->store_result();
                                                        if($run_sql->num_rows() > 0) {
                                                            while($run_sql->fetch()) {
                                                                array_push($serv_id1, $id);
                                                                array_push($serv_desc1, $desc);
                                                            }
                                                        }

                                                        $run_sql_srvcs_prov = $conn->prepare($sql_services);
                                                        $run_sql_srvcs_prov->bind_param('is',$org_id, $serv_type[0]);
                                                        $run_sql_srvcs_prov->execute();
                                                        $run_sql_srvcs_prov->bind_result($type_desc , $sub_id, $units_or_heads, $cs_member, $cs_non_member);
                                                        $run_sql_srvcs_prov->store_result();
                                                        $i = 0;
                                                        if($run_sql_srvcs_prov->num_rows() > 0) {
                                                        while($run_sql_srvcs_prov->fetch()) {
                                                            if($sub_id == $serv_id1[$i] && (!empty($units_or_heads) || !empty($cs_member) ||!empty($cs_non_member)) && $i < 3) {
                                                                echo '<tr>
                                                                        <td>'.$type_desc.'</td>
                                                                        <td><input type="hidden" name="pre_harv_id[]" value="'.$sub_id.'">
                                                                        <input type="text" class="form-control" value="'.$units_or_heads.'" name="pre_harv_units[]"  ></td>
                                                                        <td><input type="text" class="form-control" value="'.$cs_member.'" name="pre_harv_mem[]"  ></td>
                                                                        <td><input type="text" class="form-control" value="'.$cs_non_member.'" name="pre_harv_nonmem[]"  ></td>
                                                                        <td></td>
                                                                    </tr>';
                                                            } else if($i < 3) {
                                                                echo '<tr>
                                                                        <td>'.$serv_desc1[$i]. '</td>
                                                                        <td><input type="hidden" name="pre_harv_id[]" value="'.$sub_id.'">
                                                                        <input type="text" class="form-control" value="'.$units_or_heads.'" name="pre_harv_units[]"  ></td>
                                                                        <td><input type="text" class="form-control" value="'.$cs_member.'" name="pre_harv_mem[]"  ></td>
                                                                        <td><input type="text" class="form-control" value="'.$cs_non_member.'" name="pre_harv_nonmem[]"  ></td>
                                                                        <td></td>
                                                                </tr>';
                                                            } else {
                                                                echo '<tr>
                                                                            <td>'.$type_desc. '</td>
                                                                            <td><input type="hidden" name="pre_harv_id[]" value="'.$sub_id.'">
                                                                            <input type="text" class="form-control" value="'.$units_or_heads.'" name="pre_harv_units[]"  ></td>
                                                                            <td><input type="text" class="form-control" value="'.$cs_member.'" name="pre_harv_mem[]"  ></td>
                                                                            <td><input type="text" class="form-control" value="'.$cs_non_member.'" name="pre_harv_nonmem[]"  ></td>
                                                                            <td><button type="button" class="btn btn-sm btn-danger btn-sm removethis">-</button></td>
                                                                    </tr>';
                                                                
                                                            }
                                                            
                                                            $i++;
                                                        }

                                                        } else {
                                                            for($i = 0 ; $i < count($serv_id1) ; $i++) {
                                                                echo '<tr>
                                                                            <td>'.$serv_desc1[$i]. '</td>
                                                                            <td><input type="hidden" name="pre_harv_id[]" value="'.$serv_id1[$i].'">
                                                                            <input type="text" class="form-control" name="pre_harv_units[]"  ></td>
                                                                            <td><input type="text" class="form-control" name="pre_harv_mem[]"  ></td>
                                                                            <td><input type="text" class="form-control" name="pre_harv_nonmem[]"  ></td>
                                                                            <td></td>
                                                                    </tr>';
                                                            }
                                                        }

                                                        $run_sql_srvcs_prov->close();
                                                        ?>
                                                    </tbody>
                                                    <tr><td colspan="12"><button class="btn btn-success btn-sm" type="button"
                                                    onclick="add_services('pre_hrvst_fcl','pre_harv_id[]',<?php echo $serv_type[0]; ?>,'pre_harv_units[]','pre_harv_mem[]','pre_harv_nonmem[]')">
                                                    Other Services</button></td></tr>
                                                    <tbody>
                                                        <tr style="background-color:rgb(189, 255, 189);">
                                                            <td colspan="12"><b>Livestock</b></td>
                                                        </tr>
                                                    </tbody>

                                                    <tbody class="lvstck">
                                                        <?php
                                                        $serv_id2 = array();
                                                        $serv_desc2 = array();
                                                        
                                                        $run_sql = $conn->prepare($sql);
                                                        $run_sql->bind_param('i',$serv_type[1]);
                                                        $run_sql->execute();
                                                        $run_sql->bind_result($id, $desc);
                                                        $run_sql->store_result();
                                                        if($run_sql->num_rows() > 0) {
                                                            while($run_sql->fetch()) {
                                                                array_push($serv_id2, $id);
                                                                array_push($serv_desc2, $desc);
                                                            }
                                                        }
                                                        $run_sql_srvcs_prov = $conn->prepare($sql_services);
                                                        $run_sql_srvcs_prov->bind_param('is',$org_id, $serv_type[1]);
                                                        $run_sql_srvcs_prov->execute();
                                                        $run_sql_srvcs_prov->bind_result($type_desc ,$sub_id, $units_or_heads, $cs_member, $cs_non_member);
                                                        $run_sql_srvcs_prov->store_result();
                                                        $i = 0;
                                                        if($run_sql_srvcs_prov->num_rows() > 0) {
                                                        while($run_sql_srvcs_prov->fetch()){
                                                        if($sub_id == $serv_id2[$i] && (!empty($units_or_heads) || !empty($cs_member) ||!empty($cs_non_member)) && $i < 4) {
                                                            echo '<tr>
                                                                    <td>'.$type_desc.'</td>
                                                                    <td><input type="hidden" name="livestock[]" value="'.$sub_id.'">
                                                                    <input type="text" class="form-control" value="'.$units_or_heads.'" name="livestock_unit[]"  ></td>
                                                                    <td><input type="text" class="form-control" value="'.$cs_member.'" name="livestock_mem[]"  ></td>
                                                                    <td><input type="text" class="form-control" value="'.$cs_non_member.'" name="livestock_nonmem[]"  ></td>
                                                                    <td></td>
                                                                </tr>';
                                                        } else if($i < 4){
                                                            echo '<tr>
                                                                    <td>'.$serv_desc2[$i]. '</td>
                                                                    <td><input type="hidden" name="livestock[]" value="'.$sub_id.'">
                                                                    <input type="text" class="form-control" value="'.$units_or_heads.'" name="livestock_unit[]"  ></td>
                                                                    <td><input type="text" class="form-control" value="'.$cs_member.'" name="livestock_mem[]"  ></td>
                                                                    <td><input type="text" class="form-control" value="'.$cs_non_member.'" name="livestock_nonmem[]"  ></td>
                                                                    <td></td>
                                                            </tr>';
                                                        } else {
                                                            echo '<tr>
                                                                    <td>'.$type_desc.'</td>
                                                                    <td><input type="hidden" name="livestock[]" value="'.$sub_id.'">
                                                                    <input type="text" class="form-control" value="'.$units_or_heads.'" name="livestock_unit[]"  ></td>
                                                                    <td><input type="text" class="form-control" value="'.$cs_member.'" name="livestock_mem[]"  ></td>
                                                                    <td><input type="text" class="form-control" value="'.$cs_non_member.'" name="livestock_nonmem[]"  ></td>
                                                                    <td><button type="button" class="btn btn-sm btn-danger btn-sm removethis">-</button></td>
                                                                </tr>';
                                                        }
                                                        
                                                        $i++;
                                                        }

                                                        } else {
                                                            for($i = 0 ; $i < count($serv_id2) ; $i++) {
                                                                echo '<tr>
                                                                            <td>'.$serv_desc2[$i]. '</td>
                                                                            <td><input type="hidden" name="livestock[]" value="'.$sub_id.'">
                                                                            <input type="text" class="form-control" name="livestock_unit[]"  ></td>
                                                                            <td><input type="text" class="form-control" name="livestock_mem[]"  ></td>
                                                                            <td><input type="text" class="form-control" name="livestock_nonmem[]"  ></td>
                                                                    </tr>';
                                                            }
                                                        }

                                                        $run_sql_srvcs_prov->close();
                                                        ?>
                                                    </tbody>
                                                    <tr><td colspan="12"><button class="btn btn-success btn-sm" type="button"
                                                        onclick="add_services('lvstck','livestock[]',<?php echo $serv_type[1]; ?>,'livestock_unit[]','livestock_mem[]','livestock_nonmem[]')">
                                                    Other Services</button></td></tr>
                                                    <tbody>
                                                        <tr style="background-color:rgb(189, 255, 189);">
                                                            <td colspan="12"><b>Poultry / Broiler Raising</b></td>
                                                        </tr>
                                                    </tbody>

                                                    <tbody class="pltry">

                                                        <?php

                                                        $serv_id3 = array();
                                                        $serv_desc3 = array();

                                                        $run_sql = $conn->prepare($sql);
                                                        $run_sql->bind_param('i',$serv_type[2]);
                                                        $run_sql->execute();
                                                        $run_sql->bind_result($id, $desc);
                                                        $run_sql->store_result();
                                                        if($run_sql->num_rows() > 0) {
                                                            while($run_sql->fetch()) {
                                                                array_push($serv_id3, $id);
                                                                array_push($serv_desc3, $desc);
                                                            }
                                                        }
 
                                                        $run_sql_srvcs_prov = $conn->prepare($sql_services);
                                                        $run_sql_srvcs_prov->bind_param('is',$org_id, $serv_type[2]);
                                                        $run_sql_srvcs_prov->execute();
                                                        $run_sql_srvcs_prov->bind_result($type_desc ,$sub_id, $units_or_heads, $cs_member, $cs_non_member);
                                                        $run_sql_srvcs_prov->store_result();

                                                        $i = 0;
                                                        if($run_sql_srvcs_prov->num_rows() > 0) {
                                                        while($run_sql_srvcs_prov->fetch()){
                                                        if($sub_id == $serv_id3[$i] && (!empty($units_or_heads) || !empty($cs_member) ||!empty($cs_non_member)) && $i < 3) {
                                                            echo '<tr>
                                                                    <td>'.$type_desc.'</td>
                                                                    <td><input type="hidden" name="poultry[]" value="'.$sub_id.'">
                                                                    <input type="text" class="form-control" value="'.$units_or_heads.'" name="poultry_unit[]"  ></td>
                                                                    <td><input type="text" class="form-control" value="'.$cs_member.'" name="poultry_mem[]"  ></td>
                                                                    <td><input type="text" class="form-control" value="'.$cs_non_member.'" name="poultry_nonmem[]"  ></td>
                                                                    <td></td>
                                                                </tr>';
                                                        } else if($i < 3){
                                                            echo '<tr>
                                                                    <td>'.$serv_desc3[$i].'</td>
                                                                    <td><input type="hidden" name="poultry[]" value="'.$sub_id.'">
                                                                    <input type="text" class="form-control" value="'.$units_or_heads.'" name="poultry_unit[]"  ></td>
                                                                    <td><input type="text" class="form-control" value="'.$cs_member.'" name="poultry_mem[]"  ></td>
                                                                    <td><input type="text" class="form-control" value="'.$cs_non_member.'" name="poultry_nonmem[]"  ></td>
                                                                    <td></td>
                                                            </tr>';
                                                        } else {
                                                            echo '<tr>
                                                                    <td>'.$type_desc.'</td>
                                                                    <td><input type="hidden" name="poultry[]" value="'.$sub_id.'">
                                                                    <input type="text" class="form-control" value="'.$units_or_heads.'" name="poultry_unit[]"  ></td>
                                                                    <td><input type="text" class="form-control" value="'.$cs_member.'" name="poultry_mem[]"  ></td>
                                                                    <td><input type="text" class="form-control" value="'.$cs_non_member.'" name="poultry_nonmem[]"  ></td>
                                                                    <td><button type="button" class="btn btn-sm btn-danger btn-sm removethis">-</button></td>
                                                            </tr>';
                                                        }
                                                        
                                                        $i++;
                                                        }

                                                        } else {
                                                            for($i = 0 ; $i < count($serv_id3) ; $i++) {
                                                                echo '<tr>
                                                                            <td>'.$serv_desc3[$i]. '</td>
                                                                            <td><input type="hidden" name="poultry[]" value="'.$sub_id.'">
                                                                            <input type="text" class="form-control" name="poultry_unit[]"  ></td>
                                                                            <td><input type="text" class="form-control" name="poultry_mem[]"  ></td>
                                                                            <td><input type="text" class="form-control" name="poultry_nonmem[]"  ></td>
                                                                            <td></td>
                                                                    </tr>';
                                                            }
                                                        }

                                                        $run_sql_srvcs_prov->close();
                                                        ?>
                                                    </tbody>
                                                        <tr ><td colspan="12"><button class="btn btn-success btn-sm" type="button"
                                                        onclick="add_services('pltry','poultry[]',<?php echo $serv_type[2]; ?>,'poultry_unit[]','poultry_mem[]','poultry_nonmem[]')">
                                                        Other Services</button></td></tr>

                                                    <tbody>
                                                            <tr style="background-color:rgb(189, 255, 189);">
                                                                <td colspan="12"><b>Post Harvest Facilities</b></td>
                                                            </tr>
                                                        </tbody>

                                                    <tbody class="post_hrv_fcl">
                                                        <?php

                                                        $serv_id4 = array();
                                                        $serv_desc4 = array();

                                                        $run_sql = $conn->prepare($sql);
                                                        $run_sql->bind_param('i',$serv_type[3]);
                                                        $run_sql->execute();
                                                        $run_sql->bind_result($id, $desc);
                                                        $run_sql->store_result();
                                                        if($run_sql->num_rows() > 0) {
                                                            while($run_sql->fetch()) {
                                                                array_push($serv_id4, $id);
                                                                array_push($serv_desc4, $desc);
                                                            }
                                                        }
                                                        
                                                        $run_sql_srvcs_prov = $conn->prepare($sql_services);
                                                        $run_sql_srvcs_prov->bind_param('is',$org_id, $serv_type[3]);
                                                        $run_sql_srvcs_prov->execute();
                                                        $run_sql_srvcs_prov->bind_result($type_desc ,$sub_id, $units_or_heads, $cs_member, $cs_non_member);
                                                        $run_sql_srvcs_prov->store_result();

                                                        $i = 0;
                                                        if($run_sql_srvcs_prov->num_rows() > 0) {
                                                        while($run_sql_srvcs_prov->fetch()){
                                                        if($sub_id == $serv_id4[$i] && (!empty($units_or_heads) || !empty($cs_member) ||!empty($cs_non_member)) && $i < 7) {
                                                            echo '<tr>
                                                                    <td>'.$type_desc . '</td>
                                                                    <td><input type="hidden" name="post_harv[]" value="'.$sub_id.'">
                                                                    <input type="text" class="form-control" value="'.$units_or_heads.'" name="post_harv_unit[]"  ></td>
                                                                    <td><input type="text" class="form-control" value="'.$cs_member.'" name="post_harv_mem[]"  ></td>
                                                                    <td><input type="text" class="form-control" value="'.$cs_non_member.'" name="post_harv_nonmem[]"  ></td>
                                                                    <td></td>
                                                                </tr>';
                                                        } else if($i < 7 ){
                                                            echo '<tr>
                                                                    <td>'.$serv_desc4[$i]. '</td>
                                                                    <td><input type="hidden" name="post_harv[]" value="'.$sub_id.'">
                                                                    <input type="text" class="form-control" value="'.$units_or_heads.'" name="post_harv_unit[]"  ></td>
                                                                    <td><input type="text" class="form-control" value="'.$cs_member.'" name="post_harv_mem[]"  ></td>
                                                                    <td><input type="text" class="form-control" value="'.$cs_non_member.'" name="post_harv_nonmem[]"  ></td>
                                                                    <td></td>
                                                            </tr>';
                                                        } else {
                                                            echo '<tr>
                                                                    <td>'.$type_desc. '</td>
                                                                    <td><input type="hidden" name="post_harv[]" value="'.$sub_id.'">
                                                                    <input type="text" class="form-control" value="'.$units_or_heads.'" name="post_harv_unit[]"  ></td>
                                                                    <td><input type="text" class="form-control" value="'.$cs_member.'" name="post_harv_mem[]"  ></td>
                                                                    <td><input type="text" class="form-control" value="'.$cs_non_member.'" name="post_harv_nonmem[]"  ></td>
                                                                    <td><button type="button" class="btn btn-sm btn-danger btn-sm removethis">-</button></td>
                                                                </tr>';
                                                        }
                                                        
                                                        $i++;
                                                        }

                                                        } else {
                                                            for($i = 0 ; $i < count($serv_id4) ; $i++) {
                                                                echo '<tr>
                                                                            <td>'.$serv_desc4[$i]. '</td>
                                                                            <td><input type="hidden" name="post_harv[]" value="'.$sub_id.'">
                                                                            <input type="text" class="form-control" name="post_harv_unit[]"  ></td>
                                                                            <td><input type="text" class="form-control" name="post_harv_mem[]"  ></td>
                                                                            <td><input type="text" class="form-control" name="post_harv_nonmem[]"  ></td>
                                                                            <td></td>
                                                                    </tr>';
                                                            }
                                                        }

                                                        $run_sql_srvcs_prov->close();
                                                        ?>

                                                    </tbody>

                                                    <tr><td colspan="12"><button class="btn btn-success btn-sm" type="button"
                                                        onclick="add_services('post_hrv_fcl','post_harv[]',<?php echo $serv_type[3]; ?>,'post_harv_unit[]','post_harv_mem[]','post_harv_nonmem[]')">
                                                        Other Services</button></td></tr>

                                                    <tbody>
                                                            <tr style="background-color:rgb(189, 255, 189);">
                                                                <td colspan="12"><b>Other Projects</b></td>
                                                            </tr>
                                                        </tbody>

                                                    <tbody class="other_proj_field">
                                                        <?php

                                                    $serv_id5 = array();
                                                    $serv_desc5 = array();

                                                    $run_sql = $conn->prepare($sql);
                                                    $run_sql->bind_param('i',$serv_type[4]);
                                                    $run_sql->execute();
                                                    $run_sql->bind_result($id, $desc);
                                                    $run_sql->store_result();
                                                    if($run_sql->num_rows() > 0) {
                                                        while($run_sql->fetch()) {
                                                            array_push($serv_id5, $id);
                                                            array_push($serv_desc5, $desc);
                                                        }
                                                    }

                                                        $run_sql_srvcs_prov = $conn->prepare($sql_services);
                                                        $run_sql_srvcs_prov->bind_param('is',$org_id, $serv_type[4]);
                                                        $run_sql_srvcs_prov->execute();
                                                        $run_sql_srvcs_prov->bind_result($type_desc ,$sub_id, $units_or_heads, $cs_member, $cs_non_member);
                                                        $run_sql_srvcs_prov->store_result();

                                                        $i = 0;
                                                        if($run_sql_srvcs_prov->num_rows() > 0) {
                                                        while($run_sql_srvcs_prov->fetch()){
                                                        if($sub_id == $serv_id5[$i] && (!empty($units_or_heads) || !empty($cs_member) ||!empty($cs_non_member)) && $i < 6) {
                                                            echo '<tr>
                                                                    <td>'.$type_desc. '</td>
                                                                    <td><input type="hidden" name="other_proj[]" value="'.$sub_id.'">
                                                                    <input type="text" class="form-control" value="'.$units_or_heads.'" name="other_proj_unit[]"  ></td>
                                                                    <td><input type="text" class="form-control" value="'.$cs_member.'" name="other_proj_mem[]"  ></td>
                                                                    <td><input type="text" class="form-control" value="'.$cs_non_member.'" name="other_proj_nonmem[]"  ></td>
                                                                    <td></td>
                                                                </tr>';
                                                        } else if($i < 6){
                                                            echo '<tr>
                                                                    <td>'.$serv_desc5[$i] . '</td>
                                                                    <td><input type="hidden" name="other_proj[]" value="'.$sub_id.'">
                                                                    <input type="text" class="form-control" value="'.$units_or_heads.'" name="other_proj_unit[]"  ></td>
                                                                    <td><input type="text" class="form-control" value="'.$cs_member.'" name="other_proj_mem[]"  ></td>
                                                                    <td><input type="text" class="form-control" value="'.$cs_non_member.'" name="other_proj_nonmem[]"  ></td>
                                                                    <td></td>
                                                            </tr>';
                                                        } else {
                                                            echo '<tr>
                                                                    <td>'.$type_desc . '</td>
                                                                    <td><input type="hidden" name="other_proj[]" value="'.$sub_id.'">
                                                                    <input type="text" class="form-control" value="'.$units_or_heads.'" name="other_proj_unit[]"  ></td>
                                                                    <td><input type="text" class="form-control" value="'.$cs_member.'" name="other_proj_mem[]"  ></td>
                                                                    <td><input type="text" class="form-control" value="'.$cs_non_member.'" name="other_proj_nonmem[]"  ></td>
                                                                    <td><button type="button" class="btn btn-sm btn-danger btn-sm removethis">-</button></td>
                                                            </tr>';
                                                        }
                                                        
                                                        $i++;
                                                        }

                                                        } else {
                                                            for($i = 0 ; $i < count($serv_id5) ; $i++) {
                                                                echo '<tr>
                                                                            <td>'.$serv_desc5[$i]. '</td>
                                                                            <td><input type="hidden" name="other_proj[]" value="'.$sub_id.'">
                                                                            <input type="text" class="form-control" name="other_proj_unit[]"  ></td>
                                                                            <td><input type="text" class="form-control" name="other_proj_mem[]"  ></td>
                                                                            <td><input type="text" class="form-control" name="other_proj_nonmem[]"  ></td>
                                                                            <td></td>
                                                                    </tr>';
                                                            }
                                                        }

                                                        $run_sql_srvcs_prov->close();
                                                        ?>
                                                    </tbody>
                                                    <tr><td><button class="btn btn-success btn-sm" type="button"
                                                    onclick="add_services('other_proj_field','other_proj[]',<?php echo $serv_type[4]; ?>,'other_proj_unit[]','other_proj_mem[]','other_proj_nonmem[]')">
                                                    Other Services</button></td></tr>
                                                </table>

                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="box-header with-border">
                                    <div class="btn-group pull-right">
                                        <button type="button" onclick="plusDivs(-1, 1)" class="btn btn-sm btn-primary" style="background-color:green">
                                            <i class="fa fa-chevron-left"></i> Previous
                                        </button>
                                        <button type="button" onclick="plusDivs(+1, 3)" class="btn btn-success btn btn-sm">
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

                                    <div class="box-header with-border text-center">
                                        <h4><b>CURRENT SERVICES PROVIDED</b></h4>
                                    </div>

                                <div class="box-body">

                                    <div class="form-group col-sm-12">

                                        <div class="form-group inside-div">

                                            <div class="class=form-group col-sm-12">

                                                <div class="form-group">
                                                    <div class="col-lg-12">
                                                        <table class="table table-bordered">
                                                            <b>ASSISTING ORGANIZATION</b>
                                                            <thead class="bg-primary" style="background-color:mediumseagreen">
                                                                <tr>
                                                                    <th rowspan="3" class="text-center" style="vertical-align: middle;">NAME OF NGO/ORGANIZATION ASSISTING</th>
                                                                    <th rowspan="3" class="text-center" style="vertical-align: middle;">YEAR</th>
                                                                    <th rowspan="3" class="text-center" style="vertical-align: middle;"></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="add_row_1">
                                                                
                                                                    <?php
                                                                    $i = 0;
                                                                    if($run_sql_arbo_or_org_assist->num_rows()) {
                                                                    while($run_sql_arbo_or_org_assist->fetch()) {
                                                                        echo '<tr id="rw_'.$i.'"><td>
                                                                            <input type="text" class="form-control" name="par1_name_org_assiting[]" value="'.$org_assstng.'"></td>
                                                                        <td><input type="number" min="1900" max="3000" name="part1_year[]"  class="form-control" value="'.$org_yr_asstng.'"></td>
                                                                        <td><button type="button"class="btn btn-sm btn-danger btn-sm" onclick="removez(\'rw_'.$i.'\')">X</button></td>
                                                                        </tr>';
                                                                        $i++;
                                                                        }
                                                                    } else {
                                                                        echo '<tr id="rw_0"><td>
                                                                        <input type="text" class="form-control" name="par1_name_org_assiting[]"></td>
                                                                        <td><input type="number" min="1900" max="3000" class="form-control" placeholder="1900" name="part1_year[]" ></td></tr>';
                                                                    }
                                                            echo'     
                                                            </tbody>
                                                        </table>
                                                        <button type="button" class="btn btn-success btn-sm" onclick="addingup_row('.$i.')"><i class="fa fa-plus"></i> Add</button>';
                                                        ?>
                                                        <br><br>
                                                    </div>
                                                <!-- </div> -->

                                                <div class="col-sm-12 table-responsive">
                                                    <?php
                                                    $finance_ids = array(1,2,3,4,5);
                                                    $sql_finance = $conn->prepare('SELECT amount ,no_of_savers from arbo_financial_status where arbo_financial_type_id = ? and arbo_profile_id = ?');
                                                    ?>
                                                    <h4><b>FINANCIAL STATUS:</b></h4>
                                                    <table class="table table-bordered col-lg-12">
                                                        <thead class="bg-primary" style="background-color:mediumseagreen">
                                                            <tr>
                                                                <th></th>
                                                                <th rowspan="3" class="text-center" style="vertical-align: middle;">AMOUNT</th>
                                                                <th rowspan="3" class="text-center" style="vertical-align: middle;">NO. OF SAVERS</th>

                                                            </tr>

                                                        </thead>

                                                        <tbody>
                                                            <tr>
                                                                <?php
                                                                $sql_finance->bind_param('ii' , $finance_ids[0], $org_id);
                                                                $sql_finance->execute();
                                                                $sql_finance->bind_result($cap_amount,$cap_savers);
                                                                $sql_finance->store_result();
                                                                $sql_finance->num_rows();
                                                                $sql_finance->fetch();
                                                                ?>
                                                                <td>Capital Build Up:</td>
                                                                <td><input type="text" class="form-control" name="part3_capital_amount"	id="part3_capital_amount" value="<?php echo $cap_amount?>" placeholder="Enter..."  ></td>
                                                                
                                                                <td><input type="text" class="form-control" name="part3_capital_savers" id="part3_capital_savers" value="<?php echo $cap_savers?>" placeholder="Enter..."  ></td>
                                                            </tr>
                                                        </tbody>

                                                        <tbody>
                                                            <tr>
                                                                <?php
                                                                $sql_finance->bind_param('ii' , $finance_ids[1], $org_id);
                                                                $sql_finance->execute();
                                                                $sql_finance->bind_result($cap_amount,$cap_savers);
                                                                $sql_finance->store_result();
                                                                $sql_finance->num_rows();
                                                                $sql_finance->fetch();
                                                                ?>
                                                                <td>Savings:</td>
                                                                <td><input type="text" class="form-control" name="part3_savings_amount" id="part3_savings_amount"  value="<?php echo $cap_amount?>" placeholder="Enter..."  ></td>
                                                                <td><input type="text" class="form-control" name="part3_savings_savers" id="part3_savings_savers"  value="<?php echo $cap_savers?>"placeholder="Enter..."  ></td>
                                                            </tr>
                                                        </tbody>	

                                                        <tbody>
                                                            <tr>
                                                                <?php
                                                                $sql_finance->bind_param('ii' , $finance_ids[2], $org_id);
                                                                $sql_finance->execute();
                                                                $sql_finance->bind_result($cap_amount,$cap_savers);
                                                                $sql_finance->store_result();
                                                                $sql_finance->num_rows();
                                                                $sql_finance->fetch();
                                                                ?>
                                                                <td>Total Assets:</td>
                                                                <td><input type="text" class="form-control" name="part3_total_assets_am" id="part3_total_assets_am"  value="<?php echo $cap_amount?>" placeholder="Enter..."  ></td>
                                                                
                                                                <td><input type="text" class="form-control" name="part3_total_assets_sav" id="part3_total_assets_sav"  value="<?php echo $cap_savers?>" placeholder="Enter..."  ></td>
                                                                
                                                            </tr>
                                                        </tbody>

                                                        <tbody>
                                                            <tr>
                                                                <?php
                                                                $sql_finance->bind_param('ii' , $finance_ids[3], $org_id);
                                                                $sql_finance->execute();
                                                                $sql_finance->bind_result($cap_amount,$cap_savers);
                                                                $sql_finance->store_result();
                                                                $sql_finance->num_rows();
                                                                $sql_finance->fetch();
                                                                ?>
                                                                <td>Total Liabilities:</td>
                                                                <td><input type="text" class="form-control" name="part3_liability_amount" id="part3_liability_amount"  value="<?php echo $cap_amount?>"  ></td>
                                                                
                                                                <td><input type="text" class="form-control" name="part3_liability_savers" id="part3_liability_savers"  value="<?php echo $cap_savers?>"  ></td>
                                                                
                                                            </tr>
                                                        </tbody>


                                                        <tbody>
                                                            <tr>
                                                                <?php
                                                                $sql_finance->bind_param('ii' , $finance_ids[4], $org_id);
                                                                $sql_finance->execute();
                                                                $sql_finance->bind_result($cap_amount,$cap_savers);
                                                                $sql_finance->store_result();
                                                                $sql_finance->num_rows();
                                                                $sql_finance->fetch();
                                                                ?>
                                                                <td>Networth:</td>
                                                                <td><input type="text" class="form-control" name="part3_networth_amount" id="part3_total_amount" value="<?php echo $cap_amount;?>"></td>
                                                                
                                                                <td><input type="text" class="form-control" name="part3_networth_savers" id="part3_total_savers" value="<?php echo $cap_savers;?>" ></td>
                                                                
                                                            </tr>
                                                        </tbody>	

                                                    </table>

                                                </div></div>


                                                <div class="col-lg-12 table-responsive">
                                                    <h4><b>LOANS AVAILED IF ANY:</b></h4>
                                                    <table class="table table-bordered">

                                                        <thead class="bg-primary" style="background-color:mediumseagreen">
                                                            <tr>
                                                                <th rowspan="3" class="text-center" style="vertical-align: middle;">NATURE / PURPOSE OF LOAN</th>
                                                                <th rowspan="3" class="text-center" style="vertical-align: middle;">AMOUNT</th>
                                                                <th rowspan="3" class="text-center" style="vertical-align: middle;">SOURCE</th>
                                                                <th rowspan="3" class="text-center" style="vertical-align: middle;">DATE RELEASED</th>
                                                                <th rowspan="3" class="text-center" style="vertical-align: middle;">DATE AVAILED</th>
                                                                <th rowspan="3" class="text-center" style="vertical-align: middle;">TERMS OF PAYMENT</th>
                                                                <th rowspan="3" class="text-center" style="vertical-align: middle;">AMOUNT PAID</th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>

                                                        <tbody id="add_row_7">
                                                            <?php
                                                            $i = 0;
                                                            $sql22 = $conn->prepare('SELECT id,purpose_of_loan, amount, source, date_released, 
                                                            date_availed, terms_of_payment, amount_paid 
                                                            from arbo_loans_availed WHERE arbo_profile_id = ?');
                                                            $sql22->bind_param('i',$org_id);
                                                            $sql22->execute();
                                                            $sql22->bind_result($loans_id, $loan_purpose, $amount, $source, $date_released,
                                                            $date_availed, $terms_payment, $amount_paid);
                                                            $sql22->store_result();
                                                            $i = 0;
                                                            if($sql22->num_rows() > 0){
                                                                while($sql22->fetch()){
                                                                    echo '<tr id="rw2_'.$i.'">
                                                                        <td>
                                                                        <input type="hidden" value="'.$loans_id.'" name="loans_id[]">
                                                                        <input type="text" class="form-control" name="purpose_of_loan[]" value="'.$loan_purpose.'" placeholder="Enter..."></td>
                                                                        <td><input type="text" class="form-control" name="loan_amount[]" value="'.$amount.'" placeholder="Enter..."></td>
                                                                        <td><input type="text" class="form-control" name="loan_source[]" value="'.$source.'" placeholder="Enter..."></td>
                                                                        <td><input type="date" class="form-control" name="loan_date_released[]" value="'.$date_released.'" placeholder="Enter..."></td>
                                                                        <td><input type="date" class="form-control" name="loan_date_availed[]" value="'.$date_availed.'" placeholder="Enter..."></td>
                                                                        <td><input type="text" class="form-control" name="loan_terms_payment[]" value="'.$terms_payment.'" placeholder="Enter..."></td>
                                                                        <td><input type="text" class="form-control" name="loan_amount_paid[]" value="'.$amount_paid.'" placeholder="Enter..."></td>
                                                                        <td><button class="btn btn-sm btn-danger btn-sm" onclick="removez(\'rw2_'.$i.'\')">X</button></td>
                                                                    </tr>';
                                                                $i++;
                                                                }
                                                            }
                                                        echo '  
                                                        </tbody>
                                                        <tfoot>
                                                        <tr>
                                                            <th colspan="8"><button type="button" class="btn btn-success btn-sm pull-right" onclick="adding_rows_up('.$i.')"><i class="fa fa-plus"></i> ADD</button></th>
                                                        </tr>';
                                                        ?>
                                                    </tfoot>
                                                    </table>

                                                </div>

                                                <div class="col-sm-12 table-responsive">
                                                    <h4><b>TRAININGS ATTENDED:</b></h4>
                                                    <table class="table table-bordered">

                                                        <thead class="bg-primary" style="background-color:mediumseagreen">
                                                            <tr>
                                                                <th></th>
                                                                <th></th>
                                                                <th colspan="5" class="text-center" style="vertical-align: middle;">NATURE / PURPOSE OF LOAN</th>

                                                            </tr>

                                                        </thead>

                                                        <thead class="bg-primary" style="background-color:mediumseagreen">
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
                                                            <?php
                                                            $i = 0;
                                                            $trnings_attnd = 'SELECT id, title, date_conducted, conducted_by, no_of_pax_officers, no_of_pax_members
                                                            from arbo_org_trainings_attended prof WHERE arbo_profile_id = ?';
                                                            $run_trnings_attnd = $conn->prepare($trnings_attnd);
                                                            $run_trnings_attnd->bind_param('i',$org_id);
                                                            $run_trnings_attnd->execute();
                                                            $run_trnings_attnd->bind_result($trainings_att_id, $training_title,$date_conducted, $conducted_by, $no_of_officer,$no_of_member);
                                                            $run_trnings_attnd->store_result();
                                                            $i=0;
                                                            if($run_trnings_attnd->num_rows() > 0){
                                                            while($run_trnings_attnd->fetch()){
                                                            echo 
                                                            '<tr id="rw3_'.$i.'">
                                                            <td>
                                                            <input type="hidden" name="trainings_att_id[]" value="'.$trainings_att_id.'">
                                                            <input type="text" class="form-control" name="part3_title[]" value="'.$training_title.'"  placeholder="Enter..."  ></td>
                                                            <td><input type="text" class="form-control" name="part3_date_conducted[]" value="'.$date_conducted.'" placeholder="Enter..."  ></td>
                                                            <td><input type="text" class="form-control" name="part3_conducted_by[]" value="'.$conducted_by.'" placeholder=""></td>
                                                            <td><input type="text" class="form-control" name="part3_officers[]" value="'.$no_of_officer.'" placeholder="Enter..."  ></td>
                                                            <td><input type="text" class="form-control" name="part3_members[]" value="'.$no_of_member.'" placeholder="Enter..."  ></td>
                                                            <td><button type="button" class="btn btn-sm btn-danger btn-sm" onclick="removez(\'rw3_'.$i.'\')">X</button></td>
                                                            </tr>';
                                                            $i++;
                                                        }
                                                            }
                                                            
                                                        echo '
                                                        </tbody>
                                                        <tfoot>
                                                        <tr>
                                                            <th colspan="7"><button type="button" class="btn btn-success btn-sm pull-right" onclick="adding_rowsy_up('.$i.')"><i class="fa fa-plus"></i> ADD</button></th>
                                                        </tr>';
                                                        ?>
                                                    </tfoot>
                                                    </table>

                                                </div>

                                            </div>

                                        </div>

                            <div class="box-footer with-border">
                                    <div class="btn-group pull-right">
                                        <button type="button" onclick="plusDivs(-1, 2)" class="btn btn-sm btn-primary" style="background-color:green">
                                            <i class="fa fa-chevron-left"></i> Previous
                                        </button>
                                        <button type="button" onclick="plusDivs(+1, 4)" class="btn btn-success btn btn-sm">
                                            Next <i class="fa fa-chevron-right"></i>
                                        </button>
                                    </div>
                                </div>

                                    </div>
                                </div>
                            </div>
                        </div></div>
                    

                    <div class="row form-next">
                        <div class="col-xs-12">
                            <div class="box box-success">

                                <div class="box-body">

                                    <div class="form-group col-sm-12">

                                        <div class="form-group inside-div">

                                            <div class="form-group col-sm-12">

                                                <div class="col-lg-12 table-responsive">
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
                                        <th></th>
                                        </tr>

                                    </thead>
                    

                                <tbody id="add_row_9">
                                <?php
                                    $i = 0;
                                    $sql24 = $conn->prepare('SELECT pos.id, pos.description, mem.fn_arb , mem.ln_arb, mem.mn_arb
                                    from arbo_position_type as pos inner join 
                                    arbo_officers_n_bod as offcr_bod on pos.id = offcr_bod.arbo_position_type_id
                                    inner join part1_arb_household as mem on mem.hhold_id = offcr_bod.arbo_mem_id
                                    where pos.id = offcr_bod.arbo_position_type_id and offcr_bod.arbo_profile_id = ?');
                                    
                                    $sql24->bind_param('i',$org_id);
                                    $sql24->execute();
                                    $sql24->bind_result($pos_id, $description,$fname,$lname,$mname);
                                    $sql24->store_result();
                                        if($sql24->num_rows() > 0){
                                            while($sql24->fetch()){
                                                echo '<tr id="rw4_0'.$i.'"><td><input type="text" class="form-control" value="'.$fname.'" id="off_bod_fname" name="off_bod_fname[]"  ></td>
                                                <td><input type="text" class="form-control" id="off_bod_lname"  value="'.$lname.'" name="off_bod_lname[]"  ></td>
                                                <td><input type="text" class="form-control" id="off_bod_mname"  value="'.$mname.'" name="off_bod_mname[]"  ></td>
                                                <td><input type="text" class="form-control" name="offcrs_and_bod_position[]" value="'.$description.'" ></td>';
                                                echo '<td><button type="button" class="btn btn-sm btn-danger btn-sm" onclick="removez(\'rw4_0'.$i.'\')">X</button></td>
                                                    </tr>'; 
                                            $i++;
                                        }
                                        } else {
                                            for($i = 0 ; $i < 1 ; $i++) {
                                                echo '<tr><td><input type="text" class="form-control" id="off_bod_fname" name="off_bod_fname[]"  ></td>
                                                <td><input type="text" class="form-control" id="off_bod_lname" name="off_bod_lname[]"  ></td>
                                                <td><input type="text" class="form-control" id="off_bod_mname" name="off_bod_mname[]"  ></td>
                                                <td><input type="text" class="form-control" name="offcrs_and_bod_position[]"></td>';       
                                            }
                                        }
                                    $sql24->close();
                                
                                echo '</select><td></td></tr></tbody>
                                <tfoot>
                                <tr>
                                    <th colspan="7">
                                    <button type="button" class="btn btn-success btn-sm pull-right" onclick="adding_list_up('.$i.')"><i class="fa fa-plus"></i> ADD</button></th>
                                </tr>';
                                ?>
                            </tfoot>
                            </table>
                                                        
            </div> 

            <!-- LIST OF COMMITTEES AND MEMBERS -->
            
                        <h4 class="text-center"><b>LIST OF COMMITTEES AND MEMBERS</b></h4>
                    <!-- <thead> -->
                <!-- comm start -->
                <div class="col-lg-12 table-responsive">
                <div class="col-lg-12 table-responsive" id="committee_members">
                <?php
                    
                    $committee = array();
                    $sql = 'select distinct(comm_type.description)
                    from arbo_committe_position as pos 
                    inner join arbo_committee_n_member as committe
                    on pos.id = committe.arbo_committee_position_id
                    inner join arbo_committee_type as comm_type
                    on comm_type.id = committe.arbo_committee_type_id
                    inner join part1_arb_household as mem on mem.hhold_id = committe.arbo_mem_id
                    where committe.arbo_profile_id = ?';
                    $sql_run = $conn->prepare($sql);
                    $sql_run->bind_param('i',$org_id);
                    $sql_run->execute();
                    $sql_run->bind_result($description);
                    $sql_run->store_result();
                    
                    $sql24 = $conn->prepare('
                    select distinct(mem.hhold_id),mem.fn_arb , mem.ln_arb, mem.mn_arb,
                    pos.description ,comm_type.description
                    from arbo_committe_position as pos 
                    inner join arbo_committee_n_member as committe
                    on pos.id = committe.arbo_committee_position_id
                    inner join arbo_committee_type as comm_type
                    on comm_type.id = committe.arbo_committee_type_id
                    inner join part1_arb_household as mem on mem.hhold_id = committe.arbo_mem_id
                    where committe.arbo_profile_id = ? and comm_type.description = ?');

                    $count = 0;
                    $row = 0;
                        if($sql_run->num_rows() > 0){
                            while($sql_run->fetch()) {
                                array_push($committee,$description);
                            }
                        }

                    
                                for($i = 0 ; $i < count($committee) ; $i++) {
                                    echo '
                                    <table class="table table-bordered" id="comm_'.$i.'">
                                    <input type="hidden" value="'.$i.'" name="comm_basis[]" />
                                    <thead style="background-color:#00a65a;padding:2px;color:white;">
                                        <tr>
                                        <th colspan="2" class="text-center">COMMITTEE</th>
                                        <th colspan="2"><input type="text" class="form-control custom-input-white" name="committee_type[]"
                                        value="'.ucfirst($committee[$i]).'"></th>
                                        <th style="width:40px;font-weight:bolder;"><button type="button" class="btn btn-danger btn-sm" onclick="removez(\'comm_'.$i.'\')"><b>--</b></th>
                                        </tr>
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
                                    <tbody id="comm_tbl_'.$i.'">';
                                    $sql24->bind_param('is',$org_id,$committee[$i]);
                                    $sql24->execute();
                                    $sql24->bind_result($id, $fname, $lname, $mname, $description, $committee_);
                                    $sql24->store_result();
                                        if($sql24->num_rows() > 0){
                                            while($sql24->fetch()){
                                                
                                                if($committee[$i] == $committee_) {
                                                    echo '<tr id="comm_row_'.$i.'">
                                                            <td>
                                                            <input type="text" class="form-control" value="'.$fname.'" name="com_mem_fname'.$i.'[]"></td>
                                                            <td><input type="text" class="form-control" value="'.$lname.'" name="com_mem_lname'.$i.'[]"></td>
                                                            <td><input type="text" class="form-control" value="'.$mname.'" name="com_mem_mname'.$i.'[]"></td>
                                                            <td><input type="text" class="form-control" value="'.$description.'" name="committee_pos'.$i.'[]"></td>
                                                            <td><button type="button" class="btn btn-sm btn-danger btn-sm removethis">X</button></td>
                                                        </tr>';                                                                           
                                                }
                                                $row++;
                                            }
                                        }

                                        echo '</tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="7">
                                                    <button type="button" class="btn btn-success btn-sm pull-right" onclick="adding_comm('.$i.')"><i class="fa fa-plus"></i> ADD</button></th>
                                            </tr>
                                        </tfoot>
                                        </table>
                                    ';
                                    
                                    }
                                    
                                    if(count($committee) < 1) {
                                        for($i = 0 ; $i < 1 ; $i++) {
                                            echo '
                                                <table class="table table-bordered">
                                                <input type="hidden" value="0" name="comm_basis[]" />
                                                    <thead style="background-color:#00a65a;padding:2px;color:white;">
                                                        <th colspan="2">COMMITTEE</th>
                                                        <th colspan="2"><input type="text" class="form-control custom-input-white" name="committee_type[]" placeholder="Input Committee..." ></th>
                                                        <th style="width:40px;"></th>
                                                    </thead>
                                                    <thead style="background-color:rgb(189, 255, 189);">
                                                    <tr>
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
                                    ';
                                        }
                                    }

                                    if(count($committee) < 1) {
                                        $commitee_count = 0;
                                    } else {
                                        $commitee_count = count($committee);
                                    }
                    $sql24->close();
                    ?></div>
                    <div class="text-center" id="prep">
                        <button type="button" class="btn btn-success" onclick="add_committee(<?php echo $commitee_count ; ?>)">Add committee</button>
                    </div><br><br>
                    </div>
            <!-- END OF LIST OF COMMITTEES AND MEMBERS -->
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
                                                    $sql_show_arbo_inter = $conn->prepare('SELECT sub_id FROM arbo_acquired_intervention where main_id = ? and arbo_profile_id = ?');
                                                    $sql_qid = $conn->prepare('SELECT * FROM arbo_sub_intervention where main_id = ?');
                                                    $sql_show_arbo_spec = $conn->prepare('SELECT sub_id, specify_intervention 
                                                        FROM arbo_acquired_intervention where main_id = ? and arbo_profile_id = ? and specify_intervention is not null');
                                                    $q79_desc = array();
                                                    $q79_id = array();
                                                    $arbo_inter_qid = array();
                                                    $flag = 0;
                                                    $sql_show_arbo_inter->bind_param('ii', $qid[0] , $org_id);
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
                                                                    echo '<tr>
                                                                            <td class="'.$q79_id[$i].' addbgcolor">' . ($i+1) . '</td>
                                                                            <td class="'.$q79_id[$i].' addbgcolor">' . $q79_desc[$i] . '</td>
                                                                            <td class="'.$q79_id[$i].' addbgcolor"><input type="checkbox" checked  onclick="addbg(this.value)" value="'.$q79_id[$i].'" name="q79[]"/></td> 
                                                                        </tr>';
                                                                } else {
                                                                    if($flag > 0) {
                                                                        if($j == (count($arbo_inter_qid) - 1 ) && $q79_id[$i] != $arbo_inter_qid[$flag-1]) {
                                                                            echo '<tr>
                                                                                <td class="'.$q79_id[$i].'">' . ($i+1) . '</td>
                                                                                <td class="'.$q79_id[$i].'">' . $q79_desc[$i] . '</td>
                                                                                <td class="'.$q79_id[$i].'"><input type="checkbox"  onclick="addbg(this.value)" value="'.$q79_id[$i].'" name="q79[]"/></td> 
                                                                            </tr>';
                                                                        }
                                                                    } else if ($flag == 0){
                                                                        if($j == (count($arbo_inter_qid) - 1 ) && $q79_id[$i] != $arbo_inter_qid[$flag]) {
                                                                            echo '<tr>
                                                                                <td class="'.$q79_id[$i].'">' . ($i+1) . '</td>
                                                                                <td class="'.$q79_id[$i].'">' . $q79_desc[$i] . '</td>
                                                                                <td class="'.$q79_id[$i].'"><input type="checkbox" onclick="addbg(this.value)"  value="'.$q79_id[$i].'" name="q79[]"/></td> 
                                                                            </tr>';
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        } else {
                                                            echo '<tr>
                                                                    <td class="'.$q79_id[$i].'">' . ($i+1) . '</td>
                                                                    <td class="'.$q79_id[$i].'">' . $q79_desc[$i] . '</td>
                                                                    <td class="'.$q79_id[$i].'"><input type="checkbox"   value="'.$q79_id[$i].'" onclick="addbg(this.value)" name="q79[]"/></td> 
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
                                                    $sql_show_arbo_inter->bind_param('ii', $qid[1] , $org_id);
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
                                                                    echo '<tr>
                                                                            <td class="'.$q95_id[$i].' addbgcolor">' . ($i+1) . '</td>
                                                                            <td class="'.$q95_id[$i].' addbgcolor">' . $q95_desc[$i] . '</td>
                                                                            <td class="'.$q95_id[$i].' addbgcolor"><input type="checkbox" checked   value="'.$q95_id[$i].'" onclick="addbg(this.value)" name="q95[]"/></td> 
                                                                        </tr>';
                                                                } else {
                                                                    if($flag > 0) {
                                                                        if($j == (count($arbo_inter_qid) - 1 ) && $q95_id[$i] != $arbo_inter_qid[$flag-1]) {
                                                                            echo '<tr>
                                                                                <td class="'.$q95_id[$i].'">' . ($i+1) . '</td>
                                                                                <td class="'.$q95_id[$i].'">' . $q95_desc[$i] . '</td>
                                                                                <td class="'.$q95_id[$i].'"><input type="checkbox"   value="'.$q95_id[$i].'" onclick="addbg(this.value)" name="q95[]"/></td> 
                                                                            </tr>';
                                                                        }
                                                                    } else if ($flag == 0){
                                                                        if($j == (count($arbo_inter_qid) - 1 ) && $q95_id[$i] != $arbo_inter_qid[$flag]) {
                                                                            echo '<tr>
                                                                                <td class="'.$q95_id[$i].'">' . ($i+1) . '</td>
                                                                                <td class="'.$q95_id[$i].'">' . $q95_desc[$i] . '</td>
                                                                                <td class="'.$q95_id[$i].'"><input type="checkbox"   value="'.$q95_id[$i].'" onclick="addbg(this.value)" name="q95[]"/></td> 
                                                                            </tr>';
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        } else {
                                                            echo '<tr>
                                                                    <td class="'.$q95_id[$i].'">' . ($i+1) . '</td>
                                                                    <td class="'.$q95_id[$i].'">' . $q95_desc[$i] . '</td>
                                                                    <td class="'.$q95_id[$i].'"><input type="checkbox"   value="'.$q95_id[$i].'" onclick="addbg(this.value)" name="q95[]"/></td> 
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
                                                    $sql_show_arbo_inter->bind_param('ii', $qid[2] , $org_id);
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
                                                                    echo '<tr>
                                                                            <td class="'.$q96_id[$i].' addbgcolor ">' . ($i+1) . '</td>
                                                                            <td class="'.$q96_id[$i].' addbgcolor ">' . $q96_desc[$i]  . '</td>
                                                                            <td class="'.$q96_id[$i].' addbgcolor "><input type="checkbox" checked  value="'.$q96_id[$i].'" onclick="addbg(this.value)" name="q96[]"/></td> 
                                                                        </tr>';
                                                                } else {
                                                                    if($flag > 0) {
                                                                        if($j == (count($arbo_inter_qid) - 1 ) && $q96_id[$i] != $arbo_inter_qid[$flag-1]) {
                                                                            echo '<tr>
                                                                                <td class="'.$q96_id[$i].'">' . ($i+1) . '</td>
                                                                                <td class="'.$q96_id[$i].'">' . $q96_desc[$i] . '</td>
                                                                                <td class="'.$q96_id[$i].'"><input type="checkbox"   value="'.$q96_id[$i].'" onclick="addbg(this.value)" name="q96[]"/></td> 
                                                                            </tr>';
                                                                        }
                                                                    } else if ($flag == 0){
                                                                        if($j == (count($arbo_inter_qid) - 1 ) && $q96_id[$i] != $arbo_inter_qid[$flag]) {
                                                                            echo '<tr>
                                                                                <td class="'.$q96_id[$i].'">' . ($i+1) . '</td>
                                                                                <td class="'.$q96_id[$i].'">' . $q96_desc[$i] . '</td>
                                                                                <td class="'.$q96_id[$i].'"><input type="checkbox"   value="'.$q96_id[$i].'" onclick="addbg(this.value)" name="q96[]"/></td> 
                                                                            </tr>';
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        } else {
                                                            echo '<tr>
                                                                    <td class="'.$q96_id[$i].'">' . ($i+1) . '</td>
                                                                    <td class="'.$q96_id[$i].'">' . $q96_desc[$i] . '</td>
                                                                    <td class="'.$q96_id[$i].'"><input type="checkbox"   value="'.$q96_id[$i].'" onclick="addbg(this.value)" name="q96[]"/></td> 
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
                                                    $sql_show_arbo_inter->bind_param('ii', $qid[3] , $org_id);
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
                                                                    echo '<tr>
                                                                            <td class="'.$q97_id[$i].' addbgcolor ">' . ($i+1) . '</td>
                                                                            <td class="'.$q97_id[$i].' addbgcolor ">' . $q97_desc[$i] .   $arbo_inter_qid[$i] . '</td>
                                                                            <td class="'.$q97_id[$i].' addbgcolor "><input type="checkbox" checked   value="'.$q97_id[$i].'" onclick="addbg(this.value)" name="q97[]"/></td> 
                                                                        </tr>';
                                                                } else {
                                                                    if($flag > 0) {
                                                                        if($j == (count($arbo_inter_qid) - 1 ) && $q97_id[$i] != $arbo_inter_qid[$flag-1]) {
                                                                            echo '<tr>
                                                                                <td class="'.$q97_id[$i].'">' . ($i+1) . '</td>
                                                                                <td class="'.$q97_id[$i].'">' . $q97_desc[$i] . '</td>
                                                                                <td class="'.$q97_id[$i].'"><input type="checkbox"   value="'.$q97_id[$i].'" onclick="addbg(this.value)" name="q97[]"/></td> 
                                                                            </tr>';
                                                                        }
                                                                    } else if ($flag == 0){
                                                                        if($j == (count($arbo_inter_qid) - 1 ) && $q97_id[$i] != $arbo_inter_qid[$flag]) {
                                                                            echo '<tr>
                                                                                <td class="'.$q97_id[$i].'">' . ($i+1) . '</td>
                                                                                <td class="'.$q97_id[$i].'">' . $q97_desc[$i] . '</td>
                                                                                <td class="'.$q97_id[$i].'"><input type="checkbox"   value="'.$q97_id[$i].'" onclick="addbg(this.value)" name="q97[]"/></td> 
                                                                            </tr>';
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        } else {
                                                            echo '<tr>
                                                                    <td class="'.$q97_id[$i].'">' . ($i+1) . '</td>
                                                                    <td class="'.$q97_id[$i].'">' . $q97_desc[$i] . '</td>
                                                                    <td class="'.$q97_id[$i].'"><input type="checkbox"   value="'.$q97_id[$i].'" onclick="addbg(this.value)"  name="q97[]"/></td> 
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
                                                            $qid = array(0,1,2,98);
                                                            $flag = 0;

                                                            $sql_qid->bind_param('i', $qid[3]);
                                                            $sql_qid->execute();
                                                            $sql_qid->bind_result($id, $desc , $main_id);
                                                            $sql_qid->store_result();
                                                            if($sql_qid->num_rows() > 0) {
                                                                while($sql_qid->fetch()) {
                                                                    array_push($q98_id,$id);
                                                                    array_push($q98_desc,$desc);
                                                                }
                                                            }

                                                            $sql_show_arbo_inter->bind_param('ii', $qid[3] , $org_id);
                                                            $sql_show_arbo_inter->execute();
                                                            $sql_show_arbo_inter->bind_result($id);
                                                            $sql_show_arbo_inter->store_result();
                                                            if($sql_show_arbo_inter->num_rows() > 0) {
                                                                while($sql_show_arbo_inter->fetch()){
                                                                        array_push($arbo_inter_qid, $id);
                                                                    }
                                                                }

                                                                $sql_show_arbo_spec->bind_param('ii', $qid[3] , $org_id);
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
                                                                                echo '<tr>
                                                                                    <td class="'.$q98_id[$i].' addbgcolor ">' . ($i+1) . '</td>
                                                                                    <td class="'.$q98_id[$i].' addbgcolor ">' . $q98_desc[$i]. '</td>
                                                                                    <td class="'.$q98_id[$i].' addbgcolor "> <input type="text" style="background-color:rgba(255, 255, 255, .0);" id="'.$q98_id[$j].'" value="'.$arbo_inter_desc[$flag2].'" placeholder="a" name="q98_spec[]" /></td>
                                                                                    <td class="'.$q98_id[$i].' addbgcolor "><input type="checkbox" checked value="'.$q98_id[$i].'" onclick="enable(this.value)" name="q98[]"/></td>
                                                                                </tr>';
                                                                                $flag2++;
                                                                            } else {
                                                                                echo '<tr>
                                                                                    <td class="'.$q98_id[$i].'">' . ($i+1) . '</td>
                                                                                    <td class="'.$q98_id[$i].'">' . $q98_desc[$i] . '</td>
                                                                                    <td class="'.$q98_id[$i].'"><input type="text" style="background-color:rgba(255, 255, 255, .0);" id="'.$q98_id[$i].'" name="q98_spec[] "></td>
                                                                                    <td class="'.$q98_id[$i].'"><input type="checkbox" checked  value="'.$q98_id[$i].'" onclick="enable(this.value)" name="q98[]"/></td> 
                                                                                </tr>';
                                                                            }
                                                                        } else {
                                                                            if($flag > 0) {
                                                                                if($j == (count($arbo_inter_qid) - 1 ) && $q98_id[$i] != $arbo_inter_qid[$flag-1]) {
                                                                                    echo '<tr>
                                                                                        <td class="'.$q98_id[$i].'">' . ($i+1) . '</td>
                                                                                        <td class="'.$q98_id[$i].'">' . $q98_desc[$i] . '</td>
                                                                                        <td class="'.$q98_id[$i].'"><input type="text" disabled style="background-color:rgba(255, 255, 255, .0);"  id="'.$q98_id[$i].'"   name="q98_spec[]" ></td>
                                                                                        <td class="'.$q98_id[$i].'"><input type="checkbox"  onclick="enable(this.value)" value="'.$q98_id[$i].'" name="q98[]"/></td> 
                                                                                    </tr>';
                                                                                }
                                                                            } else if ($flag == 0){
                                                                                if($j == (count($arbo_inter_qid) - 1 ) && $q98_id[$i] != $arbo_inter_qid[$flag]) {
                                                                                    echo '<tr>
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
                                                                    echo '<tr>
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

                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                        <div class="box-footer with-border">
                                    <div class="btn-group pull-right">
                                        <button type="button" onclick="plusDivs(-1, 3)" class="btn btn-sm btn-primary" style="background-color:green">
                                            <i class="fa fa-chevron-left"></i> Previous
                                        </button>
                                        <button type="button" onclick="plusDivs(+1, 5)" class="btn btn-success btn btn-sm">
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

                                <div class="box-body">

                                    <div class="form-group col-sm-12">

                                        <div class="form-group inside-div">

                                            <div class="class=form-group col-sm-12">

                                                <div class="">
                                                <div class="form-group inside-div">
                                                <div class="class=form-group col-sm-12">
                                                <center><h4>MEMBERS</h4></center>
                                                Total Land Size : <input type="text" disabled id="landsize_total" >
                                                <div id="association_members" class="table-responsive"  style="max-height:500px;">
                                                    
                                                    <table class="table table-bordered associate_tbl">
                                                        <thead>
                                                            <tr>
                                                                <th>ORGS</th>
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
                                                            
                                                        <?php
                                                                $sql_show_members = 'SELECT distinct(mem.hhold_id),mem.fn_arb, mem.ln_arb, mem.mn_arb,
                                                                pos_type.description, asc_mem.sex, asc_mem.arbo_arb_type_id, asc_mem.arbo_status_id, asc_mem.cloa_no,asc_mem.land_size,
                                                                asc_mem.assoc_crop, asc_mem.cbu, asc_mem.monthly_due, 
                                                                asc_mem.production ,asc_mem.marketing, asc_mem.credit, asc_mem.phf, asc_mem.micro_ent ,asc_mem.service, asc_mem.others, asc_mem.trainings_attended
                                                                FROM arbo_position_type as pos_type inner join 
                                                                arbo_association_members as asc_mem 
                                                                on pos_type.id = asc_mem.arbo_position_type_id
                                                                inner join part1_arb_household as mem
                                                                on mem.hhold_id = asc_mem.arbo_mem_id
                                                                where ARBO_PROFILE_ID = ? and pos_type.id = asc_mem.arbo_position_type_id';
                                                                $run_sql_show_members = $conn->prepare($sql_show_members);
                                                                $run_sql_show_members->bind_param('i' , $org_id);
                                                                $run_sql_show_members->execute();
                                                                $run_sql_show_members->bind_result($id, $first_name, $last_name, $middle_initial,
                                                                    $arbo_position_type, $sex, $arbo_arb_type_id, $arbo_status_id, $cloa_no,$landsize ,$crops, $cbu,
                                                                    $savings, $production ,$marketing, $credit, $phf, $micro_ent ,$service, $others, $trainings_attended);
                                                                $run_sql_show_members->store_result();
                                                                $i = 0;
                                                                if($run_sql_show_members->num_rows() > 0) {
                                                                    while($run_sql_show_members->fetch()) {
                                                                        $fill_cloa = $arbo_arb_type_id == 1 ? "fill_cloa" : '';
                                                                        $fill_land = $arbo_arb_type_id == 1 ? "fill_land" : '';
                                                                        $fill_crop = $arbo_arb_type_id == 1 ? "fill_crop" : '';
                                                                        echo '<tr id="assoc_'.$i.'">
                                                                        <td style="min-width:20px;pading-top:3em;">
                                                                                <button class="btn btn-sm btn-default show_org_count" id="show_org_count'.$id.'" type="button" data-toggle="modal">
                                                                                <span id="org_count_1">0</span>
                                                                                </button>
                                                                            </td>
                                                                            <td class="headcol1">
                                                                                <input type="hidden"  value="$id" name="assoc_mem_id[]">
                                                                                <input type="text" class="custom_input assoc_lastname"
                                                                                onkeyup="checkArb($('.'\'.assoc_lastname\''.').index(this))" name="assoc_lastname[]" 
                                                                                value="'.$last_name.'" name="assoc_lastname[]" />
                                                                            </td>

                                                                            <td class="headcol2">
                                                                                <input type="text" class="custom_input assoc_firstname"   value="'.$first_name.'" 
                                                                                onkeyup="checkArb($('.'\'.assoc_firstname\''.').index(this))" name="assoc_firstname[]">
                                                                            </td>
                                                                            <td>
                                                                                <input type="text" class="custom_input assoc_mi"   value="'.$middle_initial.'"
                                                                                onkeyup="checkArb($('.'\'.assoc_mi\''.').index(this))" name="assoc_mi[]">
                                                                            </td>
                                                                            
                                                                            <td>
                                                                                <input type="text" class="custom_input" name="assoc_position[]"   value="'.$arbo_position_type.'">
                                                                            </td>
                                                                            ';
                                                                            if($sex == 1) {
                                                                                echo '<td style = "min-width:150px;" >
                                                                                                <input type = "radio" class = "custom_radio_padd_sm" name = "assoc_gender['.$i.']" checked value="1" id = "assoc_gender'.$i.'" > &nbsp; M &nbsp;&nbsp;
                                                                                                <input type = "radio" class = "custom_radio_padd_sm" name = "assoc_gender['.$i.']" value="0" id = "assoc_gender'.$i.'" > &nbsp; F
                                                                                            
                                                                                        </td>';
                                                                                // echo '<td style="max-width:80px;min-width:80px;">Male</td>';
                                                                            } else {
                                                                                echo '<td style = "min-width:150px;" >
                                                                                            <input type = "radio" class = "custom_radio_padd_sm" name = "assoc_gender['.$i.']"  value="1" id = "assoc_gender'.$i.'" > &nbsp; M &nbsp;&nbsp;
                                                                                            <input type = "radio" class = "custom_radio_padd_sm" name = "assoc_gender['.$i.']" checked value="0" id = "assoc_gender'.$i.'" > &nbsp; F
                                                                                    </td>';
                                                                                // echo '<td style="max-width:80px;min-width:80px;">Female</td>';
                                                                            }
                                                                            if($arbo_arb_type_id == 1){
                                                                                echo '<td>
                                                                                        <select class="select_brdr_btm assoc_arb_type vldt_arb" name="assoc_arb_type[]"  onchange="validate_arb()" id="">
                                                                                            <option value="1" selected>ARB</option>
                                                                                            <option value="0">NON-ARB</option>
                                                                                            <option value="2">HH-ARB</option>
                                                                                        </select>  
                                                                                    </td>';
                                                                                // echo '<td style="max-width:80px;min-width:80px;">ARB</td>';
                                                                                
                                                                            } else if($arbo_arb_type_id == 0){
                                                                                echo '<td>
                                                                                        <select class="select_brdr_btm assoc_arb_type" name="assoc_arb_type[]"  onchange="validate_arb()" id="">
                                                                                            <option value="0" selected>NON-ARB</option>
                                                                                            <option value="1">ARB</option>
                                                                                            <option value="2">HH-ARB</option>
                                                                                        </select>  
                                                                                    </td>';
                                                                                
                                                                            } else {
                                                                                echo '<td>
                                                                                        <select class="select_brdr_btm assoc_arb_type" name="assoc_arb_type[]"  onchange="validate_arb()" id="">
                                                                                            <option value="2">HH-ARB</option>    
                                                                                            <option value="0" selected>NON-ARB</option>
                                                                                            <option value="1">ARB</option>
                                                                                        </select>  
                                                                                    </td>';
                                                                            }
                                                                            if($arbo_status_id == 1) {
                                                                                echo '<td>
                                                                                        <input type="checkbox" name="assoc_status[]" checked  value="1">
                                                                                    </td>';
                                                                            } else {
                                                                                echo '<td>
                                                                                    <input type="checkbox" name="assoc_status[]"   id="assoc_status" value="1">
                                                                                </td>';
                                                                            }
                                                                            echo '<td>
                                                                                <input type="text" class="custom_input assoc_cloa_number '.$fill_cloa.'" value="'.$cloa_no.'" 
                                                                                onkeyup="validate_arb()" name="assoc_cloa_number[]" >
                                                                            </td>';
                                                                            echo '<td>
                                                                                <input type="number" class="custom_input landsize '.$fill_land.'"  value="'.$landsize.'"  
                                                                                onkeyup="add_land()" onkeydown="validate_arb()" name="assoc_landsize[]" id="assoc_landsize">
                                                                            </td>';
                                                                            echo '<td>
                                                                                <input type="text" class="custom_input_lg '.$fill_crop.' assoc_crop" value="'.$crops.'" 
                                                                                onkeyup="validate_arb()" name="assoc_crop[]" id="assoc_crop">
                                                                            </td>';
                                                                            if($cbu == 1) {
                                                                                echo '<td>
                                                                                    <input type="checkbox" name="assoc_cbu[]" checked    id="assoc_cbu" value="1">
                                                                                </td>';
                                                                            } else {
                                                                                echo '<td>
                                                                                    <input type="checkbox" name="assoc_cbu[]"    id="assoc_cbu" value="1">
                                                                                </td>';
                                                                            }

                                                                            if($savings == 1) {
                                                                                echo '<td>
                                                                                    <input type="checkbox" checked class="custom_input" value="1" name="assoc_saving[]" id="assoc_saving">
                                                                                </td>';
                                                                            } else {
                                                                                echo '<td>
                                                                                    <input type="checkbox" class="custom_input" value="1" name="assoc_saving[]" id="assoc_saving">
                                                                                </td>';
                                                                            }

                                                                            if($production == 1) {
                                                                                echo '<td>
                                                                                    <input type="checkbox" name="assoc_production[]" checked   id="assoc_production" value="1">
                                                                                </td>';
                                                                            } else {
                                                                                echo '<td>
                                                                                        <input type="checkbox" name="assoc_production[]"   id="assoc_production" value="1">
                                                                                    </td>';
                                                                            }
                                                                            if($marketing == 1) {
                                                                                echo '<td>
                                                                                        <input type="checkbox" name="assoc_mrktng[]" checked    id="assoc_mrktng" value="1">
                                                                                    </td>';
                                                                            } else {
                                                                                echo '<td>
                                                                                    <input type="checkbox" name="assoc_mrktng[]"    id="assoc_mrktng" value="1">
                                                                                </td>';
                                                                            }
                                                                            if($credit == 1) {
                                                                                echo '<td>
                                                                                    <input type="checkbox" name="assoc_credit[]" checked   id="assoc_credit" value="1">
                                                                                </td>';
                                                                            } else {
                                                                                echo '<td>
                                                                                    <input type="checkbox" name="assoc_credit[]"   id="assoc_credit" value="1">
                                                                                </td>';
                                                                            }
                                                                            if($phf) {
                                                                                echo '<td>
                                                                                    <input type="checkbox" name="assoc_phf[]" checked     id="assoc_phf" value="1">
                                                                                </td>';
                                                                            } else {
                                                                                echo '<td>
                                                                                        <input type="checkbox" name="assoc_phf[]"     id="assoc_phf" value="1">
                                                                                    </td>';
                                                                            }
                                                                            if($micro_ent == 1) {
                                                                                echo '<td>
                                                                                    <input type="checkbox" name="assoc_micro[]" checked   id="assoc_micro" value="1">
                                                                                </td>';
                                                                            } else {
                                                                                echo '<td>
                                                                                    <input type="checkbox" name="assoc_micro[]"   id="assoc_micro" value="1">
                                                                                </td>';
                                                                            }
                                                                            if($service==1){
                                                                                echo '<td>
                                                                                        <input type="checkbox" name="assoc_srvce[]" checked   id="assoc_srvce" value="1">
                                                                                    </td>';
                                                                            } else {
                                                                                echo '<td>
                                                                                    <input type="checkbox" name="assoc_srvce[]"   id="assoc_srvce" value="1">
                                                                                </td>';
                                                                            }
                                                                           
                                                                                
                                                                            echo '<td>
                                                                                <input type="text" class="custom_input" name="assoc_others[]" id="assoc_others" value="'.$others.'" >
                                                                                    </td>';
                                                                           
                                                                            echo '<td>
                                                                                    <input type="text" class="custom_input_lg"  placeholder="kindly put > after every new trainings"  value="'.$trainings_attended.'" name="assoc_train_attended[]" id="assoc_train_attended">
                                                                                </td>
                                                                                <td>
                                                                                    <button type="button" class = "btn btn-sm btn-danger btn-sm" type = "button" onclick = "removez(\'assoc_'.$i.'\')" > X </button>
                                                                                </td>
                                                                                </tr>';
                                                                                $i++;
                                                                    }
                                                                }
                                                            
                                                        echo '</tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <th colspan="12" >';
                                                                
                                                                ?>
                                                                </th>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                               
                                                    <button class="btn btn-success btn-sm pull-left" type="button" style="margin-top:0.5em;margin-left:0.5em;" onclick="add_association_mem_up(<?php echo $i; ?>)">
                                                        <span class="glyphicon glyphicon-plus"></span>ADD
                                                    </button><br><br>
                                                    <div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="box-footer clearfix with-border">

                                        <div class="btn-group pull-right">
                                            <button type="button" onclick="plusDivs( - 1, 4)" class="btn btn-primary" style="background-color:green">
                                                <i class="fa fa-chevron-left"></i> Previous
                                            </button>

                                        </div>
                                        </div>

                                        <center><button type="submit" name="submit" id="update" class="btn btn-success btn-md" form="submit_form">
                                        <i class="fa fa-save"></i> Update
                                        </button>
                                        </center>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>


    <div class="control-sidebar-bg"></div>
<!-- ./wrapper -->


<?php include 'inc/scripts.php';?>
<script src="../js/arbo-form.js"></script>
<script src="../js/adding-form-js.js"></script>
<script>
    (function() {
    $lngth = $('.assoc_firstname').length;
    for($i = 0 ; $i < $lngth ; $i++) {
        checkArb($i);
    }

    })();
    function enable(id){
        $('#' + id).removeAttr('disabled', ' ');
        $('.' + id).toggleClass('addbgcolor');
    }
    function addbg(val) {
        $('.' + val).toggleClass('addbgcolor');
    }
    $('.removethis').click(function(){
        $(this).closest('tr').remove();
    });
    $().ready(function() {
        checkArb();
    });
        var trs;
    var other_mem = 0;
    function add_services(cust_class, field_name1, id, field_name2, field_name3, field_name4) {
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
    sumFemale();
    sumMale();
    add_land();
    function add_land() {
            var sum = 0;
            $(".landsize").each(function() {
                
                if($(this).val() != "") {
                    sum += parseFloat($(this).val());   
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
                    $('#update').removeAttr('disabled','disabled');
                } else {
                    $('#update').attr('disabled', 'disabled');
                }
            } else {
                $(this).removeClass('vldt_arb');
                $('.assoc_cloa_number').eq(i).removeClass('fill_cloa');
                $('.assoc_crop').eq(i).removeClass('fill_crop');
                $('.assoc_landsize ').eq(i).removeClass('fill_land');

                flag1_ = vldt_cloa($('.fill_cloa').length);
                flag2_ = vldt_lnd($('.fill_crop').length);
                flag3_ = vldt_crop($('.fill_land').length);
                // console.log('w/o ' + flag1_ + flag2_ + flag3 );
                if(flag1_ == 0 && flag2_ == 0 && flag3_ == 0  && $('#org_exist').length == 0 && $.trim($('#part1_arbo_name').val()) != '') {
                    $('#update').removeAttr('disabled','disabled');
                } else {
                    $('#update').attr('disabled' , 'disabled');
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
        var prof_id = $('#prof_id').val();
        $.post('controller/check_po_profile.php' , {
            part1_arbo_name : part1_arbo_name,
            prof_id : prof_id
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