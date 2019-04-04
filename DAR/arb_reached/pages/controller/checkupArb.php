<?php
session_start();
require 'connectdb.php';


$lname = isset($_POST['lname']) ? $_POST['lname'] : '';
$fname = isset($_POST['fname']) ? $_POST['fname'] : '';
$mname = isset($_POST['mname']) ? $_POST['mname'] : '';
if (!empty($fname) && !empty($lname)) {
	$sql = $conn->prepare('SELECT id FROM arb_information where lname = ? and fname = ? and mi = ?');
	$sql->bind_param('sss',$lname,$fname,$mname);
	$sql->execute();
	$sql->bind_result($id);
	$sql->store_result();
	if ($sql->num_rows() > 0) {
		echo 'false'; // id already taken
	} else {
		echo 'true'; 
	}
}


if (!empty($fname) && !empty($lname)) {
	
	$username = $_POST['username'];
	$user_id = $_SESSION['id'];
	$sql = $conn->prepare("SELECT username FROM users where id=?");
	$sql->bind_param('s',$user_id);
	$sql->execute();
	$sql->bind_result($uname);
	$sql->store_result();
	if ($sql->num_rows() > 0) {
		while($sql->fetch()){
			if($uname == $username){
				echo 'true';
			} else {
				$sql1 = $conn->prepare("SELECT username FROM users where username=?");
				$sql1->bind_param('s',$username);
				$sql1->execute();
				$sql1->bind_result($uname1);
				$sql1->store_result();
				if($sql1->num_rows() > 0){
					echo 'false';
				} else {
					echo 'true';
				}

			}
		}
	}
}
?>