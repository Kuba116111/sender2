<?php
    session_start();

    if(!isset($_COOKIE['logged']) && $_COOKIE['logged'] != true)
    {
        header("Location: ../index.php");
        exit();
    }

    include_once "connect.php";

    $_SESSION['chavatar_error'] = '';

    $id = $_SESSION['id'];

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
                $new_img_name = $id.$img_name;
                if(move_uploaded_file($tmp_name,"../images/users/".$new_img_name)){
                    $update_query = mysqli_query($conn, "UPDATE users SET img = '{$new_img_name}' WHERE id = $id");
                    if($update_query){
                        unset($_SESSION['chavatar_error']);
                        header("Location: ../settings.php#chavatar");
                        exit();
                    }else{
                        $_SESSION['chavatar_error'] = '<p class="error">Coś poszło nie tak, spróbuj ponownie później</p>';
                        header("Location: ../settings.php#chavatar");
                        exit();
                    }
                }else{
                    $_SESSION['chavatar_error'] = '<p class="error">Coś poszło nie tak, spróbuj ponownie później</p>';
                    header("Location: ../settings.php#chavatar");
                    exit();
                }
            }
        }else{
            $_SESSION['chavatar_error'] = '<p class="error">Obsługiwane formaty obrazów - jpeg, png, jpg</p>';
            header("Location: ../settings.php#chavatar");
            exit();
        }
    }else{
        $_SESSION['chavatar_error'] = '<p class="error">Prawidłowe formaty - jpeg, png, jpg</p>';
        header("Location: ../settings.php#chavatar");
        exit();
    }

    $conn->close();
?>