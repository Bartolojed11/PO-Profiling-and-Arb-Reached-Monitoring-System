<?php
    require '../controller/connectdb.php';
$sql = 'SELECT users.id, users.username, users.lastname, users.firstname, users.middlename, users.email, users.phoneno,
        pos.description from users inner join user_position as pos on pos.id = users.user_position_id
        WHERE user_stat_id = 2';
$sql = $conn->prepare($sql);
$sql->execute();
$sql->bind_result($id, $username, $lastname, $firstname, $middlename, $email, $phoneno, $position);
$sql->store_result();
if($sql->num_rows()) {
    while($sql->fetch()) {
        echo "<tr>
                <td>$username</td>
                <td>$lastname $firstname $middlename</td>
                <td>$email</td>
                <td>$phoneno</td>
                <td>$position</td>
                <td><button type='button' class='btn btn-sm btn-success' value='$id' onclick='confirmUser(this.value);'>Confirm</button></td>
            </tr>";
    }
} else {
    echo "<tr>
            <td colspan='12' class='text-center' style='background-color:#f0f5f5'>Empty</td>
         <tr>";
}