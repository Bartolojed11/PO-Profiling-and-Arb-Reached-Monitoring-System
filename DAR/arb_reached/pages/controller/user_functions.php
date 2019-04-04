<?php

function logIn($username,$password,$conn) {
    $role = '';
    $stat = 1;
        $sql = 'SELECT user.id, user.username, user.password, user.user_position_id, pos.description, user.profile_pic
                FROM users as user
                inner join user_position as pos on pos.id = user.user_position_id
                WHERE pos.id = user.user_position_id and user.username=? and user.user_stat_id = ? LIMIT 1';
        $sql_run = $conn->prepare($sql);
        $sql_run->bind_param('si',$username , $stat);
        $sql_run->execute();
        $sql_run->bind_result($id, $uname , $pass, $role_id, $user_position,$profile_pic);
        $sql_run->store_result();

        if($sql_run->num_rows()){
            $sql_run->fetch();
                $hashed = password_verify($password,$pass);
                if($hashed) {
                    session_start();
                    $ssid = session_create_id();
                    if (!checkSession($id, $ssid,$conn)) {
                        while(!checkSession($id, $ssid,$conn)) {
                            $ssid = session_create_id();
                        }
                    }
                    if($role_id == 2 || $role_id == 3 || $role_id == 4 || $role_id == 5 || $role_id == 1) {
                        if(insertThisSession($ssid, $id, $username, $user_position, $profile_pic, $conn)) {
                            return true;
                        } else {
                            return false;
                        }
                    } else {
                        return false;
                    }

                } else {
                    return false;
            }
        } else {
            return false;
    }
}

function checkSession($user_id, $session, $conn) {
    $sql = 'SELECT user_id from user_sessions where user_id != ? and session_id = ? LIMIT 1';
    $sql = $conn->prepare($sql);
    $sql->bind_param('is' , $user_id, $session);
    $sql->execute();
    $sql->bind_result($id);
    $sql->store_result();

    if($sql->num_rows() == 1){
        //session already existed
        return false;
    } else {
        return true;
    }
}

function insertThisSession($session_id, $user_id, $username, $role, $profile_picture, $conn) {
    $sql = 'INSERT INTO user_sessions (session_id, user_id, username, role, profile_picture) VALUES(?,?,?,?,?)';
    $sql = $conn->prepare($sql);
    $sql->bind_param('sisss' , $session_id, $user_id, $username, $role, $profile_picture);
    if($sql->execute()) {
        $_SESSION['ssid'] = $session_id ;
        $_SESSION['user_id'] = $user_id ;
        $_SESSION['username'] = $username ;
        $_SESSION['role'] = $role ;
        $_SESSION['profile_picture'] = $profile_picture ;

        setcookie('ssid', $session_id, time() + (86400 * 7), "/arb_reached/" , "dar-south.org" , 0); // 86400 = 1 day
        setcookie('user_id', $user_id, time() + (86400 * 7), "/arb_reached/" , "dar-south.org" , 0); 
        setcookie('username', $username, time() + (86400 * 7), "/arb_reached/" , "dar-south.org" , 0); 
        setcookie('role', $role, time() + (86400 * 7), "/arb_reached/" , "dar-south.org" , 0); 
        setcookie('profile_picture', $profile_picture, time() + (86400 * 7), "/arb_reached/" , "dar-south.org" , 0);
        return true;
    } else {
        return false;
    }
}

function authUser($username, $session, $conn) {
    $valid_pos = array('ARPO I','PARPO II', 'PARPO I', 'CARPO', 'SARPO');
    if(isset($_COOKIE['ssid']) && isset($_COOKIE['user_id']) && isset($_COOKIE['username'])
        && isset($_COOKIE['role']) && isset($_COOKIE['profile_picture'])) {
        $sql = 'SELECT user_id from user_sessions where username = ? and session_id = ? LIMIT 1';
        $sql = $conn->prepare($sql);
        $sql->bind_param('ss' , $username, $session);
        $sql->execute();
        $sql->bind_result($id);
        $sql->store_result();

        //check if user exist
        if($sql->num_rows()){
            $sql->fetch();
            if(in_array($_COOKIE['role'], $valid_pos)) {
                $_SESSION['ssid'] =$_COOKIE['ssid'];
                $_SESSION['user_id'] = $_COOKIE['user_id'];
                $_SESSION['username'] = $_COOKIE['username'] ;
                $_SESSION['role'] = $_COOKIE['role'] ;
                $_SESSION['profile_picture'] = $_COOKIE['profile_picture'] ;
                //check if the users session does not exceed 7 days
                if(checkSessionValidity($conn,$id)) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}

function logOut($username, $session, $conn) {
    $sql = 'DELETE from user_sessions where username = ? and session_id = ? LIMIT 1';
    $sql = $conn->prepare($sql);
    $sql->bind_param('ss' , $username, $session);
    if($sql->execute()) {
        session_start();
        session_unset();
        session_destroy();
        
        setcookie('ssid', '', time() - (86400 * -1), "/");
        setcookie('user_id', '', time() - (86400 * -1), "/");
        setcookie('username', '', time() - (86400 * -1), "/");
        setcookie('role', '', time() - (86400 * -1), "/");
        setcookie('profile_picture', '', time() - (86400 * -1), "/");
        return true;
    } else {
        return false;
    }
}

function checkSessionValidity($conn,$user_id) {
    date_default_timezone_set("Asia/Singapore");
    $year = date('Y');
    $sql = 'SELECT id,date_login from user_sessions where user_id = ? LIMIT 1';
    $sql = $conn->prepare($sql);
    $sql->bind_param('i',$user_id);
    $sql->execute();
    $sql->bind_result($id,$date_login);
    $sql->store_result();
    $sql->num_rows();
    $sql->fetch();

    $datedb = explode('-',$date_login);

    //calculate if 7 or more days passed
    if(strtotime($date_login) < strtotime('-7 day')) {
        while(!deleteSession($conn,$user_id)) {
            deleteSession($conn,$user_id);
        }
        return false;
    } else {
        return true;
    }
}
function deleteSession($conn,$user_id) {
    $sql = 'DELETE FROM user_sessions where user_id = ? LIMIT 1';
    $sql = $conn->prepare($sql);
    $sql->bind_param('i',$user_id);
    if($sql->execute()) {
        return true;
    } else {
        return false;
    }
}
function cleandata($data){
    $data = trim($data);
    $data = stripcslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
// user_sessions
//	session_id, user_id, username, role, profile_picture