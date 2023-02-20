<?php
    session_start();

    if(!isset($_COOKIE['logged']) && $_COOKIE['logged'] != true)
    {
        header("Location: ../index.php");
        exit();
    }

    $id = $_SESSION['id'];

    require_once("connect.php");

    $members = mysqli_real_escape_string($conn, $_POST['members']);

    // $outgoing_id = $_SESSION['id'];

    $output = '';

    

    $rand = rand(time(), 100000000);
    $members_id = explode(',', $members);

    $sql_insert_groups_members = "INSERT INTO groups_members VALUES (NULL, '{$id}', '{$rand}', NULL, 'administrator')";
    $query_insert_groups_members = mysqli_query($conn, $sql_insert_groups_members);

    $members_names = '';

    $sql_select_group_this_member = "SELECT user FROM users WHERE id=$id";
    $query_select_group_this_member = mysqli_query($conn, $sql_select_group_this_member);
    $row_select_group_this_member = mysqli_fetch_assoc($query_select_group_this_member);
    $members_names .=  $row_select_group_this_member['user'];
    
    foreach ($members_id as $one_member_id) {
        if($one_member_id !== '')
        {
            $sql_insert_groups_members = "INSERT INTO groups_members VALUES (NULL, '{$one_member_id}', '{$rand}', NULL, 'member')";
            $query_insert_groups_members = mysqli_query($conn, $sql_insert_groups_members);
            $sql_select_groups_members = "SELECT user FROM users WHERE id=$one_member_id";
            $query_select_groups_members = mysqli_query($conn, $sql_select_groups_members);
            $row_select_groups_members = mysqli_fetch_assoc($query_select_groups_members);
            $members_names .= ', '.$row_select_groups_members['user'];
        }
    }

    $sql_create = "CREATE TABLE `sender2`.`groups_$rand` (`id` INT NOT NULL AUTO_INCREMENT , `from_user` INT NOT NULL , `to_user` INT NULL , `text` LONGTEXT NOT NULL , `date` TEXT NULL , `time` TIME NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB";
    $query_create = mysqli_query($conn, $sql_create);
    
    // print_r($newchats.$newchats2);
    $actual_date = date('Y-m-d H:i:s');
    $members = $id.','.$members;
    $sql_insert = "INSERT INTO groups VALUES (NULL, '{$members}', '{$rand}', '{$members_names}', 'default/groups/default.jpeg', '{$actual_date}', '{$id}')";
    $query_insert = mysqli_query($conn, $sql_insert);
    header("Location: ../groups.php?groupid=$rand");

    $conn->close();

    // echo $members_id;
?>