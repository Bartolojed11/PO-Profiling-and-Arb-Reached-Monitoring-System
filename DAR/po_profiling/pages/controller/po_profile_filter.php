<?php
require 'connection.php';
$trainings = isset($_POST['trainings']) ? $_POST['trainings'] : 1;
$asset_amount = isset($_POST['asset_amount']) ? $_POST['asset_amount'] : 0;
$asset_operator = isset($_POST['asset_operator']) ? $_POST['asset_operator'] : 'All';
$loan = isset($_POST['loan']) ? $_POST['loan'] : 1;

echo '<table id="example1" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th class="text-center" style="width:370px;">ARB ORGANIZATION NAME</th>
            <th class="text-center" style="width:370px;">ORGANIZATION ADDRESS</th>
            <th class="text-center" style="width:180px;">TOTAL ASSET</th>
            <th class="text-center" style="width:70px;">LOAN</th>
            <th></th>
        </tr>
    </thead>

    <tbody id="tbl-org-list">';

    $train_cond = '';
    $asset_ope = '';
    $loan_cond = '';
    $logical_cond = array('>','<','=','>=','<=');

    if($loan == 1) {
        $loan_cond = "((SELECT COUNT(*) FROM arbo_loans_availed WHERE purpose_of_loan != '' and arbo_profile_id = arbo_prof.id) >= 0)";
    } else if($loan == 2) {
        $loan_cond = "((SELECT COUNT(*) FROM arbo_loans_availed WHERE purpose_of_loan != '' and arbo_profile_id = arbo_prof.id) > 0)";
    } else if($loan == 0) {
        $loan_cond = "((SELECT COUNT(*) FROM arbo_loans_availed WHERE purpose_of_loan != '' and arbo_profile_id = arbo_prof.id) < 1)";
    }

    if($trainings == 1) {
        $train_cond = "((SELECT COUNT(*) FROM arbo_org_trainings_attended WHERE title != '' and arbo_profile_id = arbo_prof.id) >= 0)";
    } else if ($trainings == 2) {
        $train_cond = "((SELECT COUNT(*) FROM arbo_org_trainings_attended WHERE title != '' and arbo_profile_id = arbo_prof.id) > 0)";
    } else if ($trainings == 0) {
        $train_cond = "((SELECT COUNT(*) FROM arbo_org_trainings_attended WHERE title != '' and arbo_profile_id = arbo_prof.id) < 1)";
    }

    if(!in_array($asset_operator,$logical_cond)){
        if($asset_operator == 'All') {
            $asset_operator = '>=';
        } else {
            $asset_operator = '>=';
        }
    }

    if($asset_operator == '>=' && $asset_amount == 0 && $trainings == 1 && $loan == 1) {
        $sql = "SELECT arbo_prof.id ,arbo_prof.name, arbo_prof.ARBO_PROVINCE, arbo_prof.ARBO_CITY,
        arbo_prof.ARBO_BRGY, arbo_prof.ARBO_ADDR_OTHERS, fin_stat.amount, arbo_loan.purpose_of_loan
        from arbo_profile as arbo_prof
        left join arbo_org_trainings_attended as arbo_train
        on arbo_prof.id = arbo_train.arbo_profile_id
        left join arbo_loans_availed as arbo_loan on arbo_prof.id = arbo_loan.arbo_profile_id  
        left join arbo_financial_status as fin_stat on arbo_prof.id = fin_stat.arbo_profile_id
        GROUP BY arbo_prof.id ORDER BY arbo_prof.date_updated DESC, arbo_prof.date_created  DESC";
        $sql_show_arbo = $conn->prepare($sql);
        $sql_show_arbo->execute();

    }   else {
        $sql = "SELECT arbo_prof.id ,arbo_prof.name, arbo_prof.ARBO_PROVINCE, arbo_prof.ARBO_CITY, arbo_prof.ARBO_BRGY, arbo_prof.ARBO_ADDR_OTHERS,
        fin_stat.amount, arbo_loan.purpose_of_loan
        from arbo_profile as arbo_prof
        left join arbo_org_trainings_attended as arbo_train
        on arbo_prof.id = arbo_train.arbo_profile_id
        left join arbo_loans_availed as arbo_loan on arbo_loan.arbo_profile_id = arbo_prof.id
        left join arbo_financial_status as fin_stat on fin_stat.arbo_profile_id = arbo_prof.id
        WHERE $train_cond AND $loan_cond AND (fin_stat.amount $asset_operator ? and fin_stat.arbo_financial_type_id = 3)
        GROUP BY arbo_prof.id ORDER BY arbo_prof.date_updated DESC, arbo_prof.date_created  DESC";
        $sql_show_arbo = $conn->prepare($sql);
        $sql_show_arbo->bind_param('s',$asset_amount);
        $sql_show_arbo->execute();
    }

$sql_show_arbo->bind_result($id, $arbo_name, $prov, $city, $brgy, $others,$ttal_asset, $loan_am);
$sql_show_arbo->store_result();

if ($sql_show_arbo->num_rows() > 0) {
    while ($sql_show_arbo->fetch()) {
            $address = $others . ' ' . $brgy . ' ' . $city . ' ' . $prov ;
            $loan_am = !empty($loan_am) ? '<span class="text-success fa fa-check"></span>' : '';
            echo '
            <tr>
            <td>' . htmlspecialchars($arbo_name) . '</td>
            <td>' .  htmlspecialchars($address) . '</td>
            <td  class="text-center">' .  htmlspecialchars($ttal_asset) . '</td>
            <td class="text-center">' .  $loan_am . '</td>
            <td class="text-center"><a href="po_profile.php?id=' . $id . '" ><button class="fa fa-eye btn btn-default btn-sm"></button></a>
            <a href="po_profile_update.php?id=' . $id . '" ><button class="fa fa-edit btn btn-info btn-sm"></button></a>
            <a href="print.php?id=' . $id . '" target="blank"><button class="fa fa-print btn btn-sm btn-primary" data-toggle="tooltip" title="Print Po Profile!"></button>
            <a href="print_assoc_mem.php?id=' . $id . '" target="blank"><button class="fa fa-print btn btn-sm btn-success" data-toggle="tooltip" title="Print Po Members"></button>
            </td>
            </tr>';
        }
}
echo '    </tbody>
</table>';
?>