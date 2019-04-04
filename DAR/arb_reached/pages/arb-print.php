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
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<link rel="stylesheet" href="../../../admin_template/bower_components/font-awesome/css/font-awesome.min.css">
    <head>
        <style>
            #custom-filter select {
                border:0px;
                border-bottom:1px solid gray;
                outline:none;
                padding-top:5px;
                padding-bottom:2.9px;
            }
            
            input[type="text"] , input[type="number"], input[type="date"] {
                border:0px;
                border-bottom:1px solid gray;
            }
            
            .select_brdr_btm {
                background-color:black;
                border:0px;
                border-bottom:1px solid gray;
            }
            
            input[type="checkbox"] {
                border-color:#00a65a;
            }
            
            :disabled{
                background-color:rgba(255,255,255,.2);
            }
            body {
                font-family: tahoma;
            }
            .main-content {
                font-size: 13px;
            }
            .header {
                font-size:15px;
            }
            .page-break{
                page-break-before:always;
            }
            .text-center {
                text-align:center;
            }
            .font-control{
                font-size:12px;
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
table {
    border-collapse: collapse;
    border-spacing: 0;
}
table {
    display: table;
    border-collapse: separate;
    border-spacing: 0px;
    border-color: grey;
}
/* .table>caption+thead>tr:first-child>td, .table>caption+thead>tr:first-child>th, .table>colgroup+thead>tr:first-child>td, .table>colgroup+thead>tr:first-child>th, .table>thead:first-child>tr:first-child>td, .table>thead:first-child>tr:first-child>th {
    border-top: 0;
} */
.pagebreak { page-break-before: always; }
        </style>
        
        <link href="../public/img/logo.png" rel="icon" type="image">
        <title>ARB REACHED | Print</title>
    </head>
    <body>
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

                $sql = 'SELECT arbo.arbo_name, arbo.status , arbo.position
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

                
            ?>
            <div class="header">
                <center><b>DEPARTMENT OF AGRARIAN REFORM</b> <br>
                <b>PROGRAM BENEFICIARIES DEVELOPMENT DIVISION</b> <br>
                Agrarian Reform Beneficiaries Development Sustainability Program (ARBDSP) <br>
                <h4><b>ARB REACHED</b></h4>
                </center>
            </div>
            <br>
            <section class="main-content">
            <div>            
                <label for="arb_lname">Municipality: </label>
                <input style="width:200px;" type="text" disabled class="form-control" name="city" value="<?php echo htmlspecialchars($get_city); ?>" id="city"  >
            </div>

            <div class="">
                <label for="arb_lname">Barangay: </label>
                    <input style="width:215px;" type="text" disabled class="form-control" name="city" value="<?php echo htmlspecialchars($brgy); ?>" id="city"  >
            </div>
            <div class="col-lg-12"><br>
                <b>PART I : ARB Information</b> <br>
            </div>
            <div>

            <div>
                NAME OF ARB: 
                <input type="text" style="width:115px;" disabled class="form-control text-center" value="<?php echo htmlspecialchars($arb_lname) ; ?>"  name="arb_lname" id="arb_fname"  >
                <input type="text" style="width:115px;" disabled class="form-control text-center" value="<?php echo htmlspecialchars($arb_fname) ; ?>" name="arb_fname" id="arb_fname"  >
                <input type="text" style="width:115px;" disabled class="form-control text-center" value="<?php echo htmlspecialchars($arb_mi) ; ?>" name="arb_mi" id="arb_mi"  >
                <label  style="margin-left:10px;" for="gender">Sex: </label><input type="text" disabled class="form-control text-center" value="<?php echo $arb_gender = htmlspecialchars($arb_gender) == 'F' ? 'Female' : 'Male' ; ?>" name="gender" id="gender"  >
                <br>
                <span class="font-control" style="margin-left:120px;" for="arb_lname">(Last Name)</span>
                <span class="font-control" style="margin-left:45px;" for="arb_fname">(First Name)</span>
                <span class="font-control" style="margin-left:72px;" for="arbo_barangay">(MI)</span>
            </div>

            <div class="">
                    <label for="civil_status">Civil Status: </label>
                    <input type="text" disabled class="form-control" value="<?php echo htmlspecialchars($civil_status) ; ?>" name="civil_status" id="civil_status"  >
                    &nbsp;
                    <label for="arbo_barangay">Birthdate: </label>
                    <input type="text" disabled class="form-control" value="<?php echo $arb_bdate ; ?>" name="arb_bdate" id="arb_bdate"  >
                    &nbsp;
                    <label for="arbo_barangay">Age : </label>
                    <input style="width:140px;" type="text" disabled class="form-control" name="age" id="age">
            </div>

            <div class="">
                    NAME OF SPOUSE :
                <input type="text" style="width:115px;" disabled class="form-control text-center" value="<?php echo htmlspecialchars($spouse_lname) ; ?>"  name="spouse_lname" id="spouse_lname"  >
                <input type="text" style="width:115px;" disabled class="form-control text-center" value="<?php echo htmlspecialchars($spouse_fname) ; ?>" name="spouse_fname" id="spouse_fname"  >
                <input type="text" style="width:115px;" disabled class="form-control text-center" value="<?php echo htmlspecialchars($spouse_mi) ; ?>" name="spouse_mi" id="spouse_mi"  >
                
                <br>
                <span class="font-control" style="margin-left:136px;">(Last Name)</span>
                <span class="font-control" style="margin-left:60px;">(First Name)</span>
                <span class="font-control" style="margin-left:65px;">(MI)</span>
            </div>
            
            <div class="">
                    <label for="arb_cloa">Cloa No. : </label>
                    <input type="text" disabled class="form-control" value="<?php echo htmlspecialchars($arb_cloa) ; ?>" name="arb_cloa" id="arb_cloa"  >

                    <label for="arb_landsize">Landsize(ha) : </label>
                    <input type="text" disabled class="form-control"  value="<?php echo htmlspecialchars($arb_landsize) ; ?>"
                        name="arb_landsize" id="arb_landsize"  >
            </div>

            <div class="col-lg-12"><br>
            
            <b>PART II : Membership to Agrarian Reform Beneficiaries Orgnization (ARBOs)</b> <br><br>
            </div> 
            <div class="form-group col-lg-12 col-sm-12">
                <label for="arbo_barangay">Name of ARBO: </label>
                <input style="width:560px;margin-left:30px;" type="text" disabled class="form-control" value="<?php echo htmlspecialchars($arbo) ; ?>" name="arb_arbo" id="arb_laarb_arbondsize">
                <br>(PLease Provide CORRECT Name of ARBO with ACRONYM (IF APPLICABLE) )
            </div>
            <div class="form-group col-lg-4 col-sm-4">
                    <label for="arb_position">Position</label>
                    <input type="text" disabled class="form-control" value="<?php echo htmlspecialchars($arb_position) ; ?>" name="arb_position" id="arb_position" >
                    &nbsp;
                    <label for="date_of_mem">Date of Mem : </label>
                    <input style="width:110px;" type="text" disabled class="form-control" value="<?php echo $date_of_mem ; ?>" name="date_of_mem" id="date_of_mem"  >
                    &nbsp;
                    <label for="status">Status(Active/Inactive):&nbsp;&nbsp;</label>
                    <input style="width:120px;" type="text" disabled class="form-control" value="<?php echo htmlspecialchars($status) ; ?>" name="status" id="status"  >
            </div>
            
            <div class="form-group col-lg-12 col-sm-12"><br>
            <b>Other Organization(<?php echo count($other_org) ; ?>) </b>
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
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <label for='status'>STATUS</label>
                                    <input type='text' disabled class='form-control' value='$other_stat_'>
                            </div>
                            <div class='form-group col-lg-12' style='margin-top:-10px;margin-bottom:-10px;'><br><br></div>";
                    }        
                    echo "</div>";
                }
            ?>


                </div>

            </div>


                    <!-- PAGE II -->

                    <!-- PAGE III -->
                    
        <b>PART III : Trainings Attended</b> <br><br>
            <table class="table table-bordered" style="width:640px;"> 
                <thead>
                    <tr>
                        <th style="width:4%;"></th>
                        <th style="width:86%;" class="text-center">A. For Coops / Non-Cops Trainings</th>
                        <th style="width:10%;" class="text-center">Attended(/)</th>
                    </tr>
                </thead>
                <tbody>
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
                                    <td class='text-center $id'>
                                    <center>
                                        <span class='fa fa-check'></span>
                                    </center>
                                    </td>
                                    </tr>";
                        }
                    } else {
                        echo "<tr>
                                <td colspan='12' class='text-center' style='color:gray;'> < Empty ></td>
                                </tr>";
                    }
                ?>
                </tbody>
            </table><br>


        <div>
            <b>PART IV : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Support Services Availed</b><br><br>
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
        <div>
        <table class="" style="width:640px;">
            <thead>
                <tr style="padding:2px;">
                    <th style="width:160px;text-align:left;">1. Credit</th>
                    <th style="width:320px;" class="text-center">Name Of Institution</th>
                    <th>Amount</th>
                </tr>
            </thead>
        <tbody>
                <tr>
                    <td>a. Production</td>
                    <td><input type="text" class="form-control" style="width:300px;" disabled name="arb_name_prod" value="<?php echo htmlspecialchars($instite) ; ?>" id="arb_name_prod"></td>
                    <td><input type="text" class="form-control text-center" disabled name="arb_prod_amount" value="<?php echo htmlspecialchars($amount) ; ?>" id="arb_prod_amount"  ></td>
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
                    <td><input type="text" class="form-control"  style="width:300px;" disabled value="<?php echo htmlspecialchars($instite) ; ?>" name="arb_name_micro" id="arb_name_micro"  ></td>
                    <td><input type="text" class="form-control text-center" disabled value="<?php echo htmlspecialchars($amount) ; ?>" name="arb_micro_amount" id="arb_micro_amount"  ></td>
                </tr>
                <?php
                    $sql->bind_param('is', $arb_id, $ssa[2]);
                    $sql->execute();
                    $sql->bind_result($instite,$amount);
                    $sql->store_result();
                    $sql->fetch();
                ?>
                <tr>
                    <td>c. Livelihood</td>
                    <td><input type="text" class="form-control" style="width:300px;" disabled value="<?php echo htmlspecialchars($instite) ; ?>" name="arb_name_lhood" id="arb_name_lhood"  ></td>
                    <td><input type="text" class="form-control text-center" disabled value="<?php echo htmlspecialchars($amount) ; ?>" name="arb_lhood_amount" id="arb_lhood_amount"  ></td>
                </tr>
        </tbody>
        </table> <br><br>
        </div>
        </div>
</div>
</div>
                                    
        <table class="table table-bordered pagebreak main-content" style="width:650px;">
        <thead>
            <tr>
                <th class="text-center" style="font-size:13px;"> 2. Is your organization a beneficiary of [mention program]?</th>
                <th style="width:10px;font-size:13px;">Availed(/)</th>
            </tr>
        </thead>
            <tbody>
            

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
                        <td colspan="12" class="text-center main-content" id="79"><strong>Agrarian Reform Community Connectivity and Economic Support Services</strong></td>
                    </tr>';
                while ($sql_qid->fetch()) {
                    $i++;
                    echo '<tr>
                            <td class="'.$id.'">' . $description . '</td>
                            <td class="'.$id.'"><span class="fa fa-check"></span></td>
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
                            <td colspan="3"  class="text-center main-content" id="95"><strong>Partnership Development Projects</strong></td>
                        </tr>';
                    while ($sql_qid->fetch()) {
                        $i++;
                        echo '<tr>
                                <td class="'.$id.'">' . $description . '</td>
                                <td class="'.$id.'"><span class="fa fa-check"></td>
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
                            <td colspan="3"  class="text-center main-content" id="96"><strong> Foreign Assisted Projects</strong></td>
                        </tr>';
                    while ($sql_qid->fetch()) {
                        $i++;
                        echo '<tr>
                            <td class="'.$id.'">' . $description . '</td>
                            <td class="'.$id.'"><span class="fa fa-check"></td>
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
                        <td colspan="3" class="text-center main-content" id="97"><strong> Microfinance and Credit Programs</strong></td>
                    </tr>';
                while ($sql_qid->fetch()) {
                    $i++;
                    echo '<tr>
                        <td class="'.$id.'">' . $description . '</td>
                        <td class="'.$id.'"><span class="fa fa-check"></td>
                        </tr>';
                }
            }
            ?>
                </tbody>
            </table>
            <table class="table table-bordered main-content" style="width:650px;">
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
                            <td colspan="12" class="text-center" id="98"><strong> Partner Agencies: </strong></td>
                        </tr>';
                    while ($sql_qid->fetch()) {
                        $i++;
                        echo '<tr>
                            <td class="'.$id.'">' . $description .'
                            <input disabled style="background-color:rgba(255, 255, 255, .0);" class="select_brdr_btm" type="text" id="' . $id . '"
                                value="'.$spec_intervene.'"  disabled name="q98_spec[]"/>
                            </td>
                            <td class="'.$id.'"><span class="fa fa-check"></td>
                            
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
        
        <br><br><br><br>
        </div>
        <div class="col-lg-6">
            <div class="row">
                <div class="col-lg-6 pull-left">
                    <label for="attestedby">Attested By: </label>
                    <input type="text" disabled class="form-control text-center" name="attestedby" id="attestedby" value="<?php echo htmlspecialchars($attestedby); ?>" >
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="row">
                    <div class="col-lg-6 pull-right">
                        <label for="interviewedby">Interviewed By: </label>
                        <input type="text" disabled class="form-control text-center" value="<?php echo htmlspecialchars($interviewedby); ?>" name="interviewedby" id="interviewedby"  ><br><br>
                    </div>
                </div>
        </div>
        </section>
    <script>
        (function() {
            window.print();
        })();
    </script>
    </body>
</html>
<?php } else {
    header('location:../index.php');
}?>