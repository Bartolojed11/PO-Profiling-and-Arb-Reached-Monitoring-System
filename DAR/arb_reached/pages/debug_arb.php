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
            .select_brdr_btm: {
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
            .addbgcolor {
                background-color:rgba(212, 204, 204, .5);
                font-weight:bold;
            }
            : {
                background-color:rgba(255,255,255,.2);
            }
            .user-panel {
                background-image:url('../public/img/dar-bg.png');
                height:100px;
            }
            /* input[type="checkbox"] {
                height:10px;
                width:10px;
            } */
            .checked_ {
                outline:inset;
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
                    <h1>ARB REACHED</h1>
                    <ol class="breadcrumb" id="arb_page">
                    </ol>
                </section>
                <section class="content">
<?php $arb_id = 65; ?>


                    <!-- PAGE II -->

                    <!-- PAGE III -->

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-next">
                                <div class="box box-success" style="width:97.5%;margin-left:1.2%;margin-right:1.2%;">

                                    <!-- PAGE I -->


                                    <!-- content -->
                                    <div class="box-header with-border text-center">
                                        <h4><b>ARB REACHED</b></h4>
                                    </div>
                                    <br>
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
                                                                            <td class="'.$q79_id[$j].' addbgcolor">' . $q79_desc[$i] .   $arbo_inter_qid[$j] . '</td>
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
                                                        <td colspan="3"style="background-color:rgb(189, 255, 189);" class="text-center" id="96"><strong> Foreign Assisted Projects</strong></td>
                                                    </tr>
                                                    <?php
                                                    $i = 0;
                                                    $j = 0;
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
                                                        if(count($arbo_inter_qid) > 0) { //acquired
                                                            for($j = 0 ; $j < count($arbo_inter_qid) ; $j++) {
                                                                if($q96_id[$i] == $arbo_inter_qid[$j]) {
                                                                    $flag++;
                                                                    echo '<tr class="part5_cl">
                                                                            <td class="'.$q96_id[$i].' addbgcolor ">' . ($i+1) . '</td>
                                                                            <td class="'.$q96_id[$i].' addbgcolor ">' . $q96_desc[$i] .   $arbo_inter_qid[$i] . '</td>
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
                                                    $j = 0;
                                                    $i = 0;
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
                                                                            <td class="'.$q97_id[$j].' addbgcolor ">' . ($i+1) . '</td>
                                                                            <td class="'.$q97_id[$j].' addbgcolor ">' . $q97_desc[$i] .   $arbo_inter_qid[$j] . '</td>
                                                                            <td class="'.$q97_id[$j].' addbgcolor ">
                                                                            <input type="checkbox" checked  class="checked_cl_p5" value="'.$q97_id[$j].'" onclick="addbg(this.value,0)" name="q97[]"/></td> 
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

        </div>
        <?php
        include 'inc/footer.php';
        include 'inc/js.php' ;
        ?>
        <script src="../public/js/arb_js.js"></script>
        <script>
        var p1 = p2 = p3 = p4 = p5 = p6 = undefined;
        var ps_fl = undefined;
        var train_count = 0;
        var p5_count = 0;
            $('.trainings_cl input[type="checkbox"]').click(function() {
                $(this).toggleClass('checked_cl');
                    train_count = $('.trainings_cl').find('.checked_cl').length;
                    console.log(train_count);
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
                ps_fl = 0;
                console.log(`p5${p5_count}`);
                p1 = $('#p4_1').val();
                p2 = $('#p4_2').val();
                p3 = $('#p4_3').val();
                p4 = $('#p4_4').val();
                p5 = $('#p4_5').val();
                p6 = $('#p4_6').val();
                if((p1 != '' || p2 != '') || (p3 != '' || p4 != '') || (p5 != '' || p6 != '')) {
                    ps_fl = 1;
                }
                if((train_count > 0 || ps_fl == 1) || (p5_count > 0))  {
                    $('#save').removeAttr('disabled');
                } else {
                    $('#save').attr('disabled','disabled');
                }
            }
</script>

    </body>
</html>
<?php } else {
        header('location:../index.php');
}?>