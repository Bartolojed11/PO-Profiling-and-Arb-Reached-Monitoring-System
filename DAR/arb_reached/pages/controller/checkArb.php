<?php

require 'connectdb.php';
$lname = isset($_POST['lname']) ? $_POST['lname'] : '';
$fname = isset($_POST['fname']) ? $_POST['fname'] : '';
$mname = isset($_POST['mname']) ? $_POST['mname'] : '';
$id = isset($_POST['arb_id']) ? $_POST['arb_id'] : 0;
if (!empty($fname) && !empty($lname)) {
	$sql = $conn->prepare('SELECT id FROM arb_information where lname = ? and fname = ? and mi = ? and id != ? LIMIT 1');
	$sql->bind_param('sssi',$lname,$fname,$mname, $id);
	$sql->execute();
	$sql->bind_result($id);
	$sql->store_result();
	$sql->num_rows();
	$sql->fetch();
	if($id > 0 || !empty($id)) {
		echo 'false'; // id already taken
	} else {
		echo 'true'; 
	}
}
?>