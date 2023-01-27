<?php
    session_start();

    if(!isset($_COOKIE['logged']) && $_COOKIE['logged'] != true)
    {
        header("Location: ../index.php");
        exit();
    }

    $id = $_SESSION['id'];

    require_once("connect.php");

    $chat_id = mysqli_real_escape_string($conn, $_POST['chat_id']);
    $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    // $outgoing_id = $_SESSION['id'];

    $output = '';

    $sql1 = "SELECT * FROM chats WHERE (friend1_id = '{$id}' AND friend2_id = '{$user_id}') OR (friend1_id = '{$user_id}' OR friend2_id = '{$id}')";
    $query1 = mysqli_query($conn, $sql1);

    // while($row1 = mysqli_fetch_assoc($query1))
    // {
    //     $chats = $row1['chats'];
    // }
    $date = date("d-m-Y");
    $time = date("H:i:s");
    $sql = "INSERT INTO messages_$chat_id VALUES (NULL, '{$id}', '{$user_id}', '{$message}', '{$date}', '{$time}')";
    $query = mysqli_query($conn, $sql);
    $actual_date = date('Y-m-d H:i:s');
    $sql_update = "UPDATE `chats` SET date = '{$actual_date}' WHERE chat_id=$chat_id";
    $query_update = mysqli_query($conn, $sql_update);

    // echo date("Y:m:d H:i:s");
    
    // echo $output;
    
    $conn->close();
?>