<?php
require 'connectdb.php';

if(isset($_POST['update'])) {

	$id = isset($_POST['user_id']) ? $_POST['user_id'] : 0 ;
    $first_name = isset($_POST['first_name']) ? sanitize($_POST['first_name']) : '';
    $middle_name = isset($_POST['middle_name']) ? sanitize($_POST['middle_name']) : '';
    $last_name = isset($_POST['last_name']) ? sanitize($_POST['last_name']) : '';

    $email = isset($_POST['email']) ? sanitize($_POST['email']) : '';
    $phone = isset($_POST['phone']) ? sanitize($_POST['phone']) : '';

    $username = isset($_POST['username']) ? sanitize($_POST['username']) : '';
    $password= isset($_POST['cpassword']) ? sanitize($_POST['cpassword']) : '';
    $curr_password = isset($_POST['curr_password']) ? sanitize($_POST['curr_password']) : '';

    $position = isset($_POST['position']) ? sanitize($_POST['position']): '';
    $city = isset($_POST['city']) ? sanitize($_POST['city']) : '';
    $brgy = isset($_POST['brgy']) ? sanitize($_POST['brgy']) : '';

    $hashed_pass = password_hash($password, PASSWORD_DEFAULT);
    $profile_pic_path = '';

        $sql = 'SELECT password from users where username = ?';
        $sql = $conn->prepare($sql);
        $sql->bind_param('s', $username);
        $sql->execute();
        $sql->bind_result($dbhashed_pass);
        $sql->store_result();
        $sql->num_rows();
        $sql->fetch();
        $verify = password_verify($dbhashed_pass,$pass);

        if($verify) {
            $sql = 'UPDATE users SET password = ? WHERE username = ?';
            $sql = $conn->prepare($sql);
            $sql->bind_param('ss', $username, $password);
            if($sql->execute()) {
                $user_stat = 1;
                $role_id = 2;
                $pid = 1;

                $sql = 'UPDATE users SET username = ? , firstname = ?, lastname = ?,
                        middlename = ?, email = ?, phoneno = ?, pid = ?, cid = ?, bid = ?, user_position_id = ?,
                        user_stat_id = ?, role_id = ? WHERE id = ?';
                $sql = $conn->prepare($sql);
                $sql->bind_param('ssssssiiiiiii', $username, $first_name, $last_name,  $middle_name, 
                                    $email, $phone, $pid, $city,$brgy ,$position, $user_stat ,$role_id, $id );
                if($sql->execute()) {
                    echo 0;
                } else {
                    echo 1;
                }
                if(!empty($_FILES['profile_picture'])) {

                    $path = "../../../public/profile/";
                    $profile_pic_path =  $path . date("Ymdhis").'_'.basename( $_FILES['profile_picture']['name']);
                    move_uploaded_file($_FILES['profile_picture']['tmp_name'], $profile_pic_path);
                    $profile_pic_path = substr($profile_pic_path, 3);

                    $sql = 'UPDATE users set profile_pic = ? WHERE id = ?';
                    $sql = $conn->prepare($sql);
                    $sql = $conn->bind_param('si', $profile_pic_path, $id);
                    $sql->execute();

                } else {
                    $profile_pic_path = '';
                }

                echo "<script>alert('Updated Successfully!');
                        window.location.href = '../update-profile.php';
                    </script>";

            }
        } else {
            echo "<script>alert('Failed to Update!');
                        window.location.href = '../update-profile.php';
                    </script>";
        }
} else {
    echo "<script>alert('Failed to Update!');
            window.location.href = '../update-profile.php';
        </script>";
}

function sanitize($data) {
    $data = htmlspecialchars($data);
    $data = rtrim($data);
    $data = trim($data);
    $data = stripslashes($data);
    return $data;
}

function checkimgext($image) {
	$img_arr = explode('.' , $image);
	$valid_ext = array('jpeg' ,'jfif' ,'jpg' ,'jpe' , 'pns' , 'png');
	$index = count($img_arr) - 1;
	if(isset($img_arr[$index])) {
		if(in_array($img_arr[$index] , $valid_ext)) {
			return 1;
		} else {
			return 0;
		}
	}
}