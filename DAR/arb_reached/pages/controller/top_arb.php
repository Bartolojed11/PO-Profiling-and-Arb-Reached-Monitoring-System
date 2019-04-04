<?php
    require 'connectdb.php';

    $sort = isset($_POST['org_filter']) ? $_POST['org_filter'] : 'asc';
    if($sort != 'asc' and $sort != 'desc') {
        $sort == 'desc';
    }

    $male = "M";
    $female = "F";

    $gend = "SELECT distinct(COUNT(arb.id))
        from arb_information as arb
        where arb.arbo_id = arbo.id and arb.gender = ";

    $sql = "SELECT distinct(arbo.arbo_name),
                (
                    CASE
                    WHEN arbo.arbo_name != ''
                    THEN (SELECT count(arb_.id) from arb_information as arb_ WHERE arb_.arbo_id = arbo.ID)
                    END
                ) as total_arb,
                (
                    CASE
                    WHEN arbo.arbo_name != ''
                    THEN ($gend '$male')
                    END
                ) as total_male,
                (
                    CASE
                    WHEN arbo.arbo_name != ''
                    THEN ($gend '$female')
                    END
                ) as total_female
            FROM arb_information as arb
            inner join arb_org as arbo on arbo.id = arb.arbo_id
            WHERE arbo.arbo_name != ''
            ORDER BY total_arb $sort LIMIT 5";
            // WHERE ((SELECT count(*) FROM arb_trainings_attended WHERE arb_id = arb.id) > 0)
            // and ((SELECT COUNT(*) FROM arb_acquired_intervention WHERE arb_id = arb.id) > 0)
    $run_sql = $conn->prepare($sql);
    $run_sql->execute();
    $run_sql->bind_result($arbo_name,$total_arb, $male_arb, $female_arb);
    $run_sql->store_result();
    if($run_sql->num_rows() > 0) {
        while($run_sql->fetch()) {
            echo '<tr>
                    <td colspan="3">'.$arbo_name.'</td>
                    <td class="text-center" colspan="1">'.$total_arb.'</td>
                    <td class="text-center" colspan="1">'.$male_arb.'</td>
                    <td class="text-center" colspan="1">'.$female_arb.'</td>
                </tr>';
        }
    }

?>


<?php

