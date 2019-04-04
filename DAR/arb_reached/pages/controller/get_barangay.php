<?php
	require_once 'connectdb.php';
	
	$cid = (isset($_REQUEST['cid'])) ? $_REQUEST['cid'] : '';
	$city = (isset($_REQUEST['city']) ? $_REQUEST['city'].'%' : '');
	if($cid > 0){
		$sql = $conn->prepare('SELECT brgy,bid from tbl_brgy where cid=?');
		$sql->bind_param('i',$cid);
	} else {
		$sql1 = $conn->prepare('SELECT cid from tbl_city where city Like ?');
		$sql1->bind_param('s',$city);
		$sql1->execute();
		$sql1->bind_result($cid);
		$sql1->store_result();
		$sql1->num_rows();
		$sql1->fetch();

		$sql = $conn->prepare('SELECT brgy,bid from tbl_brgy where cid=?');
		$sql->bind_param('i',$cid);
	}

	$sql->execute();
	$sql->bind_result($brgy,$bid);
	$sql->store_result();
	if($sql->num_rows() > 0){
		while($sql->fetch()){
			echo '<li onclick="showbrgy(this.value)" value='.$bid.'><a>'.$brgy.'</a></li>	';
		}
	}
	echo '<li onclick="showbrgy(this.value)" value="0"><a>(Other)Please Specify</a></li>';
	$conn->close();
?>