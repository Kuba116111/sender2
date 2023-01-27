<?php
    session_start();

    if(!isset($_COOKIE['logged']) && $_COOKIE['logged'] != true)
    {
        header("Location: ../index.php");
        exit();
    }

    $id = $_SESSION['id'];

    require_once("connect.php");

    $user_id = mysqli_real_escape_string($conn, $_GET['id']);

    // $outgoing_id = $_SESSION['id'];

    $output = '';

    $sql = "SELECT * FROM chats WHERE (friend1_id = '{$id}' AND friend2_id = '{$user_id}') OR (friend1_id = '{$user_id}' OR friend2_id = '{$id}')";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) === 1) {
        while($row = mysqli_fetch_assoc($query))
        {
            // $output = '';
            $chat_id = $row['chat_id'];
    
        }
        header("Location: ../messages.php?chatid=$chat_id&userid=$user_id");
        // echo '<br>';
        // print_r($one_chat2);
        exit();
    }

    $rand = rand(time(), 100000000);
    $sql_create = "CREATE TABLE `sender2`.`messages_$rand` (`id` INT NOT NULL AUTO_INCREMENT , `from_user` INT NOT NULL , `to_user` INT NOT NULL , `text` LONGTEXT NOT NULL , `date` TEXT NULL , `time` TIME NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB";
    $query_create = mysqli_query($conn, $sql_create);
    
    // print_r($newchats.$newchats2);
    $actual_date = date('Y-m-d H:i:s A');
    $sql_insert = "INSERT INTO `chats` SET friend1_id = '{$id}', friend2_id = '{$user_id}', `chat_id`='{$rand}', date = '{$actual_date}'";
    $query_insert = mysqli_query($conn, $sql_insert);
    header("Location: ../messages.php?chatid=$rand&userid=$user_id");

    $conn->close();
?>