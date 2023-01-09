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

    $sql = "SELECT * FROM users WHERE id = '{$id}'";
    $query = mysqli_query($conn, $sql);
    $sql2 = "SELECT * FROM users WHERE id = '{$user_id}'";
    $query2 = mysqli_query($conn, $sql2);

    while($row = mysqli_fetch_assoc($query))
    {
        // $output = '';
        $chats = $row['chats'];
        $newchats = $row['chats'];

    }
    while($row2 = mysqli_fetch_assoc($query2))
    {
        // $output2 = '';
        $chats2 = $row2['chats'];
        $newchats2 = $row2['chats'];

    }

    $chats = explode(',',$chats);
    $chats2 = explode(',',$chats2);
    foreach($chats as $one_chat)
    {
        // if($one_chat !== '')
        // {
            // print_r($one_chat);
            foreach($chats2 as $one_chat2)
            {
                // print_r($chats2);
                // echo $one_chat2;
                
                    if(($one_chat === $one_chat2))
                    {
                        if($one_chat2 !== '')
                        {
                            header("Location: ../messages.php?chatid=$one_chat&userid=$user_id");
                            // echo '<br>';
                            // print_r($one_chat2);
                            exit();
                        // }else{
                            
                        }
                    }
                    // if(($one_chat === $one_chat2)&&($one_chat !== '' || $one_chat2 !== ''))
                    // {
                    // }else{
                    // }
                // if($one_chat === $one_chat2 && $one_chat !== '')
                // {
                //     header("Location: ../messages.php?chatid=$one_chat&userid=$user_id");
                //     exit();
                // }elseif($one_chat === $one_chat2 && $one_chat === ''){
                //     $rand = rand(time(), 100000000);
                //     $sql_create = "CREATE TABLE `sender2`.`messages_$rand` (`id` INT NOT NULL AUTO_INCREMENT , `from_user` INT NOT NULL , `to_user` INT NOT NULL , `text` LONGTEXT NOT NULL , `date_time` DATETIME NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB";
                //     $query_create = mysqli_query($conn, $sql_create);
                    
                //     $sql_update = "UPDATE `users` SET `chats`='{$rand}' WHERE `id` = '{$id}';";
                //     $sql_update2 = "UPDATE `users` SET `chats`='{$rand}' WHERE `id` = '{$user_id}';";
                //     $query_update = mysqli_query($conn, $sql_update);
                //     $query_update2 = mysqli_query($conn, $sql_update2);
                //     header("Location: ../messages.php?chatid=$rand&userid=$user_id");
                //     exit();
                // }else{
                //     $rand = rand(time(), 100000000);
                //     $sql_create = "CREATE TABLE `sender2`.`messages_$rand` (`id` INT NOT NULL AUTO_INCREMENT , `from_user` INT NOT NULL , `to_user` INT NOT NULL , `text` LONGTEXT NOT NULL , `date_time` DATETIME NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB";
                //     $query_create = mysqli_query($conn, $sql_create);
                    
                //     $newchats = $newchats.','.$rand;                    
                //     $newchats2 = $newchats2.','.$rand;
                    
                //     $sql_update = "UPDATE `users` SET `chats`='{$newchats}' WHERE `id` = '{$id}';";
                //     $sql_update2 = "UPDATE `users` SET `chats`='{$newchats2}' WHERE `id` = '{$user_id}';";
                //     $query_update = mysqli_query($conn, $sql_update);
                //     $query_update2 = mysqli_query($conn, $sql_update2);
                //     header("Location: ../messages.php?chatid=$rand&userid=$user_id");
                //     exit();
                // }
                
            }

        // }else{
        //     $rand = rand(time(), 100000000);
        //     $sql_create = "CREATE TABLE `sender2`.`messages_$rand` (`id` INT NOT NULL AUTO_INCREMENT , `from_user` INT NOT NULL , `to_user` INT NOT NULL , `text` LONGTEXT NOT NULL , `date` TEXT NULL , `time` TIME NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB";
        //     $query_create = mysqli_query($conn, $sql_create);
            
        //     $newchats = $newchats.','.$rand;                    
        //     $newchats2 = $newchats2.','.$rand;
            
        //     // print_r($newchats.$newchats2);
        //     $sql_update = "UPDATE `users` SET `chats`='{$newchats}' WHERE `id` = '{$id}';";
        //     $sql_update2 = "UPDATE `users` SET `chats`='{$newchats2}' WHERE `id` = '{$user_id}';";
        //     // $query_update = mysqli_query($conn, $sql_update);
        //     // $query_update2 = mysqli_query($conn, $sql_update2);
        //     header("Location: ../messages.php?chatid=$rand&userid=$user_id");
        //     exit();
        // }
            
    }
    // print_r($chats);

    $rand = rand(time(), 100000000);
    $sql_create = "CREATE TABLE `sender2`.`messages_$rand` (`id` INT NOT NULL AUTO_INCREMENT , `from_user` INT NOT NULL , `to_user` INT NOT NULL , `text` LONGTEXT NOT NULL , `date` TEXT NULL , `time` TIME NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB";
    $query_create = mysqli_query($conn, $sql_create);
    
    $newchats = $newchats.','.$rand;                    
    $newchats2 = $newchats2.','.$rand;
    
    // print_r($newchats.$newchats2);
    $sql_update = "UPDATE `users` SET `chats`='{$newchats}' WHERE `id` = '{$id}';";
    $sql_update2 = "UPDATE `users` SET `chats`='{$newchats2}' WHERE `id` = '{$user_id}';";
    $query_update = mysqli_query($conn, $sql_update);
    $query_update2 = mysqli_query($conn, $sql_update2);
    header("Location: ../messages.php?chatid=$rand&userid=$user_id");
    
    // print_r($one_chat);
    // echo '<br>';
    // print_r($one_chat2);
    // exit();


    $conn->close();
?>