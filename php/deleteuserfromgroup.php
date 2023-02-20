<?php
    session_start();

    require_once("connect.php");

    $id = $_SESSION['id'];

    $user_id = $_POST['userId'];
    $group_id = $_POST['groupId'];

    $sql = "SELECT role FROM groups_members WHERE group_id=$group_id AND user_id=$id";
    $row = mysqli_fetch_assoc(mysqli_query($conn,$sql));

    if ($row['role']=='administrator') {
        $sql_delete = "DELETE FROM groups_members WHERE group_id=$group_id AND user_id=$user_id";
    
        if (mysqli_query($conn, $sql_delete)) {
            echo 'success';
        }else{
            echo 'error';
        }
    }else{
        echo 'error';
    }

?>