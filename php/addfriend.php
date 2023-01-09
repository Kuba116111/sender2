<?php
    session_start();

    require_once("connect.php");

    $id = $_SESSION['id'];
    $friend_id = $_POST['friend-id'];
    
    $sql_insert = "INSERT INTO friends VALUES (NULL,'{$id}','{$friend_id}', 'no')";

    if(mysqli_query($conn, $sql_insert))
    {
        echo "success";
        header("Location: ../profile.php?id=$friend_id");
    }
?>