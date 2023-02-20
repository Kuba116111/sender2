<?php
    session_start();

    if(!isset($_COOKIE['logged']) && $_COOKIE['logged'] != true)
    {
        header("Location: ../index.php");
        exit();
    }

    $id = $_SESSION['id'];
    
    require_once("connect.php");
    
    $group_id = mysqli_real_escape_string($conn, $_POST['group-id']);
    
    $sql_check = "SELECT role FROM groups_members WHERE user_id=$id AND group_id=$group_id";

    $output = '';

    if(mysqli_num_rows($sql_check)>0){
        $role = mysqli_fetch_assoc(mysqli_query($conn, $sql_check));

        if ($role['role'] == "administrator") {
            if(isset($_FILES['image'])){
                $img_name = $_FILES['image']['name'];
                $img_type = $_FILES['image']['type'];
                $tmp_name = $_FILES['image']['tmp_name'];
                
                $img_explode = explode('.',$img_name);
                $img_ext = end($img_explode);
        
                $extensions = ["jpeg", "png", "jpg"];
                if(in_array($img_ext, $extensions) === true){
                    $types = ["image/jpeg", "image/jpg", "image/png"];
                    if(in_array($img_type, $types) === true){
                        $ran_id = rand(time(), 100000000);
                        $new_img_name = $ran_id.$img_name;
                        if(move_uploaded_file($tmp_name,"../images/groups/".$new_img_name)){
                            $actual_date = date('Y-m-d H:i:s');
                        
                            $sql2 = "UPDATE `groups` SET `img`='groups/$new_img_name',`date`='$actual_date' WHERE `group_id`=$group_id";
                            $query2 = mysqli_query($conn, $sql2);
                        
                            $output = "success";
                        }else{
                            $output = "Obsługiwane formaty obrazów - jpeg, png, jpg";
                        }
                    }else{
                        $output = "Prawidłowe formaty - jpeg, png, jpg";
        
                    }
                }
            }
        }
    }


    echo $output;

    $conn->close();
?>