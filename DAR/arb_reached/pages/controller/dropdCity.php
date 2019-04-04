<?php
	require_once 'connectdb.php';

	$pid = (isset($_REQUEST['pid'])) ? $_REQUEST['pid']: '';
	$province = (isset($_REQUEST['province'])) ? $_REQUEST['province'].'%' : '';
	if($pid > 0){
		$sql = $conn->prepare('SELECT city,cid from tbl_city where pid=?');
		$sql->bind_param('i',$pid);
	} else {
		$sql1 = $conn->prepare('SELECT pid from tbl_prov where province LIKE ?');
		$sql1->bind_param('s',$province);
		$sql1->execute();
		$sql1->bind_result($pid);
		$sql1->store_result();
		$sql1->num_rows();
		$sql1->fetch();
		
		$sql = $conn->prepare('SELECT city,cid from tbl_city where pid=?');
		$sql->bind_param('i',$pid);
	}

	$sql->execute();
	$sql->bind_result($city,$cid);
	$sql->store_result();
	if($sql->num_rows() > 0){
		while($sql->fetch()){
			echo '<li onclick="ashowcity(this.value)" value='.$cid.'><a>'.$city.'</a></li>';
		}
	}
	$conn->close();
?>