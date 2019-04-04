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
        <style>
            body{
                font-family:sans-serif;
                font-size:12px;
            }
        .table th {
            border-bottom:1px solid gray;
            border-right:1px solid gray;
        }
        .table-bordered> tbody>tr>td,
        .table-bordered>tbody>tr>th,
        .table-bordered>tfoot>tr>td,
        .table-bordered>tfoot>tr>th,
        .table-bordered>thead>tr>td,
        .table-bordered>thead>tr>th {
            border: 1px solid #ddd;
        }
        .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
            padding: 2px;
            line-height: 1.42857143;
            vertical-align: top;
            border-top: 1px solid #ddd;
        }
        td, th {
            padding: 0;
        }
        .table {
            border-collapse: collapse;
            border-spacing: 0;
        }
        .table {
            display: table;
            border-collapse: separate;
            border-spacing: 0px;
            border-color: grey;
        }
        .pagebreak { page-break-before: always; }
        input[type="text"] {
            border:0px;
            border-bottom:1px solid gray;
            outline:none;
        }
        input[type="text"]:disabled {
            background-color:white;
        }
        .cust_inline {
            display:inline;
        }
        </style>
    </head>

    <body>
        <?php
            $org_id = isset($_GET['id']) ? $_GET['id'] : 0;
            $sql = 'SELECT * FROM arbo_profile where id = ?';

            $run_sql = $conn->prepare($sql);
            $run_sql->bind_param('i' , $org_id);
            $run_sql->execute();
            $run_sql->bind_result($id ,$name , $as_of_date, $form_image, $acronym ,
                $arbo_province , $arbo_city, $arbo_brgy, $arbo_addr_others,
                $area_of_operation_prov, $area_of_operation_city, $area_of_operation_brgy,
                $area_of_operation_others, $contact_person, $date_organized,
                $date_registered, $registration_no, $agency_registered,
                $type_of_organization, $affiliation, $date_created, $date_updated);
            $run_sql->store_result();
            $run_sql->num_rows();
            $run_sql->fetch();
            $run_sql->store_result();
            if($run_sql->num_rows() > 0){
                while($run_sql->fetch()){

                }
            }
            $arbo_addr = $arbo_addr_others .', '. $arbo_brgy .', '. $arbo_city .', '.$arbo_province ;
            if(empty($arbo_addr_others)) {
                $arbo_addr = $arbo_brgy .', '. $arbo_city .', '.$arbo_province;
            }
            $area_of_ope = $area_of_operation_others .', '. $area_of_operation_brgy.', '. $area_of_operation_city
            .', '.$area_of_operation_prov;
            if(empty($area_of_operation_others)) {
                $area_of_ope =$area_of_operation_brgy.', '. $area_of_operation_city.', '.$area_of_operation_prov;
            }
        ?>
        <div style="width:720px;border:1px double gray;border-width:5px;padding:10px;">
            <center><b>PO PROFILE<b></center>
            </div><br><br>
        <center><span>
        As of:<input disabled type='text' class='border-bottom' value="<?php echo $as_of_date ; ?>" style='width:500px;'></center><br>

        <table>
        <tbody>
            <tr>
                <td style="width:160px;"><b>Name of PO:</b></td>
                <td><input disabled type='text' class='border-bottom' value="<?php echo $name ; ?>" style='width:500px;'></span></td>
            </tr>
            <tr>
                <td style="width:160px;"><b>Acronym:</b></td>
                <td><input disabled type='text' class='border-bottom' value="<?php echo $acronym ; ?>" style='width:500px;'></span></td>
            </tr>
            <tr>
                <td style="width:160px;"><b>Address:</b></td>
                <td><input disabled type='text' class='border-bottom' value="<?php echo $arbo_addr; ?>" style='width:500px;'></span></td>
            </tr>
            <tr>
                <td style="width:160px;"><b>Area of Operation:</b></td>
                <td><input disabled type='text' class='border-bottom'value="<?php echo $area_of_ope ; ?>" style='width:500px;'></span></td>
            </tr>
            <tr>
                <td style="width:160px;"><b>Contact person:</b></td>
                <td><input disabled type='text' class='border-bottom' value="<?php echo $contact_person ; ?>"  style='width:500px;'></span></td>
            </tr>
            <tr>
                <td style="width:160px;"><b>Date organized:</b></td>
                <td><input disabled type='text' class='border-bottom' value="<?php echo $date_organized ; ?>" style='width:500px;'></span></td>
            </tr>
            <tr>
                <td style="width:160px;"><b>Date registered:</b></td>
                <td><input disabled type='text' class='border-bottom' value="<?php echo $date_registered ; ?>"  style='width:500px;'></span></td>
            </tr>
            <tr>
                <td style="width:160px;"><b>Registration No.:</b></td>
                <td><input disabled type='text' class='border-bottom' value="<?php echo $registration_no ; ?>"  style='width:500px;'></span></td>
            </tr>
            <tr>
                <td style="width:160px;"><b>Agency/Entity registered:</b></td>
                <td><input disabled type='text' class='border-bottom' value="<?php echo $agency_registered ; ?>" style='width:500px;'></span></td>
            </tr>
            <tr>
                <td style="width:160px;"><b>Type of Organization:</b></td>
                <td><input disabled type='text' class='border-bottom' value="<?php echo $type_of_organization ; ?>" style='width:500px;'></span></td>
            </tr>
            <tr>
                <td style="width:160px;"><b>Affiliation:</b></td>
                <td><input disabled type='text' class='border-bottom' value="<?php echo $affiliation ; ?>" style='width:500px;'></span></td>
            </tr>
        </tbody>
        
        </table>
        
        <br>
<br>
<table style="border:0px;width:700px;">
        NAME OF NGO/ORGANIZATION ASSISTING: <br>
            <!-- <thead style="border:0px;">
                <tr style="border:0px;">
                    <th style="border:0px;"></th>
                    <th style="border:0px;" class="text-center">YEAR</th>
                </tr>
            </thead>     -->

            <tbody id="add_row_1">
            <?php
                    $i = 0;
                    $sql_arbo_or_org_assist = 'SELECT id, name_of_ngo_assisting, ngo_year_assisted
                    from arbo_ngo_or_org_assist where arbo_profile_id = ?';
                    $run_sql_arbo_or_org_assist = $conn->prepare($sql_arbo_or_org_assist);
                    $run_sql_arbo_or_org_assist->bind_param('i' , $org_id);
                    $run_sql_arbo_or_org_assist->execute();
                    $run_sql_arbo_or_org_assist->bind_result($org_assist_id, $org_assstng, $org_yr_asstng);
                    $run_sql_arbo_or_org_assist->store_result();
                    if($run_sql_arbo_or_org_assist->num_rows()){
                        while($run_sql_arbo_or_org_assist->fetch()){
                        echo "<tr style='border:0px;'>
                            <td style='border:0px;'><input disabled type='text' value='$org_assstng' class='border-bottom' style='width:360px;'></td>
                            <td style='border:0px;'><input disabled type='text' value='$org_yr_asstng' class='border-bottom' style='width:90px;'></td>
                        </tr>";
                        $i++;
                        }
                    } else {
                    echo "<tr style='border:0px;'>
                            <td style='border:0px;'><input disabled type='text' class='border-bottom' style='width:360px;'></td>
                            <td style='border:0px;'><input disabled type='text' class='border-bottom' style='width:90px;'></td>
                        </tr>
                        <tr style='border:0px;'>
                            <td style='border:0px;'><input disabled type='text' class='border-bottom' style='width:360px;'></td>
                            <td style='border:0px;'><input disabled type='text' class='border-bottom' style='width:90px;'></td>
                        </tr>";
                    }
                    ?>
        </table><br><br>
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


        <div class="box-body">
        <b>CURRENT SERVICES PROVIDED:</b><br><br>

            <?php
            $count_services = 0;
                $serv_type = array(1,2,3,4,5);
                $sql_services = 'SELECT distinct(sub.description) ,sub.id, srvce_prvded.units_or_heads
                , srvce_prvded.client_served_members, srvce_prvded.client_served_non_members
                from arbo_services_provided as srvce_prvded
                inner join arbo_service_sub as sub on sub.id = srvce_prvded.arbo_service_sub_id
                inner join arbo_sevice_main as main on main.id = sub.arbo_service_main_id
                where srvce_prvded.arbo_profile_id = ? and  main.id = ?';
                $sql = 'SELECT id,description FROM arbo_service_sub WHERE arbo_service_main_id = ? order by id ASC';
            ?>
            
                <table class="table table-bordered"  style="display: inline-block;">
                <thead class="bg-primary" >
                    <tr>
                        <th style="border-top:0px;border-bottom:0px;border-left:0px;"></th>
                        <th colspan="3" class="text-center" style="vertical-align: middle;">Clients Served</th>		
                    </tr>
                </thead>

                <thead class="bg-primary" >
                    <tr>
                        <th class="text-center"style="border-top:0px;border-bottom:0px;border-left:0px;"></th>
                        <th class="text-center" style="vertical-align: middle;">Units/<br> Heads</th>	
                        <th class="text-center" style="vertical-align: middle;">Members </th>	
                        <th class="text-center" style="vertical-align: middle;">Non-Members</th>	
                        
                    </tr>
                </thead>
                <tbody>
                        <tr >
                            <td colspan="1" style="border-top:0px;border-bottom:0px;border-left:0px;"><b>Post Harvest Facilities</b></td>
                            <td colspan="3" ></td>
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
                                <td style="border-top:0px;border-bottom:0px;border-left:0px;">&nbsp;&nbsp;&nbsp;&nbsp;'.$type_desc . '</td>
                                <td>'.$units_or_heads.'</td>
                                <td>'.$cs_member.'</td>
                                <td>'.$cs_non_member.'</td>
                            </tr>';
                    } else if($i < 7 ){
                        echo '<tr>
                                <td style="border-top:0px;border-bottom:0px;border-left:0px;">&nbsp;&nbsp;&nbsp;&nbsp;'.$serv_desc4[$i]. '</td>
                                <td>'.$units_or_heads.'</td>
                                <td>'.$cs_member.'</td>
                                <td>'.$cs_non_member.'</td>
                        </tr>';
                    } else {
                        echo '<tr>
                                <td style="border-top:0px;border-bottom:0px;border-left:0px;">&nbsp;&nbsp;&nbsp;&nbsp;'.$type_desc. '</td>
                                <td>'.$units_or_heads.'</td>
                                <td>'.$cs_member.'</td>
                                <td>'.$cs_non_member.'</td>
                            </tr>';
                    }
                    
                    $i++;
                    }

                    } else {
                        for($i = 0 ; $i < count($serv_id4) ; $i++) {
                            echo '<tr>
                                        <td style="border-top:0px;border-bottom:0px;border-left:0px;">&nbsp;&nbsp;&nbsp;&nbsp;'.$serv_desc4[$i]. '</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                </tr>';
                        }
                    }

                    $run_sql_srvcs_prov->close();
                    ?>

                </tbody>

                <tbody>
                        <tr >
                            <td colspan="1" style="border-top:0px;border-bottom:0px;border-left:0px;"><b>Other Projects</b></td>
                            <td colspan="3"></td>
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
                                <td style="border-top:0px;border-bottom:0px;border-left:0px;">
                                    &nbsp;&nbsp;&nbsp;&nbsp;'.$type_desc. '</td>
                                <td>'.$units_or_heads.'</td>
                                <td>'.$cs_member.'</td>
                                <td>'.$cs_non_member.'</td>
                            </tr>';
                    } else if($i < 6){
                        echo '<tr>
                                <td style="border-top:0px;border-bottom:0px;border-left:0px;">
                                    &nbsp;&nbsp;&nbsp;&nbsp;'.$serv_desc5[$i] . '</td>
                                <td>'.$units_or_heads.'</td>
                                <td>'.$cs_member.'</td>
                                <td>'.$cs_non_member.'</td>
                        </tr>';
                    } else {
                        echo '<tr>
                                <td style="border-top:0px;border-bottom:0px;border-left:0px;">
                                    &nbsp;&nbsp;&nbsp;&nbsp;'.$type_desc . '</td>
                                <td>'.$units_or_heads.'</td>
                                <td>'.$cs_member.'</td>
                                <td>'.$cs_non_member.'</td>
                        </tr>';
                    }
                    
                    $i++;
                    }

                    } else {
                        for($i = 0 ; $i < count($serv_id5) ; $i++) {
                            echo '<tr>
                                        <td style="border-top:0px;border-bottom:0px;border-left:0px;">
                                            &nbsp;&nbsp;&nbsp;&nbsp;'.$serv_desc5[$i]. '</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                </tr>';
                        }
                    }

                    $run_sql_srvcs_prov->close();
                    ?>
                </tbody>
            </table>

            <table class="table table-bordered"  style="background-color: white;float:left;">
                <thead class="bg-primary" >
                    <tr>
                        <th style="border-top:0px;border-bottom:0px;border-left:0px;"></th>
                        <th colspan="3" class="text-center" style="vertical-align: middle;">Clients Served</th>		
                    </tr>
                </thead>

                <thead class="bg-primary" >
                    <tr>
                        <th class="text-center" style="vertical-align: middle;border-top:0px;border-bottom:0px;border-left:0px;"></th>
                        <th class="text-center" style="vertical-align: middle;">Units/<br> Heads</th>	
                        <th class="text-center" style="vertical-align: middle;">Members </th>	
                        <th class="text-center" style="vertical-align: middle;">Non Members</th>	
                        
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td colspan="1" style="border-top:0px;border-bottom:0px;border-left:0px;"><b>Pre Harvest Facilities</b></td>
                        <td colspan="3"></td>
                    </tr>
                </tbody>

                <tbody class="pre_hrvst_fcl">
                    <?php
                    
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
                                    <td style="border-top:0px;border-bottom:0px;border-left:0px;">&nbsp;&nbsp;&nbsp;&nbsp;'.$type_desc.'</td>
                                    <td>'.$units_or_heads.'</td>
                                    <td>'.$cs_member.'</td>
                                    <td>'.$cs_non_member.'</td>
                                </tr>';
                        } else if($i < 3) {
                            echo '<tr>
                                    <td style="border-top:0px;border-bottom:0px;border-left:0px;">&nbsp;&nbsp;&nbsp;&nbsp;'.$serv_desc1[$i]. '</td>
                                    <td>'.$units_or_heads.'</td>
                                    <td>'.$cs_member.'</td>
                                    <td>'.$cs_non_member.'</td>
                            </tr>';
                        } else {
                            echo '<tr>
                                        <td style="border-top:0px;border-bottom:0px;border-left:0px;">&nbsp;&nbsp;&nbsp;&nbsp;'.$type_desc. '</td>
                                        <td>'.$units_or_heads.'</td>
                                        <td>'.$cs_member.'</td>
                                        <td>'.$cs_non_member.'</td>
                                </tr>';
                            
                        }
                        
                        $i++;
                    }

                    } else {
                        for($i = 0 ; $i < count($serv_id1) ; $i++) {
                            echo '<tr>
                                        <td style="border-top:0px;border-bottom:0px;border-left:0px;">&nbsp;&nbsp;&nbsp;&nbsp;'.$serv_desc1[$i]. '</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                </tr>';
                        }
                    }

                    $run_sql_srvcs_prov->close();
                    ?>
                </tbody>
                <tr>
                </tr>
                <tbody>
                    <tr >
                        <td colspan="1" style="border-top:0px;border-bottom:0px;border-left:0px;border-left:0px;"><b>Livestock</b></td>
                        <td colspan="3"></td>
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
                                <td style="border-top:0px;border-bottom:0px;border-left:0px;">&nbsp;&nbsp;&nbsp;&nbsp;'.$type_desc.'</td>
                                <td>'.$units_or_heads.'</td>
                                <td>'.$cs_member.'</td>
                                <td>'.$cs_non_member.'</td>
                            </tr>';
                    } else if($i < 4){
                        echo '<tr>
                                <td style="border-top:0px;border-bottom:0px;border-left:0px;">&nbsp;&nbsp;&nbsp;&nbsp;'.$serv_desc2[$i]. '</td>
                                <td>'.$units_or_heads.'</td>
                                <td>'.$cs_member.'</td>
                                <td>'.$cs_non_member.'</td>
                        </tr>';
                    } else {
                        echo '<tr>
                                <td style="border-top:0px;border-bottom:0px;border-left:0px;">&nbsp;&nbsp;&nbsp;&nbsp;'.$type_desc.'</td>
                                <td>'.$units_or_heads.'</td>
                                <td>'.$cs_member.'></td>
                                <td>'.$cs_non_member.'</td>
                            </tr>';
                    }
                    
                    $i++;
                    }

                    } else {
                        for($i = 0 ; $i < count($serv_id2) ; $i++) {
                            echo '<tr>
                                        <td style="border-top:0px;border-bottom:0px;border-left:0px;">&nbsp;&nbsp;&nbsp;&nbsp;'.$serv_desc2[$i]. '</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                </tr>';
                        }
                    }

                    $run_sql_srvcs_prov->close();
                    ?>
                </tbody>
                <tr></tr>
                <tbody>
                    <tr >
                        <td colspan="1" style="border-top:0px;border-bottom:0px;border-left:0px;"><b>Poultry / Broiler Raising</b></td>
                        <td colspan="3" ></td>
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
                                <td style="border-top:0px;border-bottom:0px;border-left:0px;">&nbsp;&nbsp;&nbsp;&nbsp;'.$type_desc.'</td>
                                <td>'.$units_or_heads.'</td>
                                <td>'.$cs_member.'</td>
                                <td>'.$cs_non_member.'</td>
                            </tr>';
                    } else if($i < 3){
                        echo '<tr>
                                <td style="border-top:0px;border-bottom:0px;border-left:0px;">&nbsp;&nbsp;&nbsp;&nbsp;'.$serv_desc3[$i].'</td>
                                <td>'.$units_or_heads.'</td>
                                <td>'.$cs_member.'</td>
                                <td>'.$cs_non_member.'</td>
                        </tr>';
                    } else {
                        echo '<tr>
                                <td style="border-top:0px;border-bottom:0px;border-left:0px;">&nbsp;&nbsp;&nbsp;&nbsp;'.$type_desc.'</td>
                                <td>'.$units_or_heads.'</td>
                                <td>'.$cs_member.'</td>
                                <td>'.$cs_non_member.'</td>
                        </tr>';
                    }
                    
                    $i++;
                    }

                    } else {
                        for($i = 0 ; $i < count($serv_id3) ; $i++) {
                            echo '<tr>
                                        <td style="border-top:0px;border-bottom:0px;border-left:0px;">&nbsp;&nbsp;&nbsp;&nbsp;'.$serv_desc3[$i]. '</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                </tr>';
                        }
                    }

                    $run_sql_srvcs_prov->close();
                    ?>
                </tbody>
                </table>
</div>
<table class="" style="width:750px;">
        
        <thead class="bg-success-custom">
            <tr>
            <tr>
                <td colspan="1" style="padding:0px;">MEMBERSHIP: </td>
            </tr>
            </tr>
        </thead>
            <thead>
                <tr>
                    <td style="width:120px;">ARB</td>
                    <td style="width:50px;">
                        <input disabled type="text" style="width:110px;" value="<?php echo $total_arb; ?>">
                    </td>
                    <td style="width:120px;">MALE</td>
                    <td style="width:50px;">
                        <input disabled type="text" style="width:110px;" value="<?php echo $arb_male; ?>">
                    </td>
                    <td style="width:120px;">FEMALE</td>
                    <td style="width:50px;">
                        <input disabled type="text" style="width:110px;" value="<?php echo $arb_female; ?>">
                    </td>
                </tr>
            </thead>

            <thead>
                <tr>
                    <td>NON-ARB</td>
                    <td style="width:50px;">
                        <input disabled type="text" style="width:110px;" value="<?php echo $total_non_arb; ?>">
                    </td>
                    <td>MALE</td>
                    <td style="width:50px;">
                        <input disabled type="text" style="width:110px;" value="<?php echo $non_arb_male; ?>">
                    </td>
                    <td>FEMALE</td>
                    <td style="width:50px;">
                        <input disabled type="text" style="width:110px;" value="<?php echo $non_arb_female; ?>">
                    </td>
                </tr>
            </thead>

            <thead>
                <tr>
                    <td>ARB-HH</td>
                    <td style="width:50px;">
                        <input disabled type="text" style="width:110px;" value="<?php echo $total_hh_arb; ?>">
                    </td>
                    <td>MALE</td>
                    <td style="width:50px;">
                        <input disabled type="text" style="width:110px;" value="<?php echo $male_hh_arb; ?>">
                    </td>
                    <td>FEMALE</td>  
                    <td style="width:50px;">
                        <input disabled type="text" style="width:110px;" value="<?php echo $female_hh_arb; ?>">
                    </td>

                </tr>
            </thead>

            <thead>
                <tr>
                    <td>TOTAL </td>
                    <td style="width:50px;">
                        <input disabled type="text" style="width:110px;" value="<?php echo $total_arb + $total_non_arb + $total_hh_arb; ?>">
                    </td>
                    <td>MALE</td>
                    <td style="width:50px;">
                        <input disabled type="text" style="width:110px;" value="<?php echo $arb_male  + $non_arb_male + $male_hh_arb; ?>">
                    </td>
                    <td>FEMALE</td>
                    <td style="width:50px;">
                        <input disabled type="text" style="width:110px;" value="<?php echo $arb_female + $non_arb_female + $female_hh_arb; ?>">
                    </td>
                </tr>
            </thead>
        </table> <br>
        <br><br>
        

        <br>
        <div class="pagebreak">
         
        </div>
        <?php
            $finance_ids = array(1,2,3,4,5);
            $sql_finance = $conn->prepare('SELECT amount ,no_of_savers from arbo_financial_status where arbo_financial_type_id = ? and arbo_profile_id = ?');
        ?><br>
                <table style="width:650px;">
                    <thead class="bg-success-custom">
                        <tr>
                            <td colspan="1" style="padding:0px;">
                            <b>FINANCIAL STATUS: </b></td>
                        </tr>
                    </thead>
                    <thead>
                        <tr>
                            <td></th>
                            <td rowspan="3" class="text-center" style="vertical-align: middle;text-center;">AMOUNT</td>
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
                                $cap_amount = $cap_amount > 0 ? $cap_amount : ''; 
                                $cap_savers = $cap_savers > 0 ? $cap_savers : ''; 
                                ?>
                                <td>Capital Build Up:</td>
                                <td><input type='text' disabled value="<?php echo $cap_amount?>" class='border-bottom' style='width:90%;'></td>
                                <td><input type='text' disabled value="<?php echo $cap_savers?>"  class='border-bottom' style='width:90%;'></td>
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
                                    $cap_amount = $cap_amount > 0 ? $cap_amount : ''; 
                                    $cap_savers = $cap_savers > 0 ? $cap_savers : ''; 
                                ?>
                                <td>Savings:</td>
                                <td><input type='text' disabled value="<?php echo $cap_amount?>" class='border-bottom' style='width:90%;'></td>
                                <td><input type='text' disabled value="<?php echo $cap_savers?>"  class='border-bottom' style='width:90%;'></td>
                                    
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
                                    $cap_amount = $cap_amount > 0 ? $cap_amount : ''; 
                                    $cap_savers = $cap_savers > 0 ? $cap_savers : ''; 
                                ?>
                                <td>Total Assets:</td>
                                <td><input type='text' disabled value="<?php echo $cap_amount?>" class='border-bottom' style='width:90%;'></td>
                                <td><input type='text' disabled value="<?php echo $cap_savers?>"  class='border-bottom' style='width:90%;'></td>
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
                                    $cap_amount = $cap_amount > 0 ? $cap_amount : ''; 
                                    $cap_savers = $cap_savers > 0 ? $cap_savers : ''; 
                                ?>
                                <td>Total Liabilities:</td>
                                <td><input type='text' disabled value="<?php echo $cap_amount?>" class='border-bottom' style='width:90%;'></td>
                                <td><input type='text' disabled value="<?php echo $cap_savers?>"  class='border-bottom' style='width:90%;'></td>
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
                                    $cap_amount = $cap_amount > 0 ? $cap_amount : ''; 
                                    $cap_savers = $cap_savers > 0 ? $cap_savers : ''; 
                                ?>
                                <td>Networth:</td>
                                <td><input type='text' disabled value="<?php echo $cap_amount?>" class='border-bottom' style='width:90%;'></td>
                                <td><input type='text' disabled value="<?php echo $cap_savers?>"  class='border-bottom' style='width:90%;'></td>
                            </tr>
                        </tbody>	
        
                    </table><br>
	
                    LOANS AVALIED IF ANY:  <br><br>
                    <table class="table table-bordered" >
                        <thead>
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
                            if(count($loan_id) > 0) {
                                for($i = 0 ; $i < count($loan_id); $i++) {
                                    if(empty($loan_amount[$i])) {
                                        echo '<tr id="rw2_'.$i.'">
                                        <td style="height:20px;"></td>
                                        <td>'.$loan_source[$i].'</td>
                                        <td>'.$loan_date_r[$i].'</td>
                                        <td>'.$loan_date_av[$i].'</td>
                                        <td>'.$loan_terms_pay[$i].'</td>
                                        <td>'.$loan_amount_pd[$i].'</td>
                                    </tr>';
                                    } else {
                                        echo '<tr id="rw2_'.$i.'">
                                        <td style="height:20px;">'.$loan_purpose_arr[$i].'</td>
                                        <td>'.$loan_amount[$i].'</td>
                                        <td>'.$loan_source[$i].'</td>
                                        <td>'.$loan_date_r[$i].'</td>
                                        <td>'.$loan_date_av[$i].'</td>
                                        <td>'.$loan_terms_pay[$i].'</td>
                                        <td>'.$loan_amount_pd[$i].'</td>
                                    </tr>';
                                    }
                            } if(count($loan_id) < 5) {
                                $i = count($loan_id);
                                while($i < 5) {
                                    echo '<tr>
                                            <td style="height:20px;"></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>';
                                $i++;
                                }
                            }
                            } else {
                                $i = 0;
                                while($i < 5) {
                                    echo '<tr>
                                            <td style="height:20px;"></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>';
                                $i++;
                                }
                            }  
                            ?>
                                    
                            </tbody>
                        </table><br>

        
                TRAININGS ATTENDED: 
                <table style="width:700px;">
                    </thead>
                        <thead>
                            <tr>
                                <th colspan="2"></th>
                                <th colspan="2"><center>No. of Pax</center></th>
                            </tr>
                            <tr>
                                <th colspan="1" class="text-center" style="vertical-align: middle;">Title of training: </th>
                                <th colspan="1" class="text-center" style="vertical-align: middle;">Date Conducted</th>
                                <th colspan="1" class="text-center" style="vertical-align: middle;">Officers</th>
                                <th colspan="1" class="text-center" style="vertical-align: middle;">Members</th>
                            </tr>

                        </thead>

                        <tbody>
                        <?php
                            $i = 0;
                            $trnings_attnd = 'SELECT id, title, date_conducted, no_of_pax_officers, no_of_pax_members
                            from arbo_org_trainings_attended prof WHERE arbo_profile_id = ?';
                            $run_trnings_attnd = $conn->prepare($trnings_attnd);
                            $run_trnings_attnd->bind_param('i',$org_id);
                            $run_trnings_attnd->execute();
                            $run_trnings_attnd->bind_result($trainings_att_id, $training_title,$date_conducted,$no_of_officer,$no_of_member);
                            $run_trnings_attnd->store_result();
                            $i=0;
                            if($run_trnings_attnd->num_rows() > 0) {
                                while($run_trnings_attnd->fetch()) {
                                    if($no_of_member == 0) {
                                        $no_of_member = '';
                                    }
                                    if($no_of_officer == 0) {
                                        $no_of_officer = '';
                                    }

                                    echo "<tr>
                                            <td><input disabled type='text' class='border-bottom' value='$training_title' style='width:380px;;font-size:11px;'></td>
                                            <td><input disabled type='text' class='border-bottom' value='$date_conducted' style='width:120px;margin-left:20px;font-size:11px;'></td>
                                            <td><input disabled type='text' class='border-bottom' value='$no_of_officer' style='width:100px;margin-left:10px;font-size:10px;'></td>
                                            <td><input disabled type='text' class='border-bottom' value='$no_of_member' style='width:100px;margin-left:10px;font-size:10px;'></td>
                                          </tr>";
                                $i++;
                                }
                                if($i < 9) {
                                    while($i < 9) {
                                        echo "<tr>
                                        <td><input disabled type='text' class='border-bottom' style='width:380px;'></td>
                                        <td><input disabled type='text' class='border-bottom' style='width:120px;margin-left:20px;'></td>
                                        <td><input disabled type='text' class='border-bottom' style='width:100px;margin-left:10px;font-size:10px;'></td>
                                        <td><input disabled type='text' class='border-bottom' style='width:100px;margin-left:10px;font-size:10px;'></td>
                                    </tr>";
                                    $i++;
                                    }
                                }
                            } else {
                                $i = 0;
                                while($i < 10) {
                                    echo "<tr>
                                            <td><input disabled type='text' class='border-bottom' style='width:380px;'></td>
                                            <td><input disabled type='text' class='border-bottom' style='width:120px;margin-left:20px;'></td>
                                            <td><input disabled type='text' class='border-bottom' style='width:100px;margin-left:10px;font-size:10px;'></td>
                                            <td><input disabled type='text' class='border-bottom' style='width:100px;margin-left:10px;font-size:10px;'></td>
                                        </tr>";
                                        $i++;
                                }
                            }
                            ?>
                        </tbody>
                    </table><br><br><br><br>
                    <b>(Please attached list of officers and members and note if acttve and inactive)</b>
                    <div class="pagebreak">
                    <b> LIST OF OFFICERS AND BOARD OF DIRECTORS</b>
                    <table class="table table-bordered" style="width:760px;">        
                        <thead>
                            <tr>
                                <th>NAMES</th>
                                <th>POSITION</th>
                            </tr>
                    </thead>
                        

                        <tbody>
                        <?php
                            $i = 0;
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
                                        $description = (empty($fullname)) ? $description : '';
                                        echo '<tr>
                                                <td style="height:20px;font-weight:lighter;">'.$fullname.'</td>
                                                <td>'.$description.'</td>
                                            </tr>';
                                            $i++;
                                    }
                                    if($i < 9) {
                                        while($i < 9) {
                                            echo '<tr>
                                                    <td style="height:20px;"></td>
                                                    <td></td>
                                                </tr>';
                                            $i++;
                                        }
                                    }
                                } else {
                                    for($i = 0 ; $i < 9 ; $i++) {
                                        echo '<tr>
                                                <td style="height:20px;"></td>
                                                <td></td>
                                            </tr>';
                                    }
                                }
                            $sql24->close();
                        ?>
                        </tbody>	
                    </table> <br>

                    <h3><b>LIST OF BOARD OF MEMBERS AND COMMITTESSAND MEMBERS</b></h3>
                    <!-- <thead> -->
                <!-- comm start -->
                <div class="table-responsive">
            <?php
                    $j = 0;
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
                                echo 'COMMITTEE : '.$committee[$i].'
                                <table class="table table-bordered" style="width:760px">
                                <thead>
                                    <tr>
                                        <th rowspan="3" class="text-center" style="vertical-align: middle;width:400px;">NAMES</th>
                                        <th rowspan="3" class="text-center" style="vertical-align: middle;">POSITION</th>
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
                                            $description = (!empty($fullname)) ? $description : '';
                                            echo '<tr>
                                                    <td style="height:20px;">'.$fullname.'</td>
                                                    <td>'.$description.'</td>
                                                  </tr>';
                                                  $j++;                                                                   
                                            }
                                            
                                        }
                                        if($j < 3) {
                                            while($j < 3) {
                                                echo '<tr>
                                                            <td style="height:20px;"></td>
                                                            <td></td>
                                                        </tr>';     
                                                        $j++;                                                                  
                                                    }
                                            }
                                        } else {
                                            echo "<tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                <tr>";
                                        }
                                        echo '</tbody></table><br>';
                                        $j = 0;
                                    }
                    ?>

</div>
<script>
    (function() {
        window.print();
    })();
</script>
</body>
</html>
<?php } else {
    header('Location:../index.php');
}?>