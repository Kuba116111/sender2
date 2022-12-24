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

    $sql2 = "SELECT * FROM users WHERE id = '{$user_id}'";
    $query2 = mysqli_query($conn, $sql2);

    while($row1 = mysqli_fetch_assoc($query2))
    {
        $chats = $row1['chats'];
    }

    if ($chats !== '') {
        $chats2 = explode(',',$chats);
        $i=0;
        foreach($chats2 as $one_chat)
        {
            if($i!==0) {
                if($one_chat === $chat_id)
                {
                    $date = date("d-m-Y");
                    $time = date("H:i:s");
                    $sql = "INSERT INTO messages_$chat_id VALUES (NULL, '{$id}', '{$user_id}', '{$message}', '{$date}', '{$time}')";
                    $query = mysqli_query($conn, $sql);
                }
            }
            $i++;
        }
    }

    // echo date("Y:m:d H:i:s");
    
    // echo $output;
    
    $conn->close();
?>