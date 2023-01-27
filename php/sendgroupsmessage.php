<?php
    session_start();

    if(!isset($_COOKIE['logged']) && $_COOKIE['logged'] != true)
    {
        header("Location: ../index.php");
        exit();
    }

    $id = $_SESSION['id'];

    require_once("connect.php");

    $group_id = mysqli_real_escape_string($conn, $_POST['group_id']);
    // $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    // $outgoing_id = $_SESSION['id'];

    $output = '';

    // $sql1 = "SELECT * FROM chats WHERE (friend1_id = '{$id}' AND friend2_id = '{$user_id}') OR (friend1_id = '{$user_id}' OR friend2_id = '{$id}')";
    // $query1 = mysqli_query($conn, $sql1);

    // while($row1 = mysqli_fetch_assoc($query1))
    // {
    //     $groups = $row1['groups'];
    // }

    $sql2 = "SELECT * FROM groups,groups_members WHERE (groups.group_id = $group_id AND groups_members.user_id = $id) AND (groups.group_id = groups_members.group_id)";
    $query2 = mysqli_query($conn, $sql2);

    if(mysqli_num_rows($query2) > 0){
        $date = date("d-m-Y");
        $time = date("H:i:s");
        $sql = "INSERT INTO groups_$group_id VALUES (NULL, '{$id}', NULL, '{$message}', '{$date}', '{$time}')";
        $query = mysqli_query($conn, $sql);
        $actual_date = date('Y-m-d H:i:s');
        $sql_update = "UPDATE `groups` SET date = '{$actual_date}' WHERE group_id=$group_id";
        $query_update = mysqli_query($conn, $sql_update);
    }

    // echo date("Y:m:d H:i:s");
    
    // echo $output;
    
    $conn->close();
?>