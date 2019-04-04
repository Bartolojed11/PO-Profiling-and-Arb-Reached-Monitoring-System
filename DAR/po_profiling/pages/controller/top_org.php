<?php
    require 'connection.php';
    $org_type = isset($_POST['org_type']) ? $_POST['org_type'] : 1;
    $sort = isset($_POST['org_filter']) ? $_POST['org_filter'] : 'asc';
    $arbo_id_arr = array();
    $arbo_name_arr = array();
    $total_member_arr = array();
    $male_arb = array();
    $female_arb = array();
    $male_narb = array();
    $female_narb = array();
    if($sort != 'asc' and $sort != 'desc') {
        $sort == 'desc';
    }

    $sql = "SELECT arbo.id, arbo.NAME , count(mem.arbo_mem_id) as total
    from arbo_association_members as mem
    inner join arbo_profile as arbo on mem.ARBO_PROFILE_ID = arbo.id
    GROUP BY arbo.id
    ORDER BY (SELECT count(arbo_mem_id)
    from arbo_association_members WHERE arbo.id = arbo_association_members.arbo_profile_Id) $sort
    LIMIT 5";
    $run_sql = $conn->prepare($sql);
    $run_sql->execute();
    $run_sql->bind_result($arbo_id, $arbo_name, $total_member);
    $run_sql->store_result();
    if($run_sql->num_rows() > 0) {
        while($run_sql->fetch()) {
            array_push($arbo_id_arr, $arbo_id);
            array_push($arbo_name_arr, $arbo_name);
            array_push($total_member_arr, $total_member);
        }
    }

    $male_arb = countAssocMem($arbo_id_arr, 1, 1);
    $female_arb = countAssocMem($arbo_id_arr, 0, 1);
    $male_narb = countAssocMem($arbo_id_arr, 1, 0);
    $female_narb = countAssocMem($arbo_id_arr, 0, 0);


    for($i = 0 ;$i  < count($arbo_id_arr); $i++) {
        echo "<tr>
                <td colspan='3'><a href='po_profile.php?id=$arbo_id_arr[$i]'>$arbo_name_arr[$i]</a></td>
                <td>$total_member_arr[$i]</td>
                <td>$male_arb[$i]</td>
                <td>$female_arb[$i]</td>
                <td>$male_narb[$i]</td>
                <td>$female_narb[$i]</td>
            </tr>";
    }


    function countAssocMem(Array $id, $gender, $arb_type) {
        require 'connection.php';
        $data = array();
        $sql = "SELECT COUNT(id) from arbo_association_members where ARBO_PROFILE_ID = ? and sex = ? and ARBO_ARB_TYPE_ID = ?";
        $sql = $conn->prepare($sql);
        for($i = 0 ; $i < count($id); $i++) {
            $sql->bind_param('iii' , $id[$i] ,$gender , $arb_type);
            $sql->execute();
            $sql->bind_result($count);
            $sql->store_result();
            if($sql->num_rows() > 0) {
                while($sql->fetch()) {
                    array_push($data, $count);
                }
            }
        }
        return $data;
    }
?>