<?php
require "connectdb.php";
require 'arb_functions.php';
$date_updated  =  date("Y-m-d h:i:sa");
    if(isset($_POST['update'])) {
        $arb_id = isset($_POST['arb_id']) ?   sanitize($_POST['arb_id']) : 0;
        $arb_city = isset($_POST['arb_municipal']) ?   sanitize($_POST['arb_municipal']) :  '' ;
        $arb_brgy = isset($_POST['arb_barangay']) ?   sanitize($_POST['arb_barangay']) :  '' ;
        $arb_lname = isset($_POST['arb_lname']) ?   sanitize($_POST['arb_lname']) :  '' ;
        $arb_fname = isset($_POST['arb_fname']) ?   sanitize($_POST['arb_fname']) :  '' ;
        $arb_mi = isset($_POST['arb_mi']) ?   sanitize($_POST['arb_mi']) :  '' ;
        $arb_gender = isset($_POST['gender']) ?   sanitize($_POST['gender']) :  '' ;
        $civil_status = isset($_POST['civil_status']) ?   sanitize($_POST['civil_status']) :  '' ;
        $arb_bdate = isset($_POST['arb_bdate']) ?   sanitize($_POST['arb_bdate']) :  '' ;
        $spouse_lname = isset($_POST['spouse_lname']) ?   sanitize($_POST['spouse_lname']) :  '' ;
        $spouse_fname = isset($_POST['spouse_fname']) ?   sanitize($_POST['spouse_fname']) :  '' ;
        $spouse_mi = isset($_POST['spouse_mi']) ?   sanitize($_POST['spouse_mi']) :  '' ;
        $arb_cloa = isset($_POST['arb_cloa']) ?   sanitize($_POST['arb_cloa']) :  '' ;
        $arb_landsize = isset($_POST['arb_landsize']) ?   sanitize($_POST['arb_landsize']) : 0 ;
        $arb_arbo = isset($_POST['arb_arbo']) ?   sanitize($_POST['arb_arbo']) :  '' ;
        $arb_position = isset($_POST['arb_position']) ?   sanitize($_POST['arb_position']) :  '' ;
        $date_of_mem = isset($_POST['date_of_mem']) ?   sanitize($_POST['date_of_mem']) :  '' ;
        $status = isset($_POST['status']) ?   sanitize($_POST['status']) :  '' ;
        $arb_trainings = isset($_POST['arb_trainings']) ?   sanitizeArr($_POST['arb_trainings']) :  array() ;
        
        $arb_name_prod = isset($_POST['arb_name_prod']) ?   sanitize($_POST['arb_name_prod']) :  '' ;
        $arb_prod_amount = isset($_POST['arb_prod_amount']) ?   sanitize($_POST['arb_prod_amount']) :  '' ;
        $arb_name_micro = isset($_POST['arb_name_micro']) ?   sanitize($_POST['arb_name_micro']) :  '' ;
        $arb_micro_amount = isset($_POST['arb_micro_amount']) ?   sanitize($_POST['arb_micro_amount']) :  '' ;
        $arb_name_lhood = isset($_POST['arb_name_lhood']) ?   sanitize($_POST['arb_name_lhood']) :  '' ;
        $arb_lhood_amount = isset($_POST['arb_lhood_amount']) ?   sanitize($_POST['arb_lhood_amount']) :  '' ;
        
        $attestedby = isset($_POST['attestedby']) ?   sanitize($_POST['attestedby']) :  '' ;
        $interviewedby = isset($_POST['interviewedby']) ?   sanitize($_POST['interviewedby']) :  '' ;

        $q95 = isset($_POST['q95']) ?   sanitizeArr($_POST['q95']) : array();
        $q96 = isset($_POST['q96']) ?   sanitizeArr($_POST['q96']) : array();
        $q97 = isset($_POST['q97']) ?   sanitizeArr($_POST['q97']) : array();
        $q79 = isset($_POST['q79']) ?   sanitizeArr($_POST['q79']) : array();
        $q98_spec = isset($_POST['q98_spec']) ?   sanitizeArr($_POST['q98_spec']) : array() ;
        $q98 = isset($_POST['q98']) ?   sanitizeArr($_POST['q98']) : array() ;

        $pos_id = check_position($arb_position);
        if($pos_id < 1) {
            insert_pos($arb_position);
            $pos_id = check_position($arb_position);
        }

        $arbo_id = checkArbo($arb_arbo);
        if($arbo_id < 1) {
            insertArbo($arb_arbo);
            $arbo_id = checkArbo($arb_arbo);
        }

        $arb_landsize = preg_replace("/[^0-9.]/", "", $arb_landsize);
        $arb_landsize = empty($arb_landsize) ? 0 : $arb_landsize;
        $sql = 'UPDATE arb_information SET 
        fname = ?, lname = ?, mi = ?, gender = ?, bdate = ?, spouse_fname = ?, spouse_lname = ?,spouse_mi = ?,
        cloa_num = ?, land_size = ?, date_of_mem = ?, attested_by = ?, interviewed_by = ?, civil_status = ?,
        arb_status = ?, arbo_id = ?, pos_id = ?, brgy_id = ?, city_id = ?, updated_at = ?
        WHERE id = ?';

        $sql = $conn->prepare($sql);
        $sql->bind_param('sssssssssssssssiiiisi' ,
        $arb_fname, $arb_lname, $arb_mi, $arb_gender, $arb_bdate, $spouse_fname, $spouse_lname, $spouse_mi, $arb_cloa,
        $arb_landsize, $date_of_mem, $attestedby, $interviewedby, $civil_status, $status, $arbo_id, $pos_id, $arb_brgy, $arb_city,$date_updated, $arb_id);

        if($sql->execute()) {
        
        $sql_del = 'DELETE FROM arb_trainings_attended WHERE arb_id = ?';
        $sql_del = $conn->prepare($sql_del);
        $sql_del->bind_param('i' , $arb_id);
        $sql_del->execute();
        
        $sql = 'INSERT INTO arb_trainings_attended (arb_id,trainings_id) VALUES (?,?)';
        $sql = $conn->prepare($sql);

        if(count($arb_trainings) > 0) {
            for($i = 0 ; $i < count($arb_trainings) ; $i++) {
                $sql->bind_param('ii', $arb_id, $arb_trainings[$i]);
                $sql->execute();
            }
        }

        $ssa = array('production','micro','livelihood');
        $sql = 'UPDATE arb_support_serv_av SET institution = ?, amount = ? WHERE arb_id = ? and description = ?';
        
        $sql = $conn->prepare($sql);

        $sql->bind_param('ssis' , $arb_name_prod, $arb_prod_amount , $arb_id , $ssa[0]);
        $sql->execute();

        $sql->bind_param('ssis' , $arb_name_micro, $arb_micro_amount , $arb_id , $ssa[1]);
        $sql->execute();
        
        $sql->bind_param('ssis' , $arb_name_lhood, $arb_lhood_amount, $arb_id , $ssa[2]);
        $sql->execute();

            //interventions
        $intervention_qid = [95,96,97,98,79];
        $sql_del = 'DELETE FROM arb_acquired_intervention WHERE arb_id = ?';
        $sql_del = $conn->prepare($sql_del);
        $sql_del->bind_param('i', $arb_id);
        $sql_del->execute();

        $sql = 'INSERT INTO arb_acquired_intervention (arb_id, main_id, sub_id) values (?,?,?)';
        $run_sql = $conn->prepare($sql);
            for ($i = 0; $i < count($q79); $i++) {
                $run_sql->bind_param('iii', $arb_id, $intervention_qid[4], $q79[$i]);
                $run_sql->execute();
            }

            for ($i = 0; $i < count($q95); $i++) {
                $run_sql->bind_param('iii', $arb_id, $intervention_qid[0], $q95[$i]);
                $run_sql->execute();
            }

            for ($i = 0; $i < count($q96); $i++) {
                $run_sql->bind_param('iii', $arb_id, $intervention_qid[1], $q96[$i]);
                $run_sql->execute();
            }

            for ($i = 0; $i < count($q97); $i++) {
                $run_sql->bind_param('iii', $arb_id, $intervention_qid[2], $q97[$i]);
                $run_sql->execute();
            }

            $sql = 'INSERT INTO arb_acquired_intervention (arb_id, sub_id , specify_intervention, main_id)
                values (?,?,?,?)';

            $run_sql = $conn->prepare($sql);
            for($i = 0 ; $i < count($q98_spec); $i++) {
                $run_sql->bind_param('iisi' , $arb_id , $q98[$i] , $q98_spec[$i], $intervention_qid[3]);
                $run_sql->execute();
            }
            echo "<script>
                    alert('Updated Successfully');
                    window.location.href='../arb-reached.php';
                </script>";
        } else {
            echo "<script>
                    alert('Failed to update!');
                    window.location.href='../arb-update.php?id=$arb_id';
                </script>";
        }
    }