<?php
if (!isset($_SESSION['username'])) {
    session_start();
}
require 'controller/connection.php';
require 'controller/user_functions.php';
$_COOKIE['username'] = isset($_COOKIE['username']) ? $_COOKIE['username'] : '';
$_COOKIE['ssid'] = isset($_COOKIE['ssid']) ? $_COOKIE['ssid'] : '';
    if(authUser($_COOKIE['username'],$_COOKIE['ssid'], $conn)) {
        $user = $_COOKIE['username'] ;
        $org_id = isset($_GET['id']) ? $_GET['id'] : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../bower_components/font-awesome/css/font-awesome.min.css">
    <style>
        body{
            font-family:sans-serif;   
        }
        table th {
            border-bottom:1px solid gray;
            border-right:1px solid gray;
        }
        table td {
            border-bottom:1px solid gray;
            border-right:1px solid gray;
            
        }
        table {
            border-left:1px solid gray;
            border-top:1px solid gray;
        }
        .association_members th {
            vertical-align: bottom;
            text-align: center;
        }
        /* .association_members th span 
            {
            -ms-writing-mode: tb-rl;
            -webkit-writing-mode: vertical-rl;
            writing-mode: vertical-rl;
            transform: rotate(180deg);
            white-space: nowrap;
            }
        .association_members {
            vertical-align: bottom;
            text-align: center;
            -ms-writing-mode: tb-rl;
            -webkit-writing-mode: vertical-rl;
            writing-mode: vertical-rl;
            transform: rotate(180deg);
            white-space: nowrap;
        } */
        small {
            font-weight:bold;
        }
        .association_members{
            font-size:10px;
        }
        .page-break{
            page-break-before:always;
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
    padding: 1px;
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
.text-lgt {
    font-weight:lighter;
}
    </style>
</head>
<body>


<?php
$checked = '<span class="fa fa-check"></span>';
$table_with_break = "<table class='table table-bordered associate_tbl page-break' id='assoc_members_list'>";
$table_wo_break = "<table class='table table-bordered  associate_tbl' id='assoc_members_list'>";
$table = "<thead>
            <tr class='text-align:bottom;'>
                <td><small class='text-lgt'><span>NAMES</span></small></td>
                <td><small class='text-lgt'></small></td>
                <td style='width:15px;'><small class='text-lgt'><span>M/<br>F</span></small></td>
                <td><small class='text-lgt'><span>ARB/<br>N-ARB</span></small></td>
                <td><small class='text-lgt'><span>Active/</span></small></td>
                <td colspan='2'><small class='text-lgt'><span>Contributions</span></small></td>
                <td colspan='7'><span><small class='text-lgt'><center>Coop Programs/Services Availed</center></small></span></td>
                <td colspan='4'><small class='text-lgt'><span><center>Trainings Attended</center></span></small></td>
            </tr>
            </thead>
            <thead style='white-space: nowrap'>
            <tr>
                <td><small class='text-lgt'><span></i> (Last name, First Name, MI)</span></small></td>
                <td><small class='text-lgt'><span>POSITION</span></small></td>
                <td style='width:15px;'><small><span>F</span></small></td>
                <td><small class='text-lgt'><span>H-ARB</span></small></td>
                <td><small class='text-lgt'><span>Inactive</span></small></td>
                <td><small class='text-lgt'><span>CBU</span></small></td>
                <td><small class='text-lgt'><span>M.DUE</span></small></td>

                <td><small class='text-lgt'><span>Production</span></small></td>
                <td><small class='text-lgt'><span>Marketing</span></small></td>
                <td><small class='text-lgt'><span>Credit</span></small></td>
                <td><small class='text-lgt'><span>PHF</span></small></td>
                <td><small class='text-lgt'><span>MicroEnt.</span></small></td>
                <td><small class='text-lgt'><span>Service</span></small></td>
                <td><small class='text-lgt'><span>Others</span></small></td>
                <td colspan='4'></td>
                
            </tr>
            </thead>";
$flag_print = 0;
$i = 0;
$sql_show_members = "SELECT distinct(mem.hhold_id),
concat_ws(' ' , mem.fn_arb, mem.mn_arb, mem.ln_arb) as fullname,
pos_type.description, asc_mem.sex, asc_mem.arbo_arb_type_id, asc_mem.arbo_status_id, asc_mem.cloa_no,asc_mem.land_size,
asc_mem.assoc_crop, asc_mem.cbu, asc_mem.monthly_due, 
asc_mem.production ,asc_mem.marketing, asc_mem.credit, asc_mem.phf, asc_mem.micro_ent ,asc_mem.service,
asc_mem.others, asc_mem.trainings_attended
FROM arbo_position_type as pos_type inner join 
arbo_association_members as asc_mem 
on pos_type.id = asc_mem.arbo_position_type_id
inner join part1_arb_household as mem
on mem.hhold_id = asc_mem.arbo_mem_id
where ARBO_PROFILE_ID = ? and pos_type.id = asc_mem.arbo_position_type_id GROUP BY mem.hhold_id";
$run_sql_show_members = $conn->prepare($sql_show_members);
$run_sql_show_members->bind_param('i' , $org_id);
$run_sql_show_members->execute();
$run_sql_show_members->bind_result($id, $fullname,
    $arbo_position_type, $sex, $arbo_arb_type_id, $arbo_status_id, $cloa_no,$landsize ,$crops, $cbu,
    $savings, $production ,$marketing, $credit, $phf, $micro_ent ,$service, $others, $trainings_attended);
$run_sql_show_members->store_result();
$print_flag = 0;
if($run_sql_show_members->num_rows()) {
    echo '<div class="association_members" style="">
            <h4>COOPERATIVE MEMBERS</h4>';
while($run_sql_show_members->fetch()) {
    if($i % 20 == 0 && $i > 0) {
        echo $table_with_break;
        echo $table;
        $print_flag = $i;
    } else {
        if($i == ($flag_print - 1)) {
            echo $table_with_break;
            echo $table;
        } else if($flag_print == 0 && $i == 0){
            echo $table_wo_break;
            echo $table;
        }
    }
    
    $others = $others > 0 ? $others : '';
    
        echo '<tbody id="assoc_tbl"><tr>
            <td>
                <input type="hidden"  disabled  class="check_inp" value="'.$id.'" name="assoc_mem_id[]">
                '.$fullname.'
            </td>
            
            <td>
                '.$arbo_position_type.'
            </td>
            ';
            if($sex == 1) {
                echo '<td>M</td>';
            } else {
                echo '<td>F</td>';
            }
            if($arbo_arb_type_id == 1){
                echo '<td>ARB</td>';
                
            } else {
                echo '<td>NON-ARB</td>';
                
            }
            if($arbo_status_id == 1) {
                echo '<td>Active</td>';
            } else {
                echo '<td>
                    Inactive
                </td>';
            }
            
            if($cbu == 1) {
                echo "<td>$checked</td>";
            } else {
                echo '<td>
                        <input type="hidden" name="assoc_cbu[]"    id="assoc_cbu" value="1">
                    </td>';
            }
            if($savings == 1 || $savings != 0) {
                echo "<td>$checked</td>";
            } else {
                echo '<td>
                        <input type="hidden" name="assoc_savings[]"    id="assoc_savings" value="0">
                    </td>';
            }
            if($production == 1) {
                echo "<td>$checked</td>";
            } else {
                echo '<td>
                        <input type="hidden" name="assoc_production[]"   id="assoc_production" value="0">
                    </td>';
            }
            if($marketing == 1) {
                echo "<td>$checked</td>";
            } else {
                echo '<td>
                    <input type="hidden" name="assoc_mrktng[]"    id="assoc_mrktng" value="1">
                </td>';
            }
            if($credit == 1) {
                echo "<td>$checked</td>";
            } else {
                echo '<td>
                    <input type="hidden" disabled name="assoc_credit[]"   id="assoc_credit" value="0">
                </td>';
            }
            if($phf) {
                echo "<td>$checked</td>";
            } else {
                echo '<td>
                        <input type="hidden" disabled name="assoc_phf[]" id="assoc_phf" value="0">
                    </td>';
            }
            if($micro_ent == 1) {
                echo "<td>$checked</td>";
            } else {
                echo '<td>
                        <input type="hidden" name="assoc_micro[]"   id="assoc_micro" value="0">
                    </td>';
            }
            if($service==1){
                echo "<td>$checked</td>";
            } else {
                echo '<td>
                    <input type="hidden" name="assoc_srvce[]"   id="assoc_srvce" value="0">
                </td>';
            }
            
            if($others == 1) {
                echo "<td>$checked</td>";
            } else {
                echo "<td></td>";
            }
            
            $traing_att = explode(">" , $trainings_attended );
            $traing_att0 = isset($traing_att[0]) ? trim($traing_att[0]) : '';
            $traing_att1 = isset($traing_att[1]) ? trim($traing_att[1]) : '';
            $traing_att2 = isset($traing_att[2]) ? trim($traing_att[2]) : '';
            $traing_att3 = isset($traing_att[3]) ? trim($traing_att[3]) : '';
            echo '<td style="min-width:30px;font-size:8px;max-width:50px;">'.$traing_att0.'</td>
                    <td style="min-width:30px;">'.$traing_att1.'</td>
                    <td style="min-width:30px;">'.$traing_att2.'</td>
                    <td style="min-width:30px;">'.$traing_att3.'</td>
                </tr>
                ';
                $i++;
        }
    } else {
        include_once 'print_mem_form.php';
    }
    ?>
</tbody>
    </table>

    <div>
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