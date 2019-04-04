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
        <title>PPS | Po Profile</title>
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
            .select_brdr_btm:disabled{
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
                left:190.8px;
            }
            .user-panel {
                background-image:url('../logo/dar-bg.png');
                height:100px;
            }
            #assoc_members_list_paginate  .paginate_button a {
                color: #1e282c !important;
                background-color:white;
                text-decoration:none;
            }
            #assoc_members_list_paginate  .paginate_button a:hover {
                color: white !important;
                background-color:#00a65a !important;
                text-decoration:none;
            }
            #assoc_members_list_paginate .paginate_button a:active {
                background-color:#00a65a !important;
                color:white !important;
            }   
            
            .pagination .active a{
                border:1px solid #00a65a  !important;
                background-color:#00a65a !important;
            }
            #assoc_members_list_paginate > ul > li.paginate_button.active > a {
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
            // $count = 0;
                $org_id = isset($_GET['id']) ? $_GET['id'] : 0;
            ?>

            <!-- Content Wrapper. Contains page content -->

            <div class="content-wrapper">

                <section class="content-header">
                    <a href="po_profile_search.php"><button class="btn btn-success btn-sm" type="button">
                    <i class="fa fa-arrow-circle-left"></i> Back</button></a>

                    <a href="po_profile_update.php?id=<?php echo $org_id; ?>">
                    <button class="btn btn-primary btn-sm">Update</button>
                    </a>
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
                                                    <div class="col-lg-2">
                                                        <label for="" class="this_label"> As of </label>
                                                        <input type="hidden" name="prof_id" value="<?php echo $org_id ; ?>">
                                                        <input type="text" class="form-control this_input" disabled name="part1_arbo_of" id="part1_arbo_of" value="<?php echo $as_of_date ; ?>">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-lg-4">
                                                        <label for="" class="this_label"> ORGANIZATION </label>
                                                        <input type="text" class="form-control this_input" disabled name="part1_arbo_name" id="part1_arbo_name" value="<?php echo $name ; ?>">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-lg-4">
                                                        <label for="" class="this_label"> ACRONYM </label>
                                                        <input type="text" class="form-control this_input" disabled name="part1_acro_name" id="part1_acronym" value="<?php echo $acronym ; ?>">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-lg-2">
                                                        <label for="" class="this_label">REGISTRATION IMAGE</label><br>
                                                        <button class="btn btn-success btn-sm" style="width:100%;"
                                                        type="button" data-toggle="modal" data-target="#show_org_image">VIEW</button>
                                                    </div>
                                                </div>

                                                <div id="show_org_image" class="modal fade" role="dialog">
                                                        <div class="modal-dialog modal-lg">
                                                                <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                    <h4 class="modal-title text-center">REGISTRATION FORM IMAGE</h4>
                                                                </div>
                                                                <div class="modal-body">
                                                                <?php
                                                                    if(!empty($form_image)) {
                                                                        echo '<img src="controller/'.$form_image.'" alt="form_image" style="width:100%;" max-width:1920px;>';
                                                                    } else {
                                                                        echo '<img src="controller/registration_form_images/empty.jpg" alt="form_image" style="width:100%;" max-width:1920px;>';
                                                                    }
                                                                    
                                                                ?>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
                                                                </div>
                                                                </div>

                                                            </div>
                                                            </div>

                                                <div class="form-group col-sm-12">
                                                    
                                                </div>
                                                <div class="form-group col-sm-6">
                                                    <label for="arbo_addr">ARBO ADDRESS: </label>
                                                    <input type="text" class="form-control this_input" disabled id="arbo_province"
                                                    value="<?php echo $arbo_address ; ?>" disabled name="arbo_addr" required>
                                                </div>
                                                <div class="form-group col-sm-6">
                                                    <label for="ope_municipal">AREA OF OPERATION</label>
                                                    <input type="text" class="form-control this_input" id="ope_municipal" disabled
                                                        value="<?php echo $area_of_operation ; ?>" disable>
                                                </div>

                                                

                                                <div class="form-group">

                                                    <div class="col-lg-4">
                                                        <label for="" class="this_label">CONTACT PERSON</label>
                                                        <input type="text" class="form-control this_input" disabled name="offCon" id="offCon" value="<?php echo $contact_person ; ?>">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-lg-4">
                                                        <label for="" class="this_label"> DATE ORGANIZED </label>
                                                        <input type="text" class="form-control this_input" disabled name="personCon" id="personCon" value="<?php echo $date_organized ; ?>">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-lg-4">
                                                        <label for="" class="this_label"> DATE REGISTERED </label>
                                                        <input type="text" class="form-control this_input" disabled name="date_reg" id="date_reg" value="<?php echo $date_registered ; ?>"><br>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="col-lg-6">
                                                        <label for="" class="this_label"> REGISTRATION NO. </label>
                                                        <input type="text" class="form-control this_input" disabled name="reg_num" id="reg_num" value="<?php echo $registration_no ; ?>">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-lg-6">
                                                        <label for="" class="this_label"> AGENCY/ENTITY REGISTERED </label>
                                                        <input type="text" class="form-control this_input" disabled name="specReason" id="specReason" value="<?php echo $agency_registered ; ?>"><br>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="col-lg-6">
                                                        <label for="" class="this_label"> TYPE OF ORGANIZATION </label>
                                                        <input type="text" class="form-control this_input" disabled name="certiPhoto" id="certiPhoto" value="<?php echo $type_of_organization ; ?>">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-lg-6">
                                                        <label for="" class="this_label"> AFFILIATION </label>
                                                        <input type="text" class="form-control this_input" disabled name="specReasonNot" id="specReasonNot" value="<?php echo $affiliation ; ?>">
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
                                                                <td><input type="text" class="form-control" disabled name="part3_arb1_members" value="<?php echo $total_arb; ?>" id="part3_arb1_members"  placeholder="Enter..."  ></td>
                                                                <td>MALE</td>
                                                                <td><input type="text" class="form-control" disabled name="part3_arb1_male" id="part3_arb1_male" value="<?php echo $arb_male?>"  placeholder="Enter..."  ></td>
                                                                <td>FEMALE</td>
                                                                <td><input type="text" class="form-control" disabled name="part3_arb1_female" id="part3_arb1_female" value="<?php echo $arb_female?>" placeholder="Enter..."  ></td>
                                                            </tr>
                                                        </thead>

                                                        <thead>
                                                            <tr>
                                                                <td>NON-ARB</td>
                                                                <td><input type="text" class="form-control"  disabled name="part3_arb2_members" id="part3_arb2_members" value="<?php echo $total_non_arb; ?>"  placeholder="Enter..."  ></td>
                                                                <td>MALE</td>
                                                                <td><input type="text" class="form-control" disabled  name="part3_arb2_male" id="part3_arb2_male" value="<?php echo $non_arb_male?>"  placeholder="Enter..."  ></td>
                                                                <td>FEMALE</td>
                                                                <td><input type="text" class="form-control"  disabled name="part3_arb2_female" value="<?php echo $non_arb_female?>"  placeholder="Enter..."  ></td>
                                                            </tr>
                                                        </thead>

                                                        <thead>
                                                            <tr>
                                                                <td>ARB-HH</td>
                                                                <td><input type="text" class="form-control" disabled name="total_hh_arb" id="total_hh_arb" value="<?php echo $total_hh_arb; ?>" placeholder="Enter..."  ></td>
                                                                <td>MALE</td>
                                                                <td><input type="text" class="form-control" disabled name="male_hh_arb" id="male_hh_arb" value="<?php echo $male_hh_arb; ?>" placeholder="Enter..."  ></td>
                                                                <td>FEMALE</td>  
                                                                <td><input type="text" class="form-control" disabled name="female_hh_arb" id="female_hh_arb" value="<?php echo $female_hh_arb; ?>"placeholder="Enter..."  ></td>
                                                            </tr>
                                                        </thead>

                                                        <thead>
                                                            <tr>
                                                                <td>TOTAL </td>
                                                                <td><input type="text" disabled class="form-control" disabled name="part3_total_members" id="part3_total_members"
                                                                    value="<?php echo $total_arb + $total_non_arb + $total_hh_arb; ?>"></td>
                                                                <td>TOTAL MALE</td>
                                                                <td><input type="text" disabled class="form-control" disabled name="part3_total_male" id="part3_total_male" 
                                                                value="<?php echo $arb_male  + $non_arb_male + $male_hh_arb;?>" ></td>
                                                                <td>TOTAL FEMALE</td>
                                                                <td><input type="text" disabled  class="form-control" disabled name="part3_total_female" id="part3_total_female"
                                                                value="<?php echo $arb_female + $non_arb_female + $female_hh_arb;?>"></td>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                                
                                            </div>  


                                        </div>

                                    </div>

                                </div>
                                <div class="box-footer with-border">
                                    <button type="button" onclick="plusDivs(+1, 2)" class="btn btn-success btn-sm pull-right" id="addorupdate" form="add_francise_form">
                                        Next <i class="fa fa-chevron-right"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row form-next">
                        <div class="col-xs-12">
                            <div class="box box-success">

                                    <div class="box-header text-center">
                                        <h4><b>CURRENT SERVICES PROVIDED</b></h4>
                                    </div>
                                <div class="box-body">

                                    <div class="form-group col-sm-12">

                                        <div class="form-group inside-div">

                                            <div class="class=form-group col-sm-12">

                                                <?php
                                                $count_services = 0;
                                                $serv_type = array(1,2,3,4,5);
                                                $sql_services = 'SELECT distinct(sub.description) , srvce_prvded.units_or_heads
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
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        <tr style="background-color:rgb(189, 255, 189);">
                                                            <td colspan="4"><b>Pre Harvest Facilities</b></td>
                                                        </tr>
                                                    </tbody>

                                                    <tbody>													
                                                        <?php
                                                        $run_sql_srvcs_prov = $conn->prepare($sql_services);
                                                        $run_sql_srvcs_prov->bind_param('is',$org_id, $serv_type[0]);
                                                        $run_sql_srvcs_prov->execute();
                                                        $run_sql_srvcs_prov->bind_result($type_desc , $units_or_heads, $cs_member, $cs_non_member);
                                                        $run_sql_srvcs_prov->store_result();
                                                        $flag = 0;
                                                        if($run_sql_srvcs_prov->num_rows() > 0) {
                                                        while($run_sql_srvcs_prov->fetch()){
                                                            if(!empty($units_or_heads) || !empty($cs_member) || !empty($cs_non_member)) {
                                                                echo '<tr>
                                                                    <td>'.$type_desc.'</td>
                                                                    <td><input type="text" disabled class="form-control" value="'.$units_or_heads.'" name="Pre_harv1"  ></td>
                                                                    <td><input type="text" disabled class="form-control" value="'.$cs_member.'" name="Pre_harv2"  ></td>
                                                                    <td><input type="text" disabled class="form-control" value="'.$cs_non_member.'" name="Pre_harv3"  ></td>
                                                                </tr>';
                                                                $flag++;
                                                            }
                                                        }
                                                        }
                                                        if($flag == 0) {
                                                            echo '<tr><td colspan="4" style="color:gray;text-align:center;">< Empty ></td></tr>';
                                                        }

                                                        $run_sql_srvcs_prov->close();
                                                        ?>
                                                    </tbody>
                                                    <tbody>
                                                        <tr style="background-color:rgb(189, 255, 189);">
                                                            <td colspan="4"><b>Livestock</b></td>
                                                        </tr>
                                                    </tbody>	

                                                    <tbody>
                                                        <?php
                                                        $run_sql_srvcs_prov = $conn->prepare($sql_services);
                                                        $run_sql_srvcs_prov->bind_param('is',$org_id, $serv_type[1]);
                                                        $run_sql_srvcs_prov->execute();
                                                        $run_sql_srvcs_prov->bind_result($type_desc , $units_or_heads, $cs_member, $cs_non_member);
                                                        $run_sql_srvcs_prov->store_result();
                                                        $flag = 0;
                                                        if($run_sql_srvcs_prov->num_rows() > 0) {
                                                        while($run_sql_srvcs_prov->fetch()){
                                                            if(!empty($units_or_heads) || !empty($cs_member) || !empty($cs_non_member)) {
                                                                echo '<tr>
                                                                    <td>'.$type_desc.'</td>
                                                                    <td><input type="text" disabled class="form-control" value="'.$units_or_heads.'" name="Pre_harv1"  ></td>
                                                                    <td><input type="text" disabled class="form-control" value="'.$cs_member.'" name="Pre_harv2"  ></td>
                                                                    <td><input type="text" disabled class="form-control" value="'.$cs_non_member.'" name="Pre_harv3"  ></td>
                                                                </tr>';
                                                                $flag++;
                                                            }
                                                        }
                                                        }
                                                        if($flag == 0) {
                                                            echo '<tr><td colspan="4" style="color:gray;text-align:center;">< Empty ></td></tr>';
                                                        }

                                                        $run_sql_srvcs_prov->close();
                                                        ?>
                                                    </tbody>

                                                    <tbody>
                                                        <tr style="background-color:rgb(189, 255, 189);">
                                                            <td colspan="4"><b>Poultry / Broiler Raising</b></td>
                                                        </tr>
                                                    </tbody>

                                                    <tbody>

                                                        <?php
                                                        $run_sql_srvcs_prov = $conn->prepare($sql_services);
                                                        $run_sql_srvcs_prov->bind_param('is',$org_id, $serv_type[2]);
                                                        $run_sql_srvcs_prov->execute();
                                                        $run_sql_srvcs_prov->bind_result($type_desc , $units_or_heads, $cs_member, $cs_non_member);
                                                        $run_sql_srvcs_prov->store_result();
                                                        $flag = 0;
                                                        if($run_sql_srvcs_prov->num_rows() > 0) {
                                                        while($run_sql_srvcs_prov->fetch()){
                                                            if(!empty($units_or_heads) || !empty($cs_member) || !empty($cs_non_member)) {
                                                                echo '<tr>
                                                                        <td>'.$type_desc.'</td>
                                                                        <td><input type="text" disabled class="form-control" value="'.$units_or_heads.'" name="Pre_harv1"  ></td>
                                                                        <td><input type="text" disabled class="form-control" value="'.$cs_member.'" name="Pre_harv2"  ></td>
                                                                        <td><input type="text" disabled class="form-control" value="'.$cs_non_member.'" name="Pre_harv3"  ></td>
                                                                    </tr>';
                                                                    $flag++;
                                                            }
                                                        }

                                                        }
                                                        if($flag == 0) {
                                                            echo '<tr><td colspan="4" style="color:gray;text-align:center;">< Empty ></td></tr>';
                                                        }

                                                        $run_sql_srvcs_prov->close();
                                                        ?>
                                                    </tbody>

                                                    <tbody>
                                                            <tr style="background-color:rgb(189, 255, 189);">
                                                                <td colspan="4"><b>Post Harvest Facilities</b></td>
                                                            </tr>
                                                        </tbody>

                                                    <tbody>
                                                        <?php
                                                        $run_sql_srvcs_prov = $conn->prepare($sql_services);
                                                        $run_sql_srvcs_prov->bind_param('is',$org_id, $serv_type[3]);
                                                        $run_sql_srvcs_prov->execute();
                                                        $run_sql_srvcs_prov->bind_result($type_desc , $units_or_heads, $cs_member, $cs_non_member);
                                                        $run_sql_srvcs_prov->store_result();
                                                        $flag = 0;
                                                        if($run_sql_srvcs_prov->num_rows() > 0) {
                                                            while($run_sql_srvcs_prov->fetch()){
                                                                if(!empty($units_or_heads) || !empty($cs_member) || !empty($cs_non_member)) {
                                                                    echo '<tr>
                                                                                <td>'.$type_desc.'</td>
                                                                                <td><input type="text" disabled class="form-control" value="'.$units_or_heads.'" name="Pre_harv1"  ></td>
                                                                                <td><input type="text" disabled class="form-control" value="'.$cs_member.'" name="Pre_harv2"  ></td>
                                                                                <td><input type="text" disabled class="form-control" value="'.$cs_non_member.'" name="Pre_harv3"  ></td>
                                                                            </tr>';
                                                                            $flag++;
                                                                }
                                                                }
                                                            }
                                                            if($flag == 0) {
                                                                echo '<tr><td colspan="4" style="color:gray;text-align:center;">< Empty ></td></tr>';
                                                            }

                                                        $run_sql_srvcs_prov->close();
                                                        ?>

                                                    </tbody>


                                                    <tbody>
                                                            <tr style="background-color:rgb(189, 255, 189);">
                                                                <td colspan="4"><b>Other Projects</b></td>
                                                            </tr>
                                                        </tbody>

                                                    <tbody>
                                                        <?php
                                                        $run_sql_srvcs_prov = $conn->prepare($sql_services);
                                                        $run_sql_srvcs_prov->bind_param('is',$org_id, $serv_type[4]);
                                                        $run_sql_srvcs_prov->execute();
                                                        $run_sql_srvcs_prov->bind_result($type_desc , $units_or_heads, $cs_member, $cs_non_member);
                                                        $run_sql_srvcs_prov->store_result();
                                                        $flag = 0;
                                                        if($run_sql_srvcs_prov->num_rows() > 0) {
                                                        while($run_sql_srvcs_prov->fetch()){
                                                            if(!empty($units_or_heads) || !empty($cs_member) || !empty($cs_non_member)) {
                                                                    echo '<tr>
                                                                        <td>'.$type_desc.'</td>
                                                                        <td><input type="text" disabled class="form-control" value="'.$units_or_heads.'" name="Pre_harv1"  ></td>
                                                                        <td><input type="text" disabled class="form-control" value="'.$cs_member.'" name="Pre_harv2"  ></td>
                                                                        <td><input type="text" disabled class="form-control" value="'.$cs_non_member.'" name="Pre_harv3"  ></td>
                                                                    </tr>';
                                                                    $flag++;
                                                            }
                                                        }

                                                        }
                                                        if($flag == 0) {
                                                            echo '<tr><td colspan="4" style="color:gray;text-align:center;">< Empty ></td></tr>';
                                                        }

                                                        $run_sql_srvcs_prov->close();
                                                        ?>
                                                    </tbody>

                                                </table>

                                            </div>

                                        </div>

                                    </div>
                                </div>
                                <div class="box-footer with-border">
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
                            <div class="box-header">

                            </div>
                                <div class="box-body">

                                    <div class="form-group col-sm-12">

                                        <div class="form-group inside-div">

                                            <div class="form-group col-sm-12">

                                                <div class="form-group">
                                                    <div class="col-lg-12">
                                                        <table class="table table-bordered">
                                                            <thead class="bg-success-custom">
                                                                <tr>
                                                                    <th colspan="6" style="padding:0px;"><center style="background-color:#00a65a;padding:2px;color:white;">
                                                                    <h5><b>ASSISTING ORGRANIZATION</b></h5></center></th>
                                                                </tr>
                                                            </thead>
                                                            <thead style="background-color:rgb(189, 255, 189);">
                                                                <tr>
                                                                    <th rowspan="3" class="text-center" style="vertical-align: middle;">NAME OF NGO/ORGANIZATION ASSISTING</th>
                                                                    <th rowspan="3" class="text-center" style="vertical-align: middle;">YEAR</th>
                                                                </tr>
                                                            </thead>

                                                            <tbody id="add_row_1">
                                                                
                                                                    <?php
                                                                    $i = 0;
                                                                    if($run_sql_arbo_or_org_assist->num_rows()){
                                                                    while($run_sql_arbo_or_org_assist->fetch()){
                                                                    echo '<tr id="rw_'.$i.'"><td>
                                                                        <input type="hidden" disabled value="'.$org_assist_id.'" name="org_assist_id[]">
                                                                        <input type="text" disabled class="form-control" name="part1_name_org_assisting[]" value="'.$org_assstng.'"></td>
                                                                    <td><input type="number" disabled min="1900" max="3000"   class="form-control" value="'.$org_yr_asstng.'"></td></tr>';
                                                                    $i++;
                                                                    }
                                                                    } else {
                                                                    echo '<tr><td><input disabled type="text" class="form-control"    placeholder="" name="part1_year[]" ></td>
                                                                    <td><input type="number" disabled class="form-control"    placeholder=""  ></td></tr>';
                                                                    }
                                                                    ?>
                                                                
                                                            </tbody>
                                                        </table>
                                                        <br>
                                                    </div>
                                                </div>

                                                <div class="col-sm-12 table-responsive">
                                                    <?php
                                                    $finance_ids = array(1,2,3,4,5);
                                                    $sql_finance = $conn->prepare('SELECT amount ,no_of_savers from arbo_financial_status where arbo_financial_type_id = ? and arbo_profile_id = ?');
                                                    ?>
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
                                                                <?php
                                                                $sql_finance->bind_param('ii' , $finance_ids[0], $org_id);
                                                                $sql_finance->execute();
                                                                $sql_finance->bind_result($cap_amount,$cap_savers);
                                                                $sql_finance->store_result();
                                                                $sql_finance->num_rows();
                                                                $sql_finance->fetch();
                                                                ?>
                                                                <td>Capital Build Up:</td>
                                                                <td><input type="text" class="form-control" disabled name="part3_capital_amount"	id="part3_capital_amount" value="<?php echo $cap_amount?>" placeholder="Enter..."  ></td>
                                                                <td></td>
                                                                <td><input type="text" class="form-control" disabled name="part3_capital_savers" id="part3_capital_savers" value="<?php echo $cap_savers?>" placeholder="Enter..."  ></td>
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
                                                                <td><input type="text" class="form-control" disabled name="part3_savings_amount" id="part3_savings_amount"  value="<?php echo $cap_amount?>" placeholder="Enter..."  ></td>
                                                                <td></td>
                                                                <td><input type="text" class="form-control" disabled name="part3_savings_savers" id="part3_savings_savers"  value="<?php echo $cap_savers?>"placeholder="Enter..."  ></td>
                                                                 
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
                                                                <td><input type="text" class="form-control" disabled name="part3_total_amount" id="part3_totall_amount"  value="<?php echo $cap_amount?>" placeholder="Enter..."  ></td>
                                                                <td></td>
                                                                <td><input type="text" class="form-control" disabled name="part3_total_savers" id="part3_totall_savers"  value="<?php echo $cap_savers?>" placeholder="Enter..."  ></td>
                                                                 
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
                                                                <td><input type="text" class="form-control" disabled name="part3_liability_amount" id="part3_liability_amount"  value="<?php echo $cap_amount?>"  ></td>
                                                                <td></td>
                                                                <td><input type="text" class="form-control" disabled name="part3_liability_savers" id="part3_liability_savers"  value="<?php echo $cap_savers?>"  ></td>
                                                                
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
                                                                <td><input type="text" class="form-control" disabled name="part3_networth_amount" id="part3_total_amount" value="<?php echo $cap_amount;?>" disabled></td>
                                                                <td></td>
                                                                <td><input type="text" class="form-control" disabled name="part3_networth_savers" id="part3_total_savers" value="<?php echo $cap_savers;?>" disabled></td>
                                                                
                                                            </tr>
                                                        </tbody>	

                                                    </table><br>

                                                </div>


                                                <div class="col-lg-12 table-responsive">
                                                    
                                                    <table class="table table-bordered">
                                                    <thead class="bg-success-custom">
                                                        <tr>
                                                            <th colspan="12" style="padding:0px;"><center style="background-color:#00a65a;padding:2px;color:white;">
                                                            <h5><b>LOANS AVALIED IF ANY</b></h5></center></th>
                                                        </tr>
                                                    </thead>
                                                    <thead style="background-color:rgb(189, 255, 189);">
                                                            <tr>
                                                                <th rowspan="3" class="text-center" style="vertical-align: middle;">NATURE / PURPOSE OF LOAN</th>
                                                                <th rowspan="3" class="text-center" style="vertical-align: middle;">AMOUNT</th>
                                                                <th rowspan="3" class="text-center" style="vertical-align: middle;">SOURCE</th>
                                                                <th rowspan="3" class="text-center" style="vertical-align: middle;">DATE RELEASED</th>
                                                                <th rowspan="3" class="text-center" style="vertical-align: middle;">DATE AVAILED</th>
                                                                <th rowspan="3" class="text-center" style="vertical-align: middle;">TERMS OF PAYMENT</th>
                                                                <th rowspan="3" class="text-center" style="vertical-align: middle;">AMOUNT PAID</th>

                                                            </tr>
                                                        </thead>

                                                        <tbody id="add_row_7">
                                                            <?php
                                                            $loan_purpose_arr = array();
                                                            $loan_amount = array();
                                                            $loan_source = array();
                                                            $loan_date_r = array();
                                                            $loan_date_av = array();
                                                            $loan_terms_pay = array();
                                                            $loan_amount_pd = array(); 
                                                            $loan_id = array();
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
                                                                    array_push($loan_id, $loans_id);
                                                                    array_push($loan_purpose_arr,$loan_purpose);
                                                                    array_push($loan_amount,$amount);
                                                                    array_push($loan_source, $source);
                                                                    array_push($loan_date_r, $date_released);
                                                                    array_push($loan_date_av, $date_availed);
                                                                    array_push($loan_terms_pay, $terms_payment);
                                                                    array_push($loan_amount_pd, $amount_paid);
                                                                }
                                                            }

                                                            for($i = 0 ; $i < count($loan_id); $i++) {
                                                                    if(empty($loan_amount[$i])) {
                                                                        echo '<tr id="rw2_'.$i.'">
                                                                        <td>
                                                                        <input type="hidden" name="loans_id[]">
                                                                        <input type="text" disabled class="form-control" name="purpose_of_loan[]"></td>
                                                                        <td><input type="text" disabled class="form-control" name="loan_amount[]" placeholder="Enter..."></td>
                                                                        <td><input type="text" disabled class="form-control" name="loan_source[]" value="'.$loan_source[$i].'" placeholder="Enter..."></td>
                                                                        <td><input type="date" disabled class="form-control" name="loan_date_released[]" value="'.$loan_date_r[$i].'" placeholder="Enter..."></td>
                                                                        <td><input type="date" disabled class="form-control" name="loan_date_availed[]" value="'.$loan_date_av[$i].'" placeholder="Enter..."></td>
                                                                        <td><input type="text" disabled class="form-control" name="loan_terms_payment[]" value="'.$loan_terms_pay[$i].'" placeholder="Enter..."></td>
                                                                        <td><input type="text" disabled class="form-control" name="loan_amount_paid[]" value="'.$loan_amount_pd[$i].'" placeholder="Enter..."></td>
                                                                    </tr>';
                                                                    } else {
                                                                        echo '<tr id="rw2_'.$i.'">
                                                                        <td>
                                                                        <input type="hidden" name="loans_id[]">
                                                                        <input type="text" disabled class="form-control" name="purpose_of_loan[]" value="'.$loan_purpose_arr[$i].'" placeholder="Enter..."></td>
                                                                        <td><input type="text" disabled class="form-control" name="loan_amount[]" value="'.$loan_amount[$i].'" placeholder="Enter..."></td>
                                                                        <td><input type="text" disabled class="form-control" name="loan_source[]" value="'.$loan_source[$i].'" placeholder="Enter..."></td>
                                                                        <td><input type="date" disabled class="form-control" name="loan_date_released[]" value="'.$loan_date_r[$i].'" placeholder="Enter..."></td>
                                                                        <td><input type="date" disabled class="form-control" name="loan_date_availed[]" value="'.$loan_date_av[$i].'" placeholder="Enter..."></td>
                                                                        <td><input type="text" disabled class="form-control" name="loan_terms_payment[]" value="'.$loan_terms_pay[$i].'" placeholder="Enter..."></td>
                                                                        <td><input type="text" disabled class="form-control" name="loan_amount_paid[]" value="'.$loan_amount_pd[$i].'" placeholder="Enter..."></td>
                                                                    </tr>';
                                                                    }
                                                            }
                                                            if(count($loan_id) == 0) {
                                                                echo '<tr><td colspan="12" style="color:gray;text-align:center;">< Empty ></td></tr>';
                                                            }
                                                            ?>

                                                        </tbody>
                                                    </table><br>

                                                </div>

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
                                                                <th colspan="5" class="text-center" style="vertical-align: middle;">NUMBER OF PAX</th>

                                                            </tr>

                                                        </thead>

                                                        <thead style="background-color:rgb(189, 255, 189);">
                                                            <tr>
                                                            <th class="text-center" style="vertical-align: middle;">TITLE OF TRAINING</th>
                                                            <th class="text-center" style="vertical-align: middle;">DATE CONDUCTED</th>
                                                            <th class="text-center" style="vertical-align: middle;">CONDUCTED BY</th>
                                                            <th class="text-center" style="vertical-align: middle;">OFFICERS</th>
                                                            <th class="text-center" style="vertical-align: middle;">MEMBERS</th>
                                                            </tr>

                                                        </thead>

                                                        <tbody id="add_row_8">
                                                            <?php
                                                            $trnings_attnd = 'SELECT id, title, date_conducted, conducted_by, no_of_pax_officers, no_of_pax_members
                                                            from arbo_org_trainings_attended prof WHERE arbo_profile_id = ?';
                                                            $run_trnings_attnd = $conn->prepare($trnings_attnd);
                                                            $run_trnings_attnd->bind_param('i',$org_id);
                                                            $run_trnings_attnd->execute();
                                                            $run_trnings_attnd->bind_result($trainings_att_id, $training_title,$date_conducted,$conducted_by, $no_of_officer,$no_of_member);
                                                            $run_trnings_attnd->store_result();
                                                            $i=0;
                                                            if($run_trnings_attnd->num_rows() > 0){
                                                                while($run_trnings_attnd->fetch()){
                                                                    if($no_of_member == 0) {
                                                                        $no_of_member = '';
                                                                    }
                                                                    if($no_of_officer == 0) {
                                                                        $no_of_officer = '';
                                                                    }
                                                                echo 
                                                                '<tr id="rw3_'.$i.'">
                                                                    <td><input type="hidden" name="trainings_att_id[]" value="'.$trainings_att_id.'">
                                                                    <input type="text" class="form-control" disabled name="part3_title[]" value="'.$training_title.'"  ></td>
                                                                    <td><input type="text" class="form-control" disabled name="part3_date_conducted[]" value="'.$date_conducted.'"  ></td>
                                                                    <td><input type="text" class="form-control" disabled name="part3_date_conducted[]" value="'.$conducted_by.'"  ></td>
                                                                    <td><input type="text" class="form-control" disabled name="part3_officers[]" value="'.$no_of_officer.'" ></td>
                                                                    <td><input type="text" class="form-control" disabled name="part3_members[]" value="'.$no_of_member.'" ></td>
                                                                </tr>';
                                                                $i++;
                                                                }
                                                            } else {
                                                                echo '<tr><td colspan="12" style="color:gray;text-align:center;">< Empty ></td></tr>';
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
                                        <button type="button" onclick="plusDivs(-1, 2)" class="btn btn-sm btn-success" style="background-color:green">
                                            <i class="fa fa-chevron-left"></i> Previous
                                        </button>
                                        <button type="button" onclick="plusDivs(+1, 4)" class="btn btn-sm btn-success">
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

                    <div class="form-group col-sm-12">

                        <div class="form-group">
                            <div class="col-lg-12">
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
                                            
                                        </tr>

                                    </thead>
                    

                                <tbody>
                                <?php
                                    $sql24 = $conn->prepare('SELECT pos.description, mem.fn_arb , mem.ln_arb, mem.mn_arb
                                    from arbo_position_type as pos inner join 
                                    arbo_officers_n_bod as offcr_bod on pos.id = offcr_bod.arbo_position_type_id
                                    inner join part1_arb_household as mem on mem.hhold_id = offcr_bod.arbo_mem_id
                                    where pos.id = offcr_bod.arbo_position_type_id and offcr_bod.arbo_profile_id = ?');
                                    
                                    $sql24->bind_param('i',$org_id);
                                    $sql24->execute();
                                    $sql24->bind_result($description,$fname,$lname,$mname);
                                    $sql24->store_result();
                                        if($sql24->num_rows() > 0){
                                            while($sql24->fetch()){
                                                $fullname = $fname . ' ' .$lname . ' ' .$mname;
                                                if(!empty($fullname)) {
                                                    echo '<tr> 	<td><input type="text" disabled class="form-control" value="'.$fullname.'" disabled name="C[]"></td>
                                                                <td><input type="text" disabled class="form-control" value="'.$description.'" disabled name="part4_name_directors[]"></td>
                                                        </tr>';
                                                } else {
                                                    echo '<tr> 	<td><input type="text" disabled class="form-control" disabled name="C[]"></td>
                                                            <td><input type="text" disabled class="form-control" disabled name="part4_name_directors[]"></td>
                                                    </tr>';
                                                }
                                                
                                            } 
                                        } else {
                                            for($i = 0 ; $i < 3 ; $i++) {
                                                echo '<tr> 	<td><input type="text" disabled class="form-control" disabled name="C[]"></td>
                                                            <td><input type="text" disabled class="form-control" disabled name="part4_name_directors[]"></td>
                                                    </tr>';
                                            }
                                        }
                                    $sql24->close();
                                ?>
                                </tbody>	
                            </table><br><br><br>
                        </div> 
                        <div class="col-lg-12 table-responsive">
                        <h4 class="text-center"><b>LIST OF COMMITTEES AND MEMBERS</b></h4>
                    <!-- <thead> -->
                <!-- comm start -->
                <div class="table-responsive">
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

                        if($sql_run->num_rows() > 0){
                            while($sql_run->fetch()) {
                                array_push($committee,$description);
                            }
                        }

                    
                                for($i = 0 ; $i < count($committee) ; $i++) {
                                    echo '<div class="col-lg-12 table-responsive">
                                    <table class="table table-bordered">

                                    <thead style="background-color:#00a65a;padding:2px;color:white;">
                                        <tr>
                                        <th>COMMITTEE</th>
                                        <th><input type="text" class="form-control" disabled style="background-color:rgba(255,255,255,.0); border:0px;border-bottom:1px solid white;);"
                                        value="'.ucfirst($committee[$i]).'"></th>
                                        </tr>
                                    </thead>
                                        <thead style="background-color:rgb(189, 255, 189);">
                                        <tr>
                                            <th>NAMES</th>
                                            <th>POSITION</th>
                                        </tr>
                                    </thead>
                                <tbody id="">';
                                    $sql24->bind_param('is',$org_id,$committee[$i]);
                                    $sql24->execute();
                                    $sql24->bind_result($id, $fname, $lname, $mname, $description, $committee_);
                                    $sql24->store_result();
                                        if($sql24->num_rows() > 0){
                                            while($sql24->fetch()){
                                            $fullname = $fname . ' ' . $lname . ' ' . $mname; 
                                                if($committee[$i] == $committee_ && !empty($committee_)) {
                                                    echo '<tr>
                                                            <td><input disabled type="text" disabled class="form-control" value="'.$fullname.'" name="C[]"></td>
                                                            <td><input disabled type="text" disabled class="form-control" value="'.$description.'" name="part4_name_directors[]"></td>
                                                        </tr>';                                                                               
                                                } else {
                                                    echo '<tr>
                                                    <td><input disabled type="text" disabled class="form-control"  name="C[]"></td>
                                                    <td><input disabled type="text" disabled class="form-control"  name="part4_name_directors[]"></td>
                                                </tr>';  
                                                }
                                            }
                                        }

                                        echo '</tbody>
                                        </table>
                                    </div>';
                                    }
                                    if(count($committee) < 1) {
                                        for($i = 0 ; $i < 1 ; $i++) {
                                            echo '<div class="col-lg-12 table-responsive">
                                                <table class="table table-bordered">

                                                <thead style="background-color:#00a65a;padding:2px;color:white;">
                                                    <tr>
                                                    <th>COMMITTEE</th>
                                                    <th><input type="text" class="form-control custom-input-white"
                                                    value=""  disabled></th>
                                                    </tr>
                                                    </thead>
                                                    <thead style="background-color:rgb(189, 255, 189);">
                                                    <tr>
                                                        <th>NAMES</th>
                                                        <th>POSITION</th>
                                                    </tr>
                                                </thead>
                                            <tbody id="">
                                            <tr>
                                                <td><input disabled type="text" disabled class="form-control" name="C[]"></td>
                                                <td><input disabled type="text" disabled class="form-control" name="part4_name_directors[]"></td>
                                            </tr>
                                            <tr>
                                                <td><input type="text" disabled class="form-control" name="C[]"></td>
                                                <td><input type="text" disabled class="form-control" name="part4_name_directors[]"></td>
                                            </tr>
                                            <tr>
                                                <td><input type="text" disabled class="form-control" name="C[]"></td>
                                                <td><input type="text" disabled class="form-control" name="part4_name_directors[]"></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>';
                                        }
                                    }
                        
                    $sql24->close();
                    ?>
            </div><br><br><div class="col-lg-12 table-responsive">
                                                    <div style="background-color:#00a65a;padding:2px;color:white;">
                                                        <center><h4>PROGRAMS ACCESSED FROM DAR</h4></center>
                                                    </div>
                                                    <table class="table table-striped">
                                                        <tbody>
                                                        
                                                        <?php
                                                        $qid = array(79,95,96,97,98);
                                                        $j = 0;
                                                        $sql_show_arbo_inter = $conn->prepare('SELECT acq.sub_id, def.description
                                                            FROM arbo_acquired_intervention as acq
                                                            inner join arbo_sub_intervention as def
                                                            on acq.sub_id = def.id
                                                            where def.main_id = ? and arbo_profile_id = ?');

                                                        $sql_show_arbo_inter->bind_param('ii' , $qid[0] , $org_id);
                                                        $sql_show_arbo_inter->execute();
                                                        $sql_show_arbo_inter->bind_result($id,$description);
                                                        $sql_show_arbo_inter->store_result();
                                                        if($sql_show_arbo_inter->num_rows() > 0) {
                                                            echo '
                                                                <tr>
                                                                    <th style="width: 10px">Code</th>
                                                                    <th class="text-center">Is your organization a beneficiary of [mention program]?</th>
                                                                    <th style="width:10px;">Yes</th>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="3"style="background-color:rgb(189, 255, 189);" class="text-center" id="79"><strong>Agrarian Reform Community Connectivity and Economic Support Services</strong></td>
                                                                </tr>';
                                                            while($sql_show_arbo_inter->fetch()) {
                                                                echo '<tr>
                                                                        <td>' . ($j+1) . '</td>
                                                                        <td>' . $description . '</td>
                                                                        <td><input type="checkbox" disabled checked value="'.$id.'" name="q79[]"/></td> 
                                                                    </tr>';
                                                                $j++;
                                                                }
                                                            }

                                                        $j = 0;
                                                        $sql_show_arbo_inter->bind_param('ii' , $qid[1] , $org_id);
                                                        $sql_show_arbo_inter->execute();
                                                        $sql_show_arbo_inter->bind_result($id,$description);
                                                        $sql_show_arbo_inter->store_result();
                                                        if($sql_show_arbo_inter->num_rows() > 0) {
                                                            echo '<tr>
                                                                    <td colspan="3"style="background-color:rgb(189, 255, 189);" class="text-center" id="95"><strong>Partnership Development Projects</strong></td>
                                                                </tr>';

                                                                
                                                            while($sql_show_arbo_inter->fetch()) {
                                                                echo '<tr>
                                                                        <td>' . ($j+1) . '</td>
                                                                        <td>' . $description . '</td>
                                                                        <td><input type="checkbox" disabled checked value="'.$id.'" name="q95[]"/></td> 
                                                                    </tr>';
                                                                $j++;
                                                            }
                                                        }
                                                        $j = 0;
                                                        $sql_show_arbo_inter->bind_param('ii' , $qid[2] , $org_id);
                                                        $sql_show_arbo_inter->execute();
                                                        $sql_show_arbo_inter->bind_result($id,$description);
                                                        $sql_show_arbo_inter->store_result();
                                                        if($sql_show_arbo_inter->num_rows() > 0) {
                                                            echo ' <tr>
                                                                        <td colspan="3"style="background-color:rgb(189, 255, 189);" class="text-center" id="96"><strong> Foreign Assisted Projects</strong></td>
                                                                    </tr>';
                                                            while($sql_show_arbo_inter->fetch()) {
                                                                echo '<tr>
                                                                        <td>' . ($j+1) . '</td>
                                                                        <td>' . $description . '</td>
                                                                        <td><input type="checkbox" disabled checked value="'.$id.'" name="q96[]"/></td> 
                                                                    </tr>';
                                                                $j++;
                                                            }
                                                        }
                                                        $j = 0;
                                                        $sql_show_arbo_inter->bind_param('ii' , $qid[3] , $org_id);
                                                        $sql_show_arbo_inter->execute();
                                                        $sql_show_arbo_inter->bind_result($id,$description);
                                                        $sql_show_arbo_inter->store_result();
                                                        if($sql_show_arbo_inter->num_rows() > 0) {
                                                            echo '<tr>
                                                                    <td colspan="3" style="background-color:rgb(189, 255, 189);" class="text-center" id="97"><strong> Microfinance and Credit Programs</strong></td>
                                                                </tr>';
                                                            while($sql_show_arbo_inter->fetch()) {
                                                                echo '<tr>
                                                                        <td>' . ($j+1) . '</td>
                                                                        <td>' . $description . '</td>
                                                                        <td><input type="checkbox" disabled checked value="'.$id.'" name="q97[]"/></td> 
                                                                    </tr>';
                                                                $j++;
                                                            }
                                                        }  
                                                    ?>
                                                    </tbody>
                                                    </table>
                                                    <?php
                                                    $j = 0;
                                                    $sql_show_arbo_inter = $conn->prepare('SELECT acq.sub_id, acq.specify_intervention, def.description
                                                    FROM arbo_acquired_intervention as acq
                                                    inner join arbo_sub_intervention as def
                                                    on acq.sub_id = def.id
                                                    where def.main_id = ? and arbo_profile_id = ?');

                                                    $sql_show_arbo_inter->bind_param('ii' , $qid[4] , $org_id);
                                                    $sql_show_arbo_inter->execute();
                                                    $sql_show_arbo_inter->bind_result($id, $desc_specify, $description);
                                                    $sql_show_arbo_inter->store_result();
                                                    if($sql_show_arbo_inter->num_rows() > 0) {
                                                    echo '<div class="table-responsive">
                                                            <table class="table table-striped">
                                                            <tbody>
                                                                <tr>
                                                                    <td style="background-color:rgb(189, 255, 189);" class="text-center" colspan="5"><strong>Partner Agencies</strong></td>
                                                                </tr>';
                                                    while($sql_show_arbo_inter->fetch()) {
                                                        echo '<tr>
                                                                <td>' . ($j+1) . '</td>
                                                                <td>' . $description . '</td>
                                                                <td><input type="text" disabled value="'.$desc_specify.'" name="q98[]"/></td> 
                                                                <td><input type="checkbox" disabled checked value="'.$id.'" name="q98[]"/></td> 
                                                            </tr>';
                                                        $j++;
                                                    }
                                                    echo '</tbody>
                                                        </table>
                                                        </div>';
                                                    }
                                                    ?>


            </div>
<!-- comm end -->
</div>

</div>

</div>

</div>
</div>
</div>
                        <div class="box-footer with-border">
                                    <div class="btn-group pull-right">
                                        <button type="button" onclick="plusDivs(-1, 3)" class="btn btn-sm btn-success" style="background-color:green">
                                            <i class="fa fa-chevron-left"></i> Previous
                                        </button>
                                        <button type="button" onclick="plusDivs(+1, 5)" class="btn btn-sm btn-success">
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
                                                <div class="form-group col-sm-12"><br>
                                                <center><h4><b>COOPERATIVE MEMBERS</b></h4></center>
                                                <p><b>TOTAL LANDSIZE (ha): </b><span><u id="landsize"></u></span>
                                                &nbsp;&nbsp;&nbsp;<b>TOTAL MEMBERS:</b> <u id="show_total_members"></u></p>
                                                <div id="association_members" class="table-responsive">
                                                    
                                                    <table class="table table-bordered associate_tbl" id="assoc_members_list">
                                                        <thead>
                                                            <tr>
                                                                <th>ORGS</th>
                                                                <th class="headcol1" style="min-width:120px;">FULLNAME</th>
                                                                <th>POSITION</th>
                                                                <th>GENDER</th>
                                                                <th>STATUS</th>
                                                                <th>ACTIVE</th>
                                                                <th>CLOA #</th>
                                                                <th>LANDSIZE(ha)</th>
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
                                                                <th style="min-width:450px;">TRAININGS ATTENDED</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="assoc_tbl"> 
                                                            <?php
                                                                $ttl_lndsize = $ttl_mem = 0;
                                                                $sql_show_members = "SELECT distinct(mem.hhold_id),
                                                                concat_ws(' ' , mem.fn_arb, mem.mn_arb, mem.ln_arb) as fullname,
                                                                pos_type.description, asc_mem.sex, asc_mem.arbo_arb_type_id, asc_mem.arbo_status_id, asc_mem.cloa_no,
                                                                (CASE
                                                                    WHEN asc_mem.land_size = ''
                                                                    THEN asc_mem.land_size = 0
                                                                    ELSE asc_mem.land_size
                                                                    END) as landsize,
                                                                asc_mem.assoc_crop, asc_mem.cbu, asc_mem.monthly_due, 
                                                                asc_mem.production ,asc_mem.marketing, asc_mem.credit, asc_mem.phf, asc_mem.micro_ent ,asc_mem.service, asc_mem.others, asc_mem.trainings_attended
                                                                FROM arbo_position_type as pos_type inner join 
                                                                arbo_association_members as asc_mem 
                                                                on pos_type.id = asc_mem.arbo_position_type_id
                                                                inner join part1_arb_household as mem
                                                                on mem.hhold_id = asc_mem.arbo_mem_id
                                                                where ARBO_PROFILE_ID = ? and pos_type.id = asc_mem.arbo_position_type_id";
                                                                $run_sql_show_members = $conn->prepare($sql_show_members);
                                                                $run_sql_show_members->bind_param('i' , $org_id);
                                                                $run_sql_show_members->execute();
                                                                $run_sql_show_members->bind_result($id, $fullname,
                                                                    $arbo_position_type, $sex, $arbo_arb_type_id, $arbo_status_id, $cloa_no,$landsize ,$crops, $cbu,
                                                                    $savings, $production ,$marketing, $credit, $phf, $micro_ent ,$service, $others, $trainings_attended);
                                                                $run_sql_show_members->store_result();
                                                                $i = 0;
                                                                if($run_sql_show_members->num_rows() > 0) {
                                                                    while($run_sql_show_members->fetch()) {
                                                                        $ttl_lndsize += $landsize;
                                                                        ++$ttl_mem;
                                                                        $landsize = number_format($landsize);
                                                                        
                                                                        // $fullname = $first_name . ' ' . $last_name . ' ' . $middle_initial ;
                                                                        echo '<tr>
                                                                        <td style="min-width:20px;pading-top:3em;">
                                                                                <button class="btn btn-sm btn-default show_org_count" id="show_org_count'.$id.'" type="button" data-toggle="modal" data-target="#show_org_'.$id.'" >
                                                                                <span id="org_count_1"></span>
                                                                                </button>
                                                                            </td>
                                                                            <td class="headcol1">
                                                                                <input type="hidden"  disabled  value="'.$id.'" name="assoc_mem_id[]">
                                                                                <input type="hidden" disabled value="'.$fullname.'" name="assoc_full_name" class="assoc_full_name" >
                                                                                <p>'.$fullname.'</p>
                                                                            </td>
                                                                            
                                                                            <td>
                                                                                '.$arbo_position_type.'
                                                                            </td>
                                                                            ';
                                                                            if($sex == 1) {
                                                                                echo '<td style="max-width:80px;min-width:80px;">Male</td>';
                                                                            } else {
                                                                                echo '<td style="max-width:80px;min-width:80px;">Female</td>';
                                                                            }
                                                                            if($arbo_arb_type_id == 1){
                                                                                echo '<td style="max-width:80px;min-width:80px;">ARB</td>';
                                                                                
                                                                            } else {
                                                                                echo '<td style="max-width:80px;min-width:80px;">NON-ARB</td>';
                                                                                
                                                                            }
                                                                            if($arbo_status_id == 1) {
                                                                                echo '<td>
                                                                                        <input type="checkbox" disabled name="assoc_status[]" checked   id="assoc_status" value="1">
                                                                                    </td>';
                                                                            } else {
                                                                                echo '<td>
                                                                                    <input type="checkbox" disabled name="assoc_status[]"   id="assoc_status" value="1">
                                                                                </td>';
                                                                            }
                                                                            echo '<td>
                                                                                    '.$cloa_no.'
                                                                                </td>';
                                                                            echo '<td>
                                                                                    '.$landsize.'
                                                                                </td>';
                                                                            echo '<td>
                                                                                '.$crops.'
                                                                            </td>';
                                                                            if($cbu == 1) {
                                                                                echo '<td>
                                                                                    <input type="checkbox" disabled name="assoc_cbu[]" checked    id="assoc_cbu" value="1">
                                                                                </td>';
                                                                            } else {
                                                                                echo '<td>
                                                                                    <input type="checkbox" disabled name="assoc_cbu[]"    id="assoc_cbu" value="1">
                                                                                </td>';
                                                                            }
                                                                            if($savings == 1) {
                                                                                echo '<td>
                                                                                    <input type="checkbox" class="custom_input" checked disabled value="1" name="assoc_saving[]" id="assoc_saving">
                                                                                </td>';
                                                                            } else {
                                                                                echo '<td>
                                                                                    <input type="checkbox" class="custom_input" value="0" disabled name="assoc_saving[]" id="assoc_saving">
                                                                                </td>';
                                                                            }
                                                                            if($production == 1) {
                                                                                echo '<td>
                                                                                    <input type="checkbox" disabled name="assoc_production[]" checked   id="assoc_production" value="1">
                                                                                </td>';
                                                                            } else {
                                                                                echo '<td>
                                                                                        <input type="checkbox" disabled name="assoc_production[]"   id="assoc_production" value="1">
                                                                                    </td>';
                                                                            }
                                                                            if($marketing == 1) {
                                                                                echo '<td>
                                                                                        <input type="checkbox" disabled name="assoc_mrktng[]" checked    id="assoc_mrktng" value="1">
                                                                                    </td>';
                                                                            } else {
                                                                                echo '<td>
                                                                                    <input type="checkbox" disabled name="assoc_mrktng[]"    id="assoc_mrktng" value="1">
                                                                                </td>';
                                                                            }
                                                                            if($credit == 1) {
                                                                                echo '<td>
                                                                                    <input type="checkbox" disabled name="assoc_credit[]" checked   id="assoc_credit" value="1">
                                                                                </td>';
                                                                            } else {
                                                                                echo '<td>
                                                                                    <input type="checkbox" disabled name="assoc_credit[]"   id="assoc_credit" value="1">
                                                                                </td>';
                                                                            }
                                                                            if($phf) {
                                                                                echo '<td>
                                                                                    <input type="checkbox" disabled name="assoc_phf[]" checked     id="assoc_phf" value="1">
                                                                                </td>';
                                                                            } else {
                                                                                echo '<td>
                                                                                        <input type="checkbox" disabled name="assoc_phf[]"     id="assoc_phf" value="1">
                                                                                    </td>';
                                                                            }
                                                                            if($micro_ent == 1) {
                                                                                echo '<td>
                                                                                    <input type="checkbox" disabled name="assoc_micro[]" checked   id="assoc_micro" value="1">
                                                                                </td>';
                                                                            } else {
                                                                                echo '<td>
                                                                                    <input type="checkbox" disabled name="assoc_micro[]"   id="assoc_micro" value="1">
                                                                                </td>';
                                                                            }
                                                                            if($service==1){
                                                                                echo '<td>
                                                                                        <input type="checkbox" disabled name="assoc_srvce[]" checked   id="assoc_srvce" value="1">
                                                                                    </td>';
                                                                            } else {
                                                                                echo '<td>
                                                                                    <input type="checkbox" disabled name="assoc_srvce[]"   id="assoc_srvce" value="1">
                                                                                </td>';
                                                                            }
                                                                           
                                                                                
                                                                            echo '<td>
                                                                                '.$others.'
                                                                                    </td>';
                                                                           
                                                                            echo '<td>
                                                                                    '.$trainings_attended.'
                                                                                </td>
                                                                                
                                                                            <div id="show_org_'.$id.'" class="modal fade" role="dialog">
                                                                            <div class="modal-dialog modal-lg">
                                                                                    <div class="modal-content">
                                                                                    <div class="modal-header">
                                                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                                        <h4 class="modal-title">Modal Header</h4>
                                                                                    </div>
                                                                                    <div class="modal-body">
                                                                                        <p>Some text in the modal.</p>
                                                                                    </div>
                                                                                    <div class="modal-footer">
                                                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                                    </div>
                                                                                    </div>

                                                                                </div>
                                                                                </div>
                                                                                </tr>';
                                                                                
                                                                    }
                                                                }

                                                                $ttl_lndsize = number_format($ttl_lndsize);
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                
                                                    <div>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                        <div class="box-footer clearfix">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer with-border">
                            <div class="btn-group pull-right">
                                <button type="button" onclick="plusDivs(-1, 4)" class="btn btn-sm btn-primary" style="background-color:green">
                                    <i class="fa fa-chevron-left"></i> Previous
                                </button>
                            </div>
                        </div>

                
            </div>
        </div>
    </div>

</section>
    <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->


<?php include 'inc/scripts.php';?>
<script src="../js/arbo-form.js"></script>
<script>
    
    $(function () {
                $('#assoc_members_list').DataTable({
                    'paging': true,
                    'lengthChange': true,
                    'searching': true,
                    'ordering': false,
                    'info': true,
                    'autoWidth': false,
    buttons: [
        'excelHtml5'
    ],
    "lengthMenu": [[6, 25, 50, -1], [6, 25, 50, "All"]],
    "bInfo": false,
    });
    });

    $().ready(function() {
        $('#landsize').html('<?php echo $ttl_lndsize; ?>');
        $('#show_total_members').html('<?php echo $ttl_mem; ?>');
    });

    function enable(id) {
        $('#' + id).removeAttr('disabled', 'disabled');
    }

    function checkArb(index) {
        var assoc_full_name = $('.assoc_full_name').eq(index).val();
        // var index = $(this).index('.assoc_firstname');
        // index = $(".assoc_firstname").index(this);
        $('.assoc_full_name').eq(index).val()
        $.post('controller/show_mem_org.php', {
            assoc_full_name : assoc_full_name,
            index : index
        } , function(data,status) {
            $('.show_org_count').eq(index).replaceWith(data);
        });
    }

    (function() {
        $lngth = $('.assoc_full_name').length;
        for($i = 0 ; $i < $lngth ; $i++) {
        checkArb($i);
    }
    })();
</script>
</body>
</html>
<?php } else {
    header('Location:../index.php');
}?>