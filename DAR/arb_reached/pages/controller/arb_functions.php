<?php
function insertArbo($arbo) {
    require 'connectdb.php';
    $arbo = ucfirst($arbo);
    $sql = 'INSERT INTO arb_org (arbo_name) VALUES (?)';
    $sql = $conn->prepare($sql);
    $sql->bind_param('s',$arbo);
    $sql->execute();
}

function checkArbo($arbo) {
    require 'connectdb.php';
    ucwords($arbo);
    $sql = 'SELECT id from arb_org where arbo_name = ? LIMIT 1';
    $sql = $conn->prepare($sql);
    $sql->bind_param('s', $arbo);
    $sql->execute();
    $sql->bind_result($id);
    $sql->store_result();
    if ($sql->num_rows() > 0) {
        while ($sql->fetch()) {
            return $id;
        }
    } else {
        return 0;
    }
}

function get_arb_id($lname,$fname,$mi) {
    require 'connectdb.php';
    $lname = ucwords($lname);
    $fname = ucwords($fname);
    $mi = ucwords($mi);
    $sql = 'SELECT id from arb_information where lname = ? and fname = ? and mi = ?';
    $sql = $conn->prepare($sql);
    $sql->bind_param('sss', $lname,$fname,$mi);
    $sql->execute();
    $sql->bind_result($id);
    $sql->store_result();
    if ($sql->num_rows() > 0) {
        while ($sql->fetch()) {
            return $id;
        }
    } else {
        return 0;
    }
}

function check_position($desc) {
    require 'connectdb.php';
    $desc = $desc;
    $sql = 'SELECT id from arbo_position_type where description = ?';
    $sql = $conn->prepare($sql);
    $sql->bind_param('s', $desc);
    $sql->execute();
    $sql->bind_result($id);
    $sql->store_result();
    if ($sql->num_rows() > 0) {
        while ($sql->fetch()) {
            return $id;
        }
    } else {
        return 0;
    }

}

function insert_pos($desc) {
    require 'connectdb.php';
    $desc = $desc;
    $sql = 'INSERT INTO arbo_position_type (description) VALUES (?)';
    $sql = $conn->prepare($sql);
    $sql->bind_param('s',$desc);
    $sql->execute();
}

function sanitize($data){
    require 'connectdb.php';
	$data = trim($data);
	$data = stripslashes($data);
	mysqli_real_escape_string($conn,$data);
	return $data;
}

function sanitizeArr(Array $data) {
    require 'connectdb.php';
    $data = array_map("trim", $data);
    $data = array_map("stripslashes", $data);
	return $data;
}

function convToInt($data) {
    $valid_char = array('.','0','1','2','3','4','5','6','7','8','9');
    $charac = str_split($data);
    $return_charac = '';
    for($i = 0 ; $i < count($charac); $i++) {
        if(in_array($charac[$i], $valid_char)) {
            $return_charac.=$charac[$i];
        }
    }
    return $return_charac;
}
?>