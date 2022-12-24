<?php
    session_start();

    if(!isset($_COOKIE['logged']) && $_COOKIE['logged'] != true)
    {
        header("Location: ../index.php");
        exit();
    }

    include_once "connect.php";

    $_SESSION['chdata_error'] = '';

    // $conn = new mysqli($host,$db_user,$db_password,$db_name);

    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    
    $id = $_SESSION['id'];

    if(!empty($email)){
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            $select_email = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
            // $select_email = mysqli_query($conn, "SELECT email FROM users WHERE id = '{$id}'");
            $row = $select_email->fetch_assoc();
            if(mysqli_num_rows($select_email) > 0 && $row['id'] !== $id){
                $_SESSION['chdata_error'] = '<p class="error">$email - Ten e-mail jest już zajęty</p>';
                header("Location: ../settings.php#chdata");
                exit();
            }else{
                $insert_query = mysqli_query($conn, "UPDATE users set fname ='{$fname}', lname ='{$lname}', email ='{$email}' WHERE id = $id");
                if($insert_query){
                    unset($_SESSION['chdata_error']);
                    header("Location: ../settings.php#chdata");
                    exit();
                }else{
                    $_SESSION['chdata_error'] = '<p class="error">Coś poszło nie tak, spróbuj ponownie później</p>';
                    header("Location: ../settings.php#chdata");
                    exit();
                }
            }
        }else{
            $_SESSION['chdata_error'] = '<p class="error">Adres e-mail ma niepoprawny format</p>';
            header("Location: ../settings.php#chdata");
            exit();
        }
    }else{
        $_SESSION['chdata_error'] = '<p class="error">Adres e-mail jest wymagany</p>';
        header("Location: ../settings.php#chdata");
        exit();
    }

    $conn->close();
?>