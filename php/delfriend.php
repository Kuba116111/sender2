<?php
    session_start();

    require_once("connect.php");

    $id = $_SESSION['id'];
    $friend_id = $_POST['friend-id'];
    
    $sql_delete = "DELETE FROM friends WHERE (friend1_id = '{$id}' AND friend2_id = '{$friend_id}') OR (friend1_id = '{$friend_id}' AND friend2_id = '{$id}')";

    if(mysqli_query($conn, $sql_delete))
    {
        echo "success";
        header("Location: ../profile.php?id=$friend_id");
    }
?>