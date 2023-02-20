<?php
    session_start();

    require_once("connect.php");

    $id = $_SESSION['id'];

    $group_id = $_POST['groupId'];

    $sql = "DELETE FROM groups_members WHERE user_id = $id AND group_id = $group_id";

    if (mysqli_query($conn, $sql)) {
        echo 'success';
    }else{
        echo 'error';
    }


?>