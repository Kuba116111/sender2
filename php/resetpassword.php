<?php
    session_start();

    // if(!isset($_COOKIE['logged']) && $_COOKIE['logged'] != true)
    // {
    //     header("Location: ../index.php");
    //     exit();
    // }

    include_once "connect.php";

    $_SESSION['resetpassword_error'] = '';

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $login = mysqli_real_escape_string($conn, $_POST['login']);

    // print_r($password.$resetpassword1.$resetpassword2);

    if(!empty($email) && !empty($login)){
        $select_password = mysqli_query($conn, "SELECT pass FROM users WHERE user = '{$login}' AND email = '{$email}'");
        if(mysqli_num_rows($select_password)==1)
        {
            $_SESSION['login'] = $login;
            $_SESSION['email'] = $email;
            require_once "verify.php";
            $temat = 'Weryfikacja użytkownika w celu zmiany hasła';

            weryfikacja($email, $temat, 'verify', '../newpassword.php');
        }else{
            $_SESSION['resetpassword_error'] = 'Nie znaleziono użytkownika o podanych informacjach';
            header("Location: ../resetpassword.php");
            exit();
        }

        // if (password_verify($password, $row['pass']) == true) {
        //     $encrypt_pass = password_hash($resetpassword1, PASSWORD_DEFAULT);
        //     $insert_query = mysqli_query($conn, "UPDATE users SET pass='{$encrypt_pass}' WHERE id = $id");
        //     if($insert_query){
        //         require_once "verify.php";
        //         $temat = 'Twoje hasło zostało zmienione';
        //         weryfikacja($email, $temat, 'info', 'resetpassword.php');
        //         // $_SESSION['resetpassword_error'] = '<p>Hasło zostało zmienione<p>';
        //         unset($_SESSION['resetpassword_error']);
        //         header("Location: ../settings.php#resetpassword");
        //         exit();
        //     }else{
        //         $_SESSION['resetpassword_error'] = '<p class="error">Coś poszło nie tak, spróbuj ponownie później</p>';
        //         header("Location: ../settings.php#resetpassword");
        //         exit();
        //     }
        // }else{
        //     $_SESSION['resetpassword_error'] = '<p class="error">Stare hasło jest nieprawidłowe</p>';
        //     header("Location: ../settings.php#resetpassword");
        //     exit();
        // }
    }else{
        $_SESSION['resetpassword_error'] = '<p class="error">Pola nie mogą być puste</p>';
        header("Location: ../resetpassword.php");
        exit();
    }

    $conn->close();
?>