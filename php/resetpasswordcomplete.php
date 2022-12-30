<?php
    session_start();

    require_once "connect.php";
    // require_once "verify.php";

    // echo $_SESSION['verify'];
    
    if(isset($_SESSION['verify']) && $_SESSION['verify'] == true)
    {
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $password1 = mysqli_real_escape_string($conn, $_POST['password1']);

        if(!empty($password) && !empty($password1)) {
            if($password === $password1)
            {
                $login = $_SESSION['login'];
                $email = $_SESSION['email'];
                $encrypt_pass = password_hash($password, PASSWORD_DEFAULT);
                $insert_query = mysqli_query($conn, "UPDATE `users` SET `pass`= '{$encrypt_pass}' WHERE user = '{$login}' AND email = '{$email}'");
                if($insert_query){
                    unset($_SESSION['verify']);

                    unset($_SESSION['login']);
                    unset($_SESSION['email']);
                    unset($_SESSION['resetpassword_error']);
                    require_once "verify.php";
                    $temat = 'Twoje informacje o koncie zostały zmienione';
                    weryfikacja($email, $temat, 'info', '');
                    header("Location: ../index.php");
                    // exit();
                }else{
                    $_SESSION['reg_error'] = "Coś poszło nie tak, spróbuj ponownie później";
                    header("Location: ../newpassword.php");
                    exit();
                }
            }else{
                $_SESSION['reg_error'] = "Hasła nie są zgodne";
                header("Location: ../newpassword.php");
                exit();
            }
        }else{
            $_SESSION['reg_error'] = "Wypełnij wszystkie pola";
            header("Location: ../newpassword.php");
            exit();
        }
    }

    $conn->close();
?>