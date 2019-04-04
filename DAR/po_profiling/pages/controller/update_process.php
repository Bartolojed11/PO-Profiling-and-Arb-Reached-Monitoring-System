<?php
require_once 'connection.php';
date_default_timezone_set("Asia/Singapore");
$date_updated  =  date("Y-m-d h:i:sa");

if (isset($_POST['submit'])) { 
    $prof_id =  $_POST['prof_id'];
    $as_of_date = isset($_POST['part1_arbo_of']) ? $_POST['part1_arbo_of'] : '';
    $arbo_name = isset($_POST['part1_arbo_name']) ? $_POST['part1_arbo_name'] : '';
    $acro_name = isset($_POST['part1_acro_name']) ? $_POST['part1_acro_name'] : '';
    $contact_person = isset($_POST['contact_person']) ? $_POST['contact_person'] : '';
    $date_organized = isset($_POST['date_organized']) ? $_POST['date_organized'] : '';
    $date_reg = isset($_POST['date_reg']) ? $_POST['date_reg'] : '';
    $reg_num = isset($_POST['reg_num']) ? $_POST['reg_num'] : '';
    $agency_registered = isset($_POST['agency_registered']) ? $_POST['agency_registered'] : '';
    $oranization_type = isset($_POST['organization_type']) ? $_POST['organization_type'] : '';
    $affliation = isset($_POST['affliation']) ? $_POST['affliation'] : '';
    $part1_name_org_assisting = isset($_POST['part1_name_org_assisting']) ? $_POST['part1_name_org_assisting'] : '';
    $part_year = isset($_POST['part1_year']) ? $_POST['part1_year'] : '';

    $other = isset($_POST['other']) ? $_POST['other'] : '';
    $prov = isset($_POST['arbo_province']) ? $_POST['arbo_province'] : '';
    $city = isset($_POST['arbo_municipal']) ? $_POST['arbo_municipal'] : '';
    $brgy = isset($_POST['arbo_barangay']) ? $_POST['arbo_barangay'] : '';
    $others = isset($_POST['arbo_sps']) ? $_POST['arbo_sps'] : '';

    $ope_prov = isset($_POST['ope_prov']) ? $_POST['ope_prov'] : '';
    $ope_city = isset($_POST['ope_city']) ? $_POST['ope_city'] : '';
    $ope_brgy = isset($_POST['ope_brgy']) ? $_POST['ope_brgy'] : '';
    $ope_others = isset($_POST['ope_sps']) ? $_POST['ope_sps'] : '';


    $purpose_of_loan = isset($_POST['purpose_of_loan']) ? $_POST['purpose_of_loan'] : array(); //nature
    $loan_amount = isset($_POST['loan_amount']) ? $_POST['loan_amount'] : ''; //amount
    $loan_source = isset($_POST['loan_source']) ? $_POST['loan_source'] : ''; //
    $loan_date_released = isset($_POST['loan_date_released']) ? $_POST['loan_date_released'] : 0;
    $loan_date_availed = isset($_POST['loan_date_availed']) ? $_POST['loan_date_availed'] : 0;
    $loan_terms_payment = isset($_POST['loan_terms_payment']) ? $_POST['loan_terms_payment'] : 0;
    $loan_amount_paid = isset($_POST['loan_amount_paid']) ? $_POST['loan_amount_paid'] : 0;
 
    $total_arb_male = isset($_POST['part3_arb1_male']) ? $_POST['part3_arb1_male'] : 0;
    $total_arb_female = isset($_POST['part3_arb1_female']) ? $_POST['part3_arb1_female'] : 0;
    $total_non_arb_male = isset($_POST['part3_arb2_male']) ? $_POST['part3_arb2_male'] : 0;
    $total_non_arb_female = isset($_POST['part3_arb2_female']) ? $_POST['part3_arb2_female'] : 0;
    $male_hh_arb = isset($_POST['male_hh_arb']) ? $_POST['male_hh_arb'] : 0 ;
    $female_hh_arb = isset($_POST['female_hh_arb']) ? $_POST['female_hh_arb'] : 0 ;

    $capital_amount = isset($_POST['part3_capital_amount']) ? $_POST['part3_capital_amount'] : '';
    $capital_savers = isset($_POST['part3_capital_savers']) ? $_POST['part3_capital_savers'] : '';
    $savings_amount = isset($_POST['part3_savings_amount']) ? $_POST['part3_savings_amount'] : '';
    $savings_savers = isset($_POST['part3_savings_savers']) ? $_POST['part3_savings_savers'] : '';
    $total_amount = isset($_POST['part3_total_assets_am']) ? $_POST['part3_total_assets_am'] : '';
    $total_savers = isset($_POST['part3_total_assets_sav']) ? $_POST['part3_total_assets_sav'] : '';
    $liability_amount = isset($_POST['part3_liability_amount']) ? $_POST['part3_liability_amount'] : '';
    $liability_savers = isset($_POST['part3_liability_savers']) ? $_POST['part3_liability_savers'] : '';
    $networth_amount = isset($_POST['part3_networth_amount']) ? $_POST['part3_networth_amount'] : '';
    $networth_savers = isset($_POST['part3_networth_savers']) ? $_POST['part3_networth_savers'] : '';

    $off_bod_fname = isset($_POST['off_bod_fname']) ? $_POST['off_bod_fname'] : array();
    $off_bod_lname = isset($_POST['off_bod_lname']) ? $_POST['off_bod_lname'] : array();
    $off_bod_mname = isset($_POST['off_bod_mname']) ? $_POST['off_bod_mname'] : array();
    $offcrs_and_bod_position = isset($_POST['offcrs_and_bod_position']) ? $_POST['offcrs_and_bod_position'] : array();
    //
    $q95 = isset($_POST['q95']) ? $_POST['q95'] : array();
    $q96 = isset($_POST['q96']) ? $_POST['q96'] : array();
    $q97 = isset($_POST['q97']) ? $_POST['q97'] : array();
    $q79 = isset($_POST['q79']) ? $_POST['q79'] : array();
    $q98_spec = isset($_POST['q98_spec']) ? $_POST['q98_spec'] : array() ;
    $q98 = isset($_POST['q98']) ? $_POST['q98'] : array() ;

    $assoc_firstname = isset($_POST['assoc_firstname']) ? $_POST['assoc_firstname'] : array();;
    $assoc_lastname = isset($_POST['assoc_lastname']) ? $_POST['assoc_lastname'] : array();
    $assoc_mi = isset($_POST['assoc_mi']) ? $_POST['assoc_mi'] : ' ';
    $assoc_position = isset($_POST['assoc_position']) ? $_POST['assoc_position'] : 14;
    $assoc_gender = isset($_POST['assoc_gender']) ? $_POST['assoc_gender'] : 1;
    $assoc_arb_type = isset($_POST['assoc_arb_type']) ? $_POST['assoc_arb_type'] : 0;
    $assoc_status = isset($_POST['assoc_status']) ? $_POST['assoc_status'] : 0;
    $assoc_cloa_number = isset($_POST['assoc_cloa_number']) ? $_POST['assoc_cloa_number'] : ' ';
    $assoc_landsize = isset($_POST['assoc_landsize']) ? $_POST['assoc_landsize']: ' ';
    $assoc_crop = isset($_POST['assoc_crop']) ? $_POST['assoc_crop'] : '';
    $assoc_sugar = isset($_POST['assoc_sugar']) ? $_POST['assoc_sugar'] : 0;
    $assoc_cbu = isset($_POST['assoc_cbu']) ? $_POST['assoc_cbu'] : 0;
    $assoc_saving = isset($_POST['assoc_saving']) ? $_POST['assoc_saving'] : array();
    $assoc_production = isset($_POST['assoc_production']) ? $_POST['assoc_production'] : 0;
    $assoc_mrktng = isset($_POST['assoc_mrktng']) ? $_POST['assoc_mrktng'] : 0;
    $assoc_credit = isset($_POST['assoc_credit']) ? $_POST['assoc_credit'] : 0;
    $assoc_phf = isset($_POST['assoc_phf']) ? $_POST['assoc_phf'] : 0;
    $assoc_micro = isset($_POST['assoc_micro']) ? $_POST['assoc_micro'] : 0;
    $assoc_srvce = isset($_POST['assoc_srvce']) ? $_POST['assoc_srvce'] : 0;
    $assoc_others = isset($_POST['assoc_others']) ? $_POST['assoc_others'] : 0;
    $assoc_train_attended = isset($_POST['assoc_train_attended']) ? $_POST['assoc_train_attended'] : ' ';
    

    $pre_harv_id = isset($_POST['pre_harv_id']) ? $_POST['pre_harv_id'] : '';
    $pre_harv_units = isset($_POST['pre_harv_units']) ? $_POST['pre_harv_units'] : '';
    $pre_harv_mem = isset($_POST['pre_harv_mem']) ? $_POST['pre_harv_mem'] : '';
    $pre_harv_nonmem = isset($_POST['pre_harv_nonmem']) ? $_POST['pre_harv_nonmem'] : '';

    $livestock = isset($_POST['livestock']) ? $_POST['livestock'] : '';
    $livestock_unit = isset($_POST['livestock_unit']) ? $_POST['livestock_unit'] : '';
    $livestock_mem = isset($_POST['livestock_mem']) ? $_POST['livestock_mem'] : '';
    $livestock_nonmem = isset($_POST['livestock_nonmem']) ? $_POST['livestock_nonmem'] : '';

    $poultry = isset($_POST['poultry']) ? $_POST['poultry'] : '';
    $poultry_unit = isset($_POST['poultry_unit']) ? $_POST['poultry_unit'] : '';
    $poultry_mem = isset($_POST['poultry_mem']) ? $_POST['poultry_mem'] : '';
    $poultry_nonmem = isset($_POST['poultry_nonmem']) ? $_POST['poultry_nonmem'] : '';

    $post_harv = isset($_POST['post_harv']) ? $_POST['post_harv'] : '';
    $post_harv_unit = isset($_POST['post_harv_unit']) ? $_POST['post_harv_unit'] : '';
    $post_harv_mem = isset($_POST['post_harv_mem']) ? $_POST['post_harv_mem'] : '';
    $post_harv_nonmem = isset($_POST['post_harv_nonmem']) ? $_POST['post_harv_nonmem'] : '';

    $other_proj = isset($_POST['other_proj']) ? $_POST['other_proj'] : '';
    $other_proj_unit = isset($_POST['other_proj_unit']) ? $_POST['other_proj_unit'] : '';
    $other_proj_mem = isset($_POST['other_proj_mem']) ? $_POST['other_proj_mem'] : '';
    $other_proj_nonmem = isset($_POST['other_proj_nonmem']) ? $_POST['other_proj_nonmem'] : '';

    $other_preharv = isset($_POST['1_pre_harv_id']) ? $_POST['1_pre_harv_id'] : array();
    $other_lvstck = isset($_POST['2_livestock']) ? $_POST['2_livestock']  : array();
    $other_pltry = isset($_POST['3_poultry']) ? $_POST['3_poultry'] : array();
    $other_postharv = isset($_POST['4_post_harv']) ? $_POST['4_post_harv'] : array();
    $other_othrproj = isset($_POST['5_other_proj']) ? $_POST['5_other_proj'] : array();

    $oth_pre_id = isset($_POST['oth_pre_harv_id']) ? $_POST['oth_pre_harv_id'] : array();
    $oth_live_id = isset($_POST['oth_livestock']) ? $_POST['oth_livestock'] : array();
    $oth_pltry_id = isset($_POST['oth_poultry']) ? $_POST['oth_poultry'] : array();
    $oth_post_id = isset($_POST['oth_post_harv']) ? $_POST['oth_post_harv'] : array();
    $oth_proj = isset($_POST['oth_other_proj']) ? $_POST['oth_other_proj'] : array();


    $train_title = isset($_POST['part3_title']) ? $_POST['part3_title'] : array();
    $date_conduct = isset($_POST['part3_date_conducted']) ? $_POST['part3_date_conducted'] : '';
    $conducted_by = isset($_POST['part3_conducted_by']) ? $_POST['part3_conducted_by'] : '';
    $officers = isset($_POST['part3_officers']) ? $_POST['part3_officers'] : '';
    $p3_members = isset($_POST['part3_members']) ? $_POST['part3_members'] : '';

    $ngo_organization_assisting = isset($_POST['par1_name_org_assiting']) ? $_POST['par1_name_org_assiting'] : array();
    $year = isset($_POST['part1_year']) ? $_POST['part1_year'] : '';

    $arb_stat = 1;

    $sql_po_profile = 'UPDATE arbo_profile SET as_of=?,NAME=?,  ACRONYM =?, ARBO_PROVINCE=? , ARBO_CITY=?, ARBO_BRGY=?, ARBO_ADDR_OTHERS=?,
    AREA_OF_OPERATION_PROV=?, AREA_OF_OPERATION_CITY=?, AREA_OF_OPERATION_BRGY=?, AREA_OF_OPERATION_OTHERS=?,CONTACT_PERSON=?, date_organized=?,
    date_registered=?, registration_no=?, agency_registered=?, type_of_organization=?, AFFILIATION=?,date_updated=?
    WHERE id = ?';

    $sql_po_profile = 'UPDATE arbo_profile SET as_of = ? , NAME = ?, ACRONYM = ?,
    ARBO_PROVINCE = ? , ARBO_CITY = ?, ARBO_BRGY = ?, ARBO_ADDR_OTHERS = ?,
    AREA_OF_OPERATION_PROV = ?, AREA_OF_OPERATION_CITY = ?, AREA_OF_OPERATION_BRGY = ?,
    AREA_OF_OPERATION_OTHERS = ?,CONTACT_PERSON = ?, date_organized = ?,
    date_registered = ?, registration_no = ?, agency_registered = ?, type_of_organization = ? ,
    AFFILIATION = ?,date_updated=? WHERE id = ?';

    $run_sql_po_profile = $conn->prepare($sql_po_profile);

    $run_sql_po_profile->bind_param('sssssssssssssssssssi', 
    $as_of_date, $arbo_name, $acro_name, $prov, $city, $brgy, $others, $ope_prov,
    $ope_city, $ope_brgy, $ope_others, $contact_person, $date_organized, $date_reg, $reg_num,
    $agency_registered, $oranization_type, $affliation, $date_updated, $prof_id);
    $run_sql_po_profile->execute();

    if(!empty($_FILES['arbo_form_image']))  {
        $path = "registration_form_images/";
        $image_name =  $path . date("Ymdhis").'_'.basename( $_FILES['arbo_form_image']['name']);
        move_uploaded_file($_FILES['arbo_form_image']['tmp_name'], $image_name);
        
        $sql  = 'UPDATE arbo_profile SET registration_form_image = ? WHERE id = ?';
        $run_sql = $conn->prepare($sql);
        $run_sql->bind_param('si',$image_name,$prof_id );
        $run_sql->execute();
    }

    $sql = 'SELECT distinct(COUNT(arbo_profile_id)) from arbo_membership WHERE arbo_profile_id = ?';
    $sql_arbo_membership = $conn->prepare($sql);
    $sql_arbo_membership->bind_param('i',$prof_id);
    $sql_arbo_membership->execute();
    $sql_arbo_membership->bind_result($idd);
    $sql_arbo_membership->store_result();
    $sql_arbo_membership->num_rows();
    $sql_arbo_membership->fetch();
    if($idd > 0) {
        $sql_arbo_membership = 'UPDATE arbo_membership
        SET TOTAL_ARB_MALE = ?, TOTAL_ARB_FEMALE = ?, 
            TOTAL_NON_ARB_MALE = ?, TOTAL_NON_ARB_FEMALE = ?,
            male_hh_arb = ?, female_hh_arb = ? where arbo_profile_id = ?';
    
        $run_sql_arbo_membership = $conn->prepare($sql_arbo_membership);
        $run_sql_arbo_membership->bind_param('iiiiiii', $total_arb_male, $total_arb_female, $total_non_arb_male,  $total_non_arb_female
                ,$male_hh_arb, $female_hh_arb, $prof_id);
        $run_sql_arbo_membership->execute();
        } else {
        $sql_arbo_membership = 'INSERT INTO arbo_membership
         (arbo_profile_id, TOTAL_ARB_MALE, TOTAL_ARB_FEMALE , TOTAL_NON_ARB_MALE , TOTAL_NON_ARB_FEMALE,
            male_hh_arb, female_hh_arb) VALUES (?,?,?,?,?,?,?)';
    
        $run_sql_arbo_membership = $conn->prepare($sql_arbo_membership);
        $run_sql_arbo_membership->bind_param('iiiiiii', $prof_id, $total_arb_male, $total_arb_female, $total_non_arb_male,  $total_non_arb_female
                ,$male_hh_arb, $female_hh_arb);
        $run_sql_arbo_membership->execute();
        }

    $sql_srvcs_del = 'DELETE FROM arbo_services_provided where arbo_profile_id = ?';
        $run_sql_srvcs_del = $conn->prepare($sql_srvcs_del);
        $run_sql_srvcs_del->bind_param('i',$prof_id);
        $run_sql_srvcs_del->execute();

        $sql_srvcs_prvdd = 'INSERT INTO  arbo_services_provided(arbo_profile_id, arbo_service_sub_id ,
            units_or_heads,client_served_members,client_served_non_members) VALUES (?,?,?,?,?)';
            $run_sql_srvcs_prvdd = $conn->prepare($sql_srvcs_prvdd);
        for($i = 0 ; $i < count($pre_harv_id); $i++) {
                $run_sql_srvcs_prvdd->bind_param('issss', $prof_id,$pre_harv_id[$i] , $pre_harv_units[$i], $pre_harv_mem[$i], $pre_harv_nonmem[$i]);
                $run_sql_srvcs_prvdd->execute();
        }

        for($i = 0 ; $i < count($livestock); $i++) {
            $run_sql_srvcs_prvdd->bind_param('issss', $prof_id,$livestock[$i] , $livestock_unit[$i], $livestock_mem[$i], $livestock_nonmem[$i]);
            $run_sql_srvcs_prvdd->execute();
        }

        for($i = 0 ; $i < count($poultry); $i++) {
            $run_sql_srvcs_prvdd->bind_param('issss', $prof_id,$poultry[$i] , $poultry_unit[$i], $poultry_mem[$i], $poultry_nonmem[$i]);
            $run_sql_srvcs_prvdd->execute();
        }

        for($i = 0 ; $i < count($post_harv); $i++) {
            $run_sql_srvcs_prvdd->bind_param('issss', $prof_id,$post_harv[$i] , $post_harv_unit[$i], $post_harv_mem[$i], $post_harv_nonmem[$i]);
            $run_sql_srvcs_prvdd->execute();
        }

        for($i = 0 ; $i < count($other_proj); $i++) {
            $run_sql_srvcs_prvdd->bind_param('issss', $prof_id,$other_proj[$i] , $other_proj_unit[$i], $other_proj_mem[$i], $other_proj_nonmem[$i]);
            $run_sql_srvcs_prvdd->execute();
        }
        
        if(count($other_preharv) > 0) {
            $index = count($pre_harv_id);
            for($i = 0 ; $i < count($other_preharv); $i++) {
                if(!empty($other_preharv[$i])) {
                    $pre_harv_id_ = check_srvcs($other_preharv[$i]);
                    if($pre_harv_id_ == 0) {
                        insert_srvcs($other_preharv[$i],$oth_pre_id[$i]);
                        $pre_harv_id_ = check_srvcs($other_preharv[$i]);
                    }

                    $run_sql_srvcs_prvdd->bind_param('issss', $prof_id,$pre_harv_id_,
                        $pre_harv_units[$index+$i], $pre_harv_mem[$index+$i], $pre_harv_nonmem[$index+$i]);
                        $run_sql_srvcs_prvdd->execute();
                }
            }
        }
        
        if(count($other_lvstck) > 0) {
            $index = count($livestock);
            for($i = 0 ; $i < count($other_lvstck); $i++) {
                if(!empty($other_lvstck[$i])) {
                    $livestock_ = check_srvcs($other_lvstck[$i]);
                    if($livestock_ == 0) {
                        insert_srvcs($other_lvstck[$i],$oth_live_id[$i]);
                        $livestock_ = check_srvcs($other_lvstck[$i]);
                    }
                    $run_sql_srvcs_prvdd->bind_param('issss', $prof_id,$livestock_,
                        $livestock_unit[$index+$i], $livestock_mem[$index+$i], $livestock_nonmem[$index+$i]);
                    $run_sql_srvcs_prvdd->execute();
                }
            }
        }

        if(count($other_pltry) > 0) {
                $index = count($poultry);
                for($i = 0 ; $i < count($other_pltry); $i++) {
                    if(!empty($other_pltry[$i])) {
                        $other_pltry_ = check_srvcs($other_pltry[$i]);
                        if($other_pltry_ == 0) {
                            insert_srvcs($other_pltry[$i],$oth_pltry_id[$i]);
                            $other_pltry_ = check_srvcs($other_pltry[$i]);

                        $run_sql_srvcs_prvdd->bind_param('issss', $prof_id,$other_pltry_,
                            $poultry_unit[$index+$i], $poultry_mem[$index+$i], $poultry_nonmem[$index+$i]);
                        $run_sql_srvcs_prvdd->execute();
                    }
                }
            }
        }
        
        if(count($other_postharv) > 0) {
            $index = count($post_harv);
            for($i = 0 ; $i < count($other_postharv); $i++) {
                if(!empty($other_postharv[$i])) {
                    $other_postharv_ = check_srvcs($other_postharv[$i]);
                    if($other_postharv_ == 0) {
                        insert_srvcs($other_postharv[$i],$oth_post_id[$i]);
                        $other_postharv_ = check_srvcs($other_postharv[$i]);
                    }

                    $run_sql_srvcs_prvdd->bind_param('issss', $prof_id,$other_postharv_,
                        $post_harv_unit[$index+$i], $post_harv_mem[$index+$i], $post_harv_nonmem[$index+$i]);
                    $run_sql_srvcs_prvdd->execute();
                }
            }
        }

        if(count($other_othrproj) > 0) {
            $index = count($other_proj);
            for($i = 0 ; $i < count($other_othrproj); $i++) {
                if(!empty($other_othrproj[$i])) {
                    $other_othrproj_ = check_srvcs($other_othrproj[$i]);
                    if($other_othrproj_ == 0) {
                        insert_srvcs($other_othrproj[$i],$oth_proj[$i]);
                        $other_othrproj_ = check_srvcs($other_othrproj[$i]);
                    }


                    $run_sql_srvcs_prvdd->bind_param('issss', $prof_id,$other_othrproj_,
                        $other_proj_unit[$index+$i], $other_proj_mem[$index+$i], $other_proj_nonmem[$index+$i]);
                        $run_sql_srvcs_prvdd->execute();
                }
            }
        }

    //  if ($run_sql_po_profile->execute() == true) {
        $i = 0; 
        $j = 0;
        //function create
        $b = 0 ;
        $sql_del_ngo = 'DELETE FROM arbo_ngo_or_org_assist WHERE arbo_profile_id = ?';
        $sql_run_del_ngo = $conn->prepare($sql_del_ngo);
        $sql_run_del_ngo->bind_param('i' , $prof_id);
        $sql_run_del_ngo->execute();

        $sql_ngo_orgins ='INSERT into arbo_ngo_or_org_assist (name_of_ngo_assisting, ngo_year_assisted, arbo_profile_id )
                            values (?,?,?)' ;
        $run_sql_tbl_ngo_org = $conn->prepare($sql_ngo_orgins);
        for ($i = 0; $i < count($ngo_organization_assisting); $i++) {
            if(!empty($ngo_organization_assisting[$i])) {
                $run_sql_tbl_ngo_org->bind_param('ssi', $ngo_organization_assisting[$i], $year[$i], $prof_id);
                $run_sql_tbl_ngo_org->execute();
            }
        }

        $fin_stat_type_id = array(1, 2, 3, 4, 5);

        $sql_fin_del = 'DELETE FROM arbo_financial_status WHERE arbo_profile_id = ?';
        $run_sql_fin_del = $conn->prepare($sql_fin_del);
        $run_sql_fin_del->bind_param('i',$prof_id);
        $run_sql_fin_del->execute();

        $sql_fin_stat = 'INSERT into arbo_financial_status (arbo_financial_type_id,amount,no_of_savers,arbo_profile_id) values (?,?,?,?)';
        $run_sql_fin_stat = $conn->prepare($sql_fin_stat);

        $run_sql_fin_stat->bind_param('iiii', $fin_stat_type_id[0] , $capital_amount, $capital_savers, $prof_id );
        $run_sql_fin_stat->execute();
        
        $run_sql_fin_stat->bind_param('iiii', $fin_stat_type_id[1] , $savings_amount, $savings_savers ,$prof_id );
        $run_sql_fin_stat->execute();

        $run_sql_fin_stat->bind_param('iiii', $fin_stat_type_id[2] , $total_amount, $total_savers, $prof_id );
        $run_sql_fin_stat->execute();

        $run_sql_fin_stat->bind_param('iiii', $fin_stat_type_id[3] , $liability_amount, $liability_savers, $prof_id );
        $run_sql_fin_stat->execute();
		
		$run_sql_fin_stat->bind_param('iiii', $fin_stat_type_id[4] , $networth_amount, $networth_savers, $prof_id );
        $run_sql_fin_stat->execute();

        //FUNCTION CREATE
        $loan_flag = 0;

        $sql_del_loans = 'DELETE FROM arbo_loans_availed where arbo_profile_id = ?';
        $run_sql_del_loans = $conn->prepare($sql_del_loans);
        $run_sql_del_loans->bind_param('i',$prof_id);
        $run_sql_del_loans->execute();
        
        $sql_loans_availed = 'INSERT INTO arbo_loans_availed
                (arbo_profile_id , purpose_of_loan, amount, source, date_released,
                date_availed, terms_of_payment, amount_paid) values (?,?,?,?,?,?,?,?)';
                
        $run_sql_loans_availed = $conn->prepare($sql_loans_availed);
        $loan_flag = 0;
        for ($i = 0; $i < count($purpose_of_loan); $i++) {
            if(!empty($purpose_of_loan[$i])) {
                $run_sql_loans_availed->bind_param('isssssss' ,$prof_id,$purpose_of_loan[$i],$loan_amount[$i], $loan_source[$i],$loan_date_released[$i],
                                    $loan_date_availed[$i], $loan_terms_payment[$i], $loan_amount_paid[$i]);
                $run_sql_loans_availed->execute();
                $loan_flag = $i;
            } else if(empty($purpose_of_loan[$i]) && $i > 0 && !empty($loan_terms_payment[$i])) {
                $run_sql_loans_availed->bind_param('isssssss' ,$prof_id,$purpose_of_loan[$loan_flag],$loan_amount[$i],
                $loan_source[$i],$loan_date_released[$i],$loan_date_availed[$i], $loan_terms_payment[$i], $loan_amount_paid[$i]);
                $run_sql_loans_availed->execute();
            }
        }

        $sql_trainings_attdel = 'DELETE FROM arbo_org_trainings_attended WHERE arbo_profile_id = ?';
        $run_sql_trainings_attdel = $conn->prepare($sql_trainings_attdel);
        $run_sql_trainings_attdel->bind_param('i',$prof_id);
        $run_sql_trainings_attdel->execute();

        $sql_trainings_att = 'INSERT INTO arbo_org_trainings_attended
                (arbo_profile_id, title, date_conducted, conducted_by, no_of_pax_officers, no_of_pax_members)
                values (?,?,?,?,?,?)';
        
        for ($i = 0; $i < count($train_title); $i++) {
            $run_sql_trainings_att = $conn->prepare($sql_trainings_att);
            if(empty($conducted_by[$i])) {
                $conducted_by_ = '';
            } else {
                $conducted_by_ = $conducted_by[$i];
            }
            if(!empty($train_title[$i])) {
                $run_sql_trainings_att->bind_param('isssii', $prof_id, $train_title[$i], $date_conduct[$i], $conducted_by_, $officers[$i], $p3_members[$i]);
                $run_sql_trainings_att->execute();
            }
        }
        


        $sql_off_n_boddel = 'DELETE FROM arbo_officers_n_bod WHERE arbo_profile_id = ?';
        $run_sql_off_n_boddel = $conn->prepare($sql_off_n_boddel);
        $run_sql_off_n_boddel->bind_param('i',$prof_id);
        $run_sql_off_n_boddel->execute();

        $sql_off_n_bod = 'INSERT INTO arbo_officers_n_bod(arbo_profile_id, arbo_mem_id, arbo_position_type_id ) values (?,?,?)';
        $run_sql_off_n_bod = $conn->prepare($sql_off_n_bod);
        for ($i = 0; $i < count($off_bod_fname); $i++) {
            $offcrs_and_bod_position_ = checkAssocPosition($offcrs_and_bod_position[$i]);
            if($offcrs_and_bod_position_ == 0) {
                insertAssocPosition($offcrs_and_bod_position[$i]);
                $offcrs_and_bod_position_ = checkAssocPosition($assoc_position_1);
            }
            $off_bod_id = checkMember($off_bod_fname[$i], $off_bod_lname[$i], $off_bod_mname[$i]);
            if($off_bod_id == 0) {
                insertMember($off_bod_fname[$i], $off_bod_lname[$i], $off_bod_mname[$i]);
                $off_bod_id = checkMember($off_bod_fname[$i], $off_bod_lname[$i], $off_bod_mname[$i]);
            }
            $run_sql_off_n_bod->bind_param('iii', $prof_id, $off_bod_id, $offcrs_and_bod_position_);
            $run_sql_off_n_bod->execute();
        }

        $sql_comnmem_del = 'DELETE FROM arbo_committee_n_member WHERE arbo_profile_id = ?';
        $run_sql_comnmem_del = $conn->prepare($sql_comnmem_del);
        $run_sql_comnmem_del->bind_param('i',$prof_id);
        $run_sql_comnmem_del->execute();

        $committee_type = isset($_POST['committee_type']) ? $_POST['committee_type'] : array();
        
        $sql_com_n_mem = 'INSERT INTO arbo_committee_n_member
            (arbo_profile_id,arbo_mem_id,arbo_committee_type_id,arbo_committee_position_id) 
            values (?,?,?,?)';
        
        $com_where = isset($_POST['committee_where']) ? $_POST['committee_where'] : array() ;
        $cw_lngth = count($com_where);
        $com_basis = isset($_POST['comm_basis']) ? $_POST['comm_basis'] : array();
        $cb_lngth = count($com_basis);

        foreach($com_where as &$item) {
            $item = preg_replace('/\D/', '', $item);
        }

        for($i = 0; $i < (count($committee_type) - $cw_lngth); $i++) {
            for($j = 0 ; $j < count($_POST['com_mem_mname'.$com_basis[$i]]) ; $j++) {
                $comm_mem_mname = !empty($_POST['com_mem_mname'.$com_basis[$i]]) ? $_POST['com_mem_mname'.$com_basis[$i]] : ' ';
                $comm_mem_lname = $_POST['com_mem_lname'.$com_basis[$i]];
                $comm_mem_fname = $_POST['com_mem_fname'.$com_basis[$i]];
    
                $committee_position = $_POST['committee_pos'.$com_basis[$i]];
                if($committee_position[$j]  == 'CHAIRPERSON') {
                    $committee_position[$j] = 1;
                } else if($committee_position[$j]  == 'MEMBER' ) {
                    $committee_position[$j] = 2;
                } else {
                    $committee_position[$j] = 2;
                }

                $comm_mem_id = checkMember($comm_mem_fname[$j], $comm_mem_lname[$j], $comm_mem_mname[$j]);
                if($comm_mem_id < 1) {
                    insertMember($comm_mem_fname[$j],$comm_mem_lname[$j], $comm_mem_mname[$j]);
                    $comm_mem_id = checkMember($comm_mem_fname[$j], $comm_mem_lname[$j], $comm_mem_mname[$j]);
                }
                $committee_id = checkCommittee($committee_type[$i]);
                if($committee_id < 1) {
                    insertCommittee($committee_type[$i]);
                    $committee_id = checkCommittee($committee_type[$i]);
                }
                
                $sql_sql_com_n_mem = $conn->prepare($sql_com_n_mem);
                $sql_sql_com_n_mem->bind_param('iiii' ,  $prof_id, $comm_mem_id, $committee_id, $committee_position[$j]);
                $sql_sql_com_n_mem->execute();
            }
        }
        
        $cw = 0;
        for($i = ($cb_lngth) ; $i < count($committee_type); $i++) {

            for($j = 0 ; $j < count($_POST['com_mem_fname'.$com_where[$cw]]) ; $j++) {
                $comm_mem_mname = !empty($_POST['com_mem_mname'.$com_where[$cw]]) ? $_POST['com_mem_mname'.$com_where[$cw]] : ' ';
                $comm_mem_lname = $_POST['com_mem_lname'.$com_where[$cw]];
                $comm_mem_fname = $_POST['com_mem_fname'.$com_where[$cw]];
    
                $committee_position = $_POST['committee_pos'.$com_where[$cw]];
                $comm_mem_id = checkMember($comm_mem_fname[$j], $comm_mem_lname[$j], $comm_mem_mname[$j]);
                if($comm_mem_id < 1) {
                    insertMember($comm_mem_fname[$j],$comm_mem_lname[$j], $comm_mem_mname[$j]);
                    $comm_mem_id = checkMember($comm_mem_fname[$j], $comm_mem_lname[$j], $comm_mem_mname[$j]);
                }
                $committee_id = checkCommittee($committee_type[$i]);
                if($committee_id < 1) {
                    insertCommittee($committee_type[$i]);
                    $committee_id = checkCommittee($committee_type[$i]);
                }

                $sql_sql_com_n_mem = $conn->prepare($sql_com_n_mem);
                $sql_sql_com_n_mem->bind_param('iiii' ,  $prof_id, $comm_mem_id, $committee_id, $committee_position[$j]);
                $sql_sql_com_n_mem->execute();
            }
            $cw++;
        }


        $sql_ntrvntions_del = 'DELETE FROM arbo_acquired_intervention WHERE arbo_profile_id = ?';
            $run_sql_ntrvntions_del = $conn->prepare($sql_ntrvntions_del);
            $run_sql_ntrvntions_del->bind_param('i' , $prof_id);
            $run_sql_ntrvntions_del->execute();
    
            $intervention_qid = [95,96,97,98,79];
            $sql_ntrvntions = 'INSERT INTO arbo_acquired_intervention (arbo_profile_id, main_id, sub_id) values (?,?,?)';
            $run_sql_ntrvntions = $conn->prepare($sql_ntrvntions);
            for ($i = 0; $i < count($q79); $i++) {
                $run_sql_ntrvntions->bind_param('iii', $prof_id, $intervention_qid[4], $q79[$i]);
                $run_sql_ntrvntions->execute();
            }
            for ($i = 0; $i < count($q95); $i++) {
                $run_sql_ntrvntions->bind_param('iii', $prof_id, $intervention_qid[0], $q95[$i]);
                $run_sql_ntrvntions->execute();
            }
    
            for ($i = 0; $i < count($q96); $i++) {
                $run_sql_ntrvntions->bind_param('iii', $prof_id, $intervention_qid[1], $q96[$i]);
                $run_sql_ntrvntions->execute();
            }
    
            for ($i = 0; $i < count($q97); $i++) {
                $run_sql_ntrvntions->bind_param('iii', $prof_id, $intervention_qid[2], $q97[$i]);
                $run_sql_ntrvntions->execute();
            }

            $sql_ntrvntions = 'INSERT INTO arbo_acquired_intervention (arbo_profile_id, main_id, sub_id) values (?,?,?)';
            $insert_arbo_inter = $conn->prepare('INSERT INTO arbo_acquired_intervention (arbo_profile_id, sub_id , specify_intervention, main_id)
            values (?,?,?,?)');
    
            for($i = 0 ; $i < count($q98_spec); $i++) {
                $insert_arbo_inter->bind_param('iisi' , $prof_id , $q98[$i] , $q98_spec[$i], $intervention_qid[3]);
                $insert_arbo_inter->execute();
            }

            $sql_assoc_memdel = 'DELETE FROM arbo_association_members WHERE arbo_profile_id = ?';
            $run_sql_assoc_memdel = $conn->prepare($sql_assoc_memdel);
            $run_sql_assoc_memdel->bind_param('i' , $prof_id);
            $run_sql_assoc_memdel->execute();
    
            $sql_assoc_member = 'INSERT INTO arbo_association_members
                (ARBO_PROFILE_ID, arbo_mem_id, ARBO_POSITION_TYPE_ID,
                SEX, ARBO_ARB_TYPE_ID, ARBO_STATUS_ID, CLOA_NO,land_size, assoc_crop, CBU, monthly_due, 
                PRODUCTION ,MARKETING, CREDIT, PHF, MICRO_ENT ,SERVICE, OTHERS, trainings_attended)
                VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)';
            $run_sql_assoc_member = $conn->prepare($sql_assoc_member);
                for($i = 0; $i < count($assoc_firstname); $i++) {

                    if(!empty($assoc_firstname[$i]) || !empty($assoc_lastname[$i])) {
                        $assoc_mi_ = isset($assoc_mi[$i]) ? $assoc_mi[$i] : '';
                        $assoc_position_1 = isset($assoc_position[$i]) ? $assoc_position[$i] : 14;
                        $assoc_gender_ = isset($assoc_gender[$i]) ? $assoc_gender[$i] : 1;
                        $assoc_arb_type_ = isset($assoc_arb_type[$i]) ? $assoc_arb_type[$i] : 1;
                        $assoc_status_ = isset($assoc_status[$i]) ? $assoc_status[$i] : 1;
                        $assoc_position_ = checkAssocPosition($assoc_position_1);
                        if($assoc_position_ == 0) {
                            insertAssocPosition($assoc_position_1);
                            $assoc_position_ = checkAssocPosition($assoc_position_1);
                        }
                        $assoc_crop_ = isset($assoc_crop[$i]) ? $assoc_crop[$i] : '';
                    
                        $assoc_cbu_ = isset($assoc_cbu[$i]) ? $assoc_cbu[$i] : 0;
                        $assoc_saving_ = isset($assoc_saving[$i]) ? $assoc_saving[$i] : ' ';
                        $assoc_production_ = isset($assoc_production[$i]) ? $assoc_production[$i] : 0;
                        $assoc_mrktng_ = isset($assoc_mrktng[$i]) ? $assoc_mrktng[$i] : 0;
                        $assoc_credit_ = isset($assoc_credit[$i]) ? $assoc_credit[$i] : 0;
                        $assoc_phf_ = isset($assoc_phf[$i]) ? $assoc_phf[$i] : 0;
                        $assoc_micro_ = isset($assoc_micro[$i]) ? $assoc_micro[$i] : 0;
                        $assoc_srvce_ = isset($assoc_srvce[$i]) ? $assoc_srvce[$i] : 0;
                        $assoc_others_ = isset($assoc_others[$i]) ? $assoc_others[$i] : 0;
                        $assoc_train_attended_ = isset($assoc_train_attended[$i])? $assoc_train_attended[$i] : '';


                        $assoc_mem_id = checkMember($assoc_firstname[$i] , $assoc_lastname[$i] , $assoc_mi_);
                        if($assoc_mem_id == 0) {
                            insertMember($assoc_firstname[$i] , $assoc_lastname[$i] , $assoc_mi_);
                            $assoc_mem_id = checkMember($assoc_firstname[$i] , $assoc_lastname[$i] , $assoc_mi_);
                        }
                        $run_sql_assoc_member->bind_param('iiisiisssissiiiiiis' ,
                            $prof_id, $assoc_mem_id ,
                            $assoc_position_ , $assoc_gender_ , $assoc_arb_type_ ,
                            $assoc_status_, $assoc_cloa_number[$i],$assoc_landsize[$i],$assoc_crop_, $assoc_cbu_,  $assoc_saving_, 
                            $assoc_production_, $assoc_mrktng_, $assoc_credit_,
                            $assoc_phf_, $assoc_micro_, $assoc_srvce_,
                            $assoc_others_, $assoc_train_attended_);
                        $run_sql_assoc_member->execute();
                    }
                }
        echo '<script>alert("Updated!");
                    window.location.href="../po_profile_update.php?id='.$prof_id.'";    
            </script>';
            
// }
} else {
    echo "<script>alert('Failed to Update!');
            window.location.href = '../update-profile.php';
        </script>";
}

function getInterventionId($description) {
    require 'connection.php';
    $sql = $conn->prepare('SELECT id from arbo_specify_intervention where description = ?');
    $sql->bind_param('i' , $description);
    $sql->execute();
    $sql->bind_result($id);
    $sql->store_result();
    $sql->fetch();
    if($id > 0) {
        return $id;
    } else {
        insertIntervention($description);
    }
    $sql->close();
}

function insertIntervention($description) {
    require 'connection.php';
    $sql = $conn->prepare('INSERT INTO arbo_specify_intervention (description,sub_id) values (?,?)');
    $sql->bind_param('si' , $description, $q98);
    if($sql->execute()){
        getInterventionId($description);
    }
    $sql->close();
}

function checkMember($fname,$lname,$middle) {
    require 'connection.php';
    $fname = ucwords($fname);
    $lname = ucwords($lname);
    $middle = ucwords($middle);
    
    $sql = 'SELECT hhold_id FROM part1_arb_household where fn_arb = ? and ln_arb = ? and mn_arb = ?';
    $sql_run = $conn->prepare($sql);
    $sql_run->bind_param('sss' , $fname, $lname , $middle);
    $sql_run->execute();
    $sql_run->bind_result($id);
    $sql_run->store_result();
    $sql_run->fetch();
    if($id > 0) {
        return $id;
    } else {
        return 0;
    }
}

function insertMember($fname,$lname,$middle) {
    require 'connection.php';
    $fname = ucwords($fname);
    $lname = ucwords($lname);
    $middle = ucwords($middle);
    $inventory_flag = 0;
    $sql = 'INSERT INTO part1_arb_household (fn_arb, ln_arb, mn_arb,inventory_flag) values (?,?,?,?) ';
    $sql_run = $conn->prepare($sql);
    $sql_run->bind_param('sssi' , $fname, $lname , $middle, $inventory_flag);
    $sql_run->execute();
}
function checkCommittee($committee) {
    require 'connection.php';
    $sql_committee = 'SELECT id FROM arbo_committee_type where description = ?';
    $run_sql_committee = $conn->prepare($sql_committee);
    $run_sql_committee->bind_param('s' , $committee);
    $run_sql_committee->execute();
    $run_sql_committee->bind_result($id);
    $run_sql_committee->store_result();
    $run_sql_committee->num_rows();
    $run_sql_committee->fetch();
    if($id > 0) {
        return $id;
    } else {
        return 0;
    }
}
function insertCommittee($committee) {
    require 'connection.php';
    $sql_insert_committee = 'INSERT INTO arbo_committee_type (description) values (?) ';
    $run_sql_insert_committee = $conn->prepare($sql_insert_committee);
    $run_sql_insert_committee->bind_param('s' , $committee);
    $run_sql_insert_committee->execute();
}

//check

function checkAssocPosition($data) {
    require 'connection.php';
    $data = strtoupper($data);
    $sql = 'SELECT id FROM arbo_position_type where description = ?';
    $sql = $conn->prepare($sql);
    $sql->bind_param('s' , $data);
    $sql->execute();
    $sql->bind_result($id);
    $sql->store_result();
    $sql->num_rows();
    $sql->fetch();
    if($id > 0) {
        return $id;
    } else {
        if($data == '' || empty($data) || $data == null) {
            return 14;
        } else {
            return 0;
        }
    }
}
function insertAssocPosition($data) {
    require 'connection.php';
    $sql = 'INSERT INTO arbo_position_type (description) values (?) ';
    $sql = $conn->prepare($sql);
    $sql->bind_param('s' , $data);
    $sql->execute();
}

function check_srvcs($desc) {
    require 'connection.php';
    $sql = 'SELECT id FROM arbo_service_sub WHERE description = ?';
    $run_sql = $conn->prepare($sql);
    $run_sql->bind_param('s' , $desc);
    $run_sql->execute();
    $run_sql->bind_result($id);
    $run_sql->store_result();
    $run_sql->num_rows();
    $run_sql->fetch();
    if($id > 0) {
        return $id;
    } else {
        return 0;
    }
}
function insert_srvcs($desc,$id) {
    require 'connection.php';
    $sql = 'INSERT INTO arbo_service_sub (description,arbo_service_main_id) VALUES (?,?)';
    $run_sql = $conn->prepare($sql);
    $run_sql->bind_param('si', $desc,$id);
    $run_sql->execute();
}


?>