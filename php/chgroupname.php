<?php
    session_start();

    if(!isset($_COOKIE['logged']) && $_COOKIE['logged'] != true)
    {
        header("Location: ../index.php");
        exit();
    }

    require_once("connect.php");

    $id = $_SESSION['id'];

    $group_name = mysqli_real_escape_string($conn, $_POST['group-name']);
    $group_id = mysqli_real_escape_string($conn, $_POST['group-id']);
    
    $sql_check = "SELECT role FROM groups_members WHERE user_id=$id AND group_id=$group_id";

    $output = '';
    if(mysqli_num_rows($sql_check)>0){
        $role = mysqli_fetch_assoc(mysqli_query($conn, $sql_check));
    
        if ($role['role'] == "administrator") {
            $name = "SELECT group_name FROM groups WHERE `group_id`=$group_id";
            $query = mysqli_query($conn, $name);
            while($row = mysqli_fetch_assoc($query)){
                $old_group_name = $row['group_name'];
            }
    
            if ($old_group_name !== $group_name) {
                $actual_date = date('Y-m-d H:i:s');
            
                $sql2 = "UPDATE `groups` SET `group_name`='$group_name',`date`='$actual_date' WHERE `group_id`=$group_id";
                $query2 = mysqli_query($conn, $sql2);
    
                $output = "success";
            }else{
                $output = "Nazwa grupy jest taka sama";
            }
        }
    }

    echo $output;

    $conn->close();
?>