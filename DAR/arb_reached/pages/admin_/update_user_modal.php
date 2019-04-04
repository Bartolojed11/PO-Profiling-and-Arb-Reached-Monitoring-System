<?php
    require '../controller/connectdb.php';
    $id = isset($_POST['id']) ? $_POST['id'] : 0 ;
    $sql = 'SELECT users.username, pos.description, pos.id from users
            inner join user_position pos on pos.id = users.user_position_id where users.id = ? LIMIT 1';
    $sql = $conn->prepare($sql);
    $sql->bind_param('i', $id);
    $sql->execute();
    $sql->bind_result($username, $position, $pos_id);
    $sql->store_result();
    $sql->num_rows();
    $sql->fetch();
    
    echo '<div id="user_modal">
    <div id="user" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title text-center">Update User</h4>
        </div>
        <div class="modal-body">
    
            <form method="post" action="admin_/upd_user.php">
            <input type="hidden" name="id" value="'.$id.'" >
            <div class="form-group">
                <label for="usr">Username:</label>
                <input type="text" value="'.$username.'" name="username" class="form-control" id="usr">
            </div>
            <div class="form-group">
                <label for="pwd">New Password:</label>
                <input type="password" name="new_pass" class="form-control" id="pwd">
            </div>
            <div class="form-group">
                <label for="role">Position:</label>
                <select name="role" class="form-control" id="role">
                <option value="'.$pos_id.'">'.$position.'</option>';
    
                    $sql = 'SELECT * FROM user_position where id != ?';
                    $sql = $conn->prepare($sql);
                    $sql->bind_param('i', $pos_id);
                    $sql->execute();
                    $sql->bind_result($pos_id_, $pos_desc_);
                    $sql->store_result();
                    if($sql->num_rows()) {
                        while($sql->fetch()) {
                            echo "<option value='$pos_id_'>$pos_desc_</option>";
                        }
                    }
                echo '</select>
                </div>
                <button class="btn btn-success" type="submit" name="update_user">Update</button>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
        </div>
    
    </div>
    </div>
    </div>';