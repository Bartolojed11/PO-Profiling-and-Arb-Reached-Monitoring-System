<?php
    require 'connection.php';
    $fname = isset($_POST['fname']) ? $_POST['fname'] : '';
    $lname = isset($_POST['lname']) ? $_POST['lname'] : '';
    $mi = isset($_POST['mi']) ? $_POST['mi'] : '';
    $index = isset($_POST['index']) ? $_POST['index'] : 0;
    $full_name =  isset($_POST['assoc_full_name']) ? $_POST['assoc_full_name'] : '';
    $org = array();
    $org1 = array();

    if(empty($full_name)) {
        $sql = 'SELECT distinct(arbo.name)
        FROM arbo_profile as arbo
        inner join arbo_association_members as assoc on assoc.arbo_profile_id = arbo.id
        inner join part1_arb_household as hhold on hhold.hhold_id = assoc.arbo_mem_id
        where hhold.ln_arb = ? and hhold.fn_arb = ? and hhold.mn_arb = ?';
        $sql = $conn->prepare($sql);
        $sql->bind_param('sss' , $lname, $fname ,$mi);
        $sql->execute();
        $sql->bind_result($org_ftch);
        $sql->store_result();
        if($sql->num_rows() > 0) {
            while($sql->fetch()) {
                array_push($org,$org_ftch );
            }
        }

        $sql = "SELECT distinct(arbo.name)
        FROM arbo_profile as arbo
        inner join arbo_association_members as assoc on assoc.arbo_profile_id = arbo.id
        inner join part1_arb_household as hhold on hhold.hhold_id = assoc.arbo_mem_id
        where hhold.ln_arb= ? and hhold.fn_arb = ? and hhold.mn_arb = ?";
        $sql = $conn->prepare($sql);
        $sql->bind_param('sss' , $lname, $fname ,$mi);
        $sql->execute();
        $sql->bind_result($org_ftch1);
        $sql->store_result();
        if($sql->num_rows() > 0) {
            while($sql->fetch()) {
                array_push($org1,$org_ftch1);
            }
        }
        $trp = 1;
    } else {
        $sql = "SELECT distinct(arbo.name)
        FROM arbo_profile as arbo
        inner join arbo_association_members as assoc on assoc.arbo_profile_id = arbo.id
        inner join part1_arb_household as hhold on hhold.hhold_id = assoc.arbo_mem_id
        where concat_ws(' ' , hhold.fn_arb, hhold.mn_arb , hhold.ln_arb) = ? ";
        $sql = $conn->prepare($sql);
        $sql->bind_param('s' , $full_name);
        $sql->execute();
        $sql->bind_result($org_ftch);
        $sql->store_result();
        if($sql->num_rows() > 0) {
            while($sql->fetch()) {
                array_push($org,$org_ftch );
            }
        }

        $sql = "SELECT distinct(arbo.arbo_name)
                FROM part4_arbo as arbo
                inner join part1_arb_household as hhold on hhold.hhold_id = arbo.hhold_id
                where concat_ws(' ' , hhold.fn_arb, hhold.mn_arb , hhold.ln_arb) = ? ";
        $sql = $conn->prepare($sql);
        $sql->bind_param('s' , $full_name);
        $sql->execute();
        $sql->bind_result($org_ftch1);
        $sql->store_result();
        if($sql->num_rows() > 0) {
            while($sql->fetch()) {
                array_push($org1,$org_ftch1);
            }
        }
        $trp = 0;
    }

    
    if(count($org1) > 0) {
        for($i = 0 ; $i < count($org1) ; $i++) {
            if(!in_array($org1[$i],  $org)) {
                array_push($org, $org1[$i]);
            }
            
        }
    }
    
    $class = ""; 
    if(count($org) > 0) {
        $class = "btn-success";
    } else {
        $class = "btn-default";
    }
    $org_ttl = count($org);
    // echo $org_ttl;
    // echo var_dump($org);
    echo "<button type='button' class='btn $class btn-sm show_org_count' data-toggle='modal'
        data-target='#arb_org__$index' style='border-radius:30%;'>$org_ttl</button>
    <div class='modal fade' id='arb_org__$index' role='dialog'>
    <div class='modal-dialog modal-lg'>
      <div class='modal-content'>
        <div class='modal-header'>
          <button type='button' class='close' data-dismiss='modal'>&times;</button>
          <h4 class='modal-title'>ARB ORGANIZATION $trp $full_name here</h4>
        </div>
        <div class='modal-body'>
          <p>".implode('<br>',$org)."</p>
        </div>
        <div class='modal-footer'>
          <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
        </div>
      </div>
    </div>
  </div>";

    
