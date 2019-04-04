<?php
	require 'connection.php';
	
	$response = array();

	if (isset($_POST['save'])) {
			$first_name = ucfirst($_POST['first_name']);
			$middle_name = ucfirst($_POST['middle_name']);
			$last_name = ucfirst($_POST['last_name']);
			$email = $_POST['email'];
			$phone = $_POST['phone'];
			$province = $_POST['province'];
			$city = $_POST['city'];
			$brgy = $_POST['barangay'];
			$other = $_POST['other_addr'];
			
			$username = $_POST['username'];
			$password = isset($_POST['cpassword']) ? $_POST['cpassword'] : '';
	
			$gpid = checkAddr($conn,$province,'prov');
			if($gpid > 0){
				$gcid = checkAddr($conn,$city,'city');
				$gbid = checkAddr($conn,$brgy,'brgy');
				$goid = checkAddr($conn,$other,'other');
				if($gcid == 0 || $gcid == ''){
					insertAddr($conn,$city,$gpid,'city'); 
					$gcid = checkAddr($conn,$city,'city');
					insertAddr($conn,$brgy,$gcid,'brgy');
					$gbid = checkAddr($conn,$brgy,'brgy');
					insertAddr($conn,$other,$gbid,'other');
					$goid = checkAddr($conn,$other,'other');
				} else if ($gbid < 1){
					insertAddr($conn,$brgy,$gcid,'brgy');
					$gbid = checkAddr($conn,$brgy,'brgy');
					insertAddr($conn,$other,$gbid,'other');
					$goid = checkAddr($conn,$other,'other');
				} else if ($goid < 1){
					insertAddr($conn,$other,$gbid,'other');
					$goid = checkAddr($conn,$other,'other');
				}
			}
			
			// bcrypt password hashing
			$hashed_password = password_hash($password , PASSWORD_DEFAULT);
			$uid = check($conn,$username,$first_name,$last_name,$middle_name,'details');
			$statement = $conn->prepare('UPDATE tbl_userdetails SET firstname=?,lastname=?,middlename=?,email=?,phoneno=?,pid=?,cid=?,bid=?,o_id=? WHERE user_id=?');
			$statement->bind_param('sssssiiiii',$first_name,$last_name,$middle_name,$email,$phone,$gpid,$gcid,$gbid,$goid,$uid);
			$statement->execute();
			
			if ($uid > 0) {
				$stat = 1;
				$role = 2;
				$user_type = 1;
				$sql = $conn->prepare('UPDATE d_tbl_user SET user_id=?,username=?,user_type_id=?');
				$sql->bind_param('isi',$uid,$username,$user_type);

				if(!empty($password)){
					$sql_ = $conn->prepare('UPDATE d_tbl_user SET password=? where user_id=?');
					$sql_->bind_param('si',$hashed_password , $uid);
					$sql_->execute();
				}
				if(isset($_FILES['profile_pic'])) {
				  $path = "profile/";
				  $path = $path . basename( $_FILES['profile_pic']['name']);
				  if(move_uploaded_file($_FILES['profile_pic']['tmp_name'], $path)) {
					$sql_1 = $conn->prepare('UPDATE tbl_userdetails SET profile_pic=? where user_id=?');
					$sql_1->bind_param('si', $path, $uid);
					$sql_1->execute();
				}
			}
				echo '<script>alert("Profile updated successfully!");
					window.location.href="profile.php";
				</script>';
			} else {
				echo '<script>alert("Registration Failed!2")</script>';

			}
		}


	
	function check($conn,$username,$first_name,$last_name,$middle_name,$tbl){
		if($tbl == 'user'){
			$sql = $conn->prepare('SELECT user_id from d_tbl_user where username=?');
			$sql->bind_param('s',$username);
		} else if($tbl == 'details'){
			$sql = $conn->prepare('SELECT user_id from tbl_userdetails where firstname=? and lastname=? and middlename=?');
			$sql->bind_param('sss',$first_name,$last_name,$middle_name);
		}
		$sql->execute();
		$sql->bind_result($user_id);
		$sql->store_result();
		if($sql->num_rows() > 0){
			while($sql->fetch()){
				return $user_id;
			}
		} else {
			return 0;
		}
	}
	

	function checkAddr($conn,$data,$tbl){
		if($tbl == 'prov'){
			$sql = $conn->prepare('SELECT pid,province FROM tbl_prov where province = ?');
		} else if ($tbl == 'city'){
			$sql = $conn->prepare('SELECT cid,city FROM tbl_city where city = ?');
		} else if($tbl == 'brgy'){
			$sql = $conn->prepare('SELECT bid,brgy FROM tbl_brgy where brgy = ?');
		} else if($tbl == 'other'){
			$sql = $conn->prepare('SELECT o_id,other FROM tbl_other_addr where other = ?');
		}
		$sql->bind_param('s',$data);
		$sql->execute();
		$sql->bind_result($id,$res);
		$sql->store_result();
		$sql->num_rows();
		$sql->fetch();
		return $id;
	}
	function insertAddr($conn,$data,$id,$tbl){
			if($tbl == 'city'){
				$sql = $conn->prepare('INSERT INTO tbl_city (city,pid) values (?,?)');
			} else if($tbl == 'brgy'){
				$sql = $conn->prepare('INSERT INTO tbl_brgy (brgy,cid) values (?,?)');
			} else if($tbl == 'other'){
				$sql = $conn->prepare('INSERT INTO tbl_other_addr (other,bid) values (?,?)');
			}
			$sql->bind_param('si',$data,$id);
			$sql->execute();
	}