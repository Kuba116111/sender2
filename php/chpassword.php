<?php
    session_start();

    if(!isset($_COOKIE['logged']) && $_COOKIE['logged'] != true)
    {
        header("Location: ../index.php");
        exit();
    }

    include_once "connect.php";

    $_SESSION['chpassword_error'] = '';

    $id = $_SESSION['id'];
    $email = $_SESSION['email'];

    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $chpassword1 = mysqli_real_escape_string($conn, $_POST['chpassword1']);
    $chpassword2 = mysqli_real_escape_string($conn, $_POST['chpassword2']);

    // print_r($password.$chpassword1.$chpassword2);

    if(!empty($password) || !empty($chpassword1) || !empty($chpassword2)){
        if($chpassword1 === $chpassword2)
        {
            $select_password = mysqli_query($conn, "SELECT pass FROM users WHERE id = '{$id}'");
            $row = $select_password->fetch_assoc();

            if (password_verify($password, $row['pass']) == true) {
                $encrypt_pass = password_hash($chpassword1, PASSWORD_DEFAULT);
                $insert_query = mysqli_query($conn, "UPDATE users SET pass='{$encrypt_pass}' WHERE id = $id");
                if($insert_query){
                    require_once "verify.php";
                    $temat = 'Twoje hasło zostało zmienione';
                    weryfikacja($email, $temat, 'info', 'chpassword.php');
                    // $_SESSION['chpassword_error'] = '<p>Hasło zostało zmienione<p>';
                    unset($_SESSION['chpassword_error']);
                    header("Location: ../settings.php#chpassword");
                    exit();
                }else{
                    $_SESSION['chpassword_error'] = '<p class="error">Coś poszło nie tak, spróbuj ponownie później</p>';
                    header("Location: ../settings.php#chpassword");
                    exit();
                }
            }else{
                $_SESSION['chpassword_error'] = '<p class="error">Stare hasło jest nieprawidłowe</p>';
                header("Location: ../settings.php#chpassword");
                exit();
            }
        }else{
            $_SESSION['chpassword_error'] = '<p class="error">Wprowadzone nowe hasła są różne</p>';
            header("Location: ../settings.php#chpassword");
            exit();
        }
    }else{
        $_SESSION['chpassword_error'] = '<p class="error">Pola nie mogą być puste</p>';
        header("Location: ../settings.php#chpassword");
        exit();
    }

    $conn->close();
?>