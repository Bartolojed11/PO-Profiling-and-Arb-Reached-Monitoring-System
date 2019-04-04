<?php
    require 'connectdb.php';
    $bid = isset($_POST['bid']) ? $_POST['bid'] : 0;
    $cid = isset($_POST['cid']) ? $_POST['cid'] : 0;
    $ttl_landsize = 0;
    $cid = htmlspecialchars($cid);
    if($bid == 0) {
        $sql = "SELECT concat_ws(' ' ,  arb.lname, arb.fname, arb.mi) as arb_fullname,arb.id, arb.arb_status, arb.gender,
        concat_ws(', ' , brgy.brgy , city.city , 'Negros Occidental') as arb_address , arbo.arbo_name, arb.land_size
        FROM arb_information as arb
        inner join city on city.id = arb.city_id
        inner join barangay as brgy on brgy. id = arb.brgy_id
        inner join arb_org as arbo on arbo.id = arb.arbo_id
        WHERE arb.city_id = ? and
        (((SELECT count(*) FROM arb_trainings_attended WHERE arb_id = arb.id) > 0
        OR
        ((select count(*) from arb_support_serv_av where institution != '' and amount != 0  and arb_id = arb.id Group by arb_id) > 0))
        OR ((SELECT COUNT(*) FROM arb_acquired_intervention WHERE arb_id = arb.id) > 0)) 
        GROUP BY arb.id ORDER BY arb.inserted_at DESC";
        $sql = $conn->prepare($sql);
        $sql->bind_param('i',$cid);
    } else {
        $sql = "SELECT concat_ws(' ' ,  arb.lname, arb.fname, arb.mi) as arb_fullname,arb.id, arb.arb_status, arb.gender,
        concat_ws(', ' , brgy.brgy , city.city , 'Negros Occidental') as arb_address , arbo.arbo_name, arb.land_size
        FROM arb_information as arb
        inner join city on city.id = arb.city_id
        inner join barangay as brgy on brgy. id = arb.brgy_id
        inner join arb_org as arbo on arbo.id = arb.arbo_id
        WHERE arb.city_id = ? and arb.brgy_id = ?  and 
        (((SELECT count(*) FROM arb_trainings_attended WHERE arb_id = arb.id) > 0
        OR
        ((select count(*) from arb_support_serv_av where institution != '' and amount != 0  and arb_id = arb.id Group by arb_id) > 0))
        OR ((SELECT COUNT(*) FROM arb_acquired_intervention WHERE arb_id = arb.id) > 0)) 
        GROUP BY arb.id ORDER BY arb.inserted_at DESC";
        $sql = $conn->prepare($sql);
        $sql->bind_param('ii',$cid, $bid);
    }
    
    echo '<table id="reached-arb" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th class="text-center" style="width:180px;">ARB NAME</th>
                    <th class="text-center" style="width:320px;">ARB ADDRESS</th>
                    <th class="text-center" style="width:30px;">SEX</th>
                    <th class="text-center" style="width:40px;">STATUS</th>
                    <th class="text-center" style="width:80px;">LANDSIZE(ha)</th>
                    <th class="text-center" style="width:330px;">ORGANIZATION</th>
                    <th></th>
                </tr>
            </thead><tbody class="text-center">';
        $sql->execute();
        $sql->bind_result($arb_fullname, $arb_id,  $arb_status, $arb_gender, $arb_addr, $arbo, $arb_landsize);
        $sql->store_result();
        if($sql->num_rows() > 0 ) {
            while($sql->fetch()) {
                $ttl_landsize += $arb_landsize;
                $arb_landsize_ = number_format($arb_landsize,2);
                echo "
                <tr>
                    <td><a style='color:black;' href='arb-info.php?id=$arb_id'>".htmlspecialchars($arb_fullname)."</a></td>
                    <td>".htmlspecialchars($arb_addr)."</td>
                    <td>".htmlspecialchars($arb_gender)."</td>";
                if($arb_status == 'active') {
                    echo "<td style='color:green;'>".htmlspecialchars(ucfirst($arb_status))."</td>";
                } else {
                    echo "<td style='color:red;'>".htmlspecialchars(ucfirst($arb_status))."</td>";
                }
                echo "<td>".htmlspecialchars(ucfirst($arb_landsize_))."</td>";
                echo "<td>".htmlspecialchars($arbo)."</td>
                    <td><a href='arb-info.php?id=$arb_id'><button class='btn btn-info btn-sm'><i class='fa fa-eye' ></i>
                        </button></a>
                        <a href='arb-update.php?id=$arb_id'><button class='btn btn-primary btn-sm'><i class='fa fa-edit' ></i>
                        </button></a>
                        <a href='arb-print.php?id=$arb_id' target='_blank'><button class='btn btn-success btn-sm'><i class='fa fa-print' ></i>
                        </button></a>
                    </td>
                       
                </tr>";
            }
        }
        $ttl_landsize = number_format($ttl_landsize,2);
        echo "</tbody>
        </table>
        <input type='hidden' value='$ttl_landsize' id='ttl_land_hid'>";
?>