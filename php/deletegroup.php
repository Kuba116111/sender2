<?php
    session_start();

    require_once("connect.php");

    $id = $_SESSION['id'];

    $group_id = $_POST['groupId'];

    $sql = "SELECT role FROM groups_members WHERE group_id=$group_id AND user_id=$id";
    $row = mysqli_fetch_assoc(mysqli_query($conn,$sql));

    if ($row['role']=='administrator') {
        $sql1 = "DELETE FROM groups_members WHERE group_id = $group_id";
        $sql2 = "DELETE FROM groups WHERE group_id = $group_id";
        $sql3 = "DROP TABLE groups_$group_id";
    
        if (mysqli_query($conn, $sql1) && mysqli_query($conn, $sql2) && mysqli_query($conn, $sql3)) {
            echo 'success';
        }else{
            echo 'error';
        }
    }else{
        echo 'error';
    }

?>