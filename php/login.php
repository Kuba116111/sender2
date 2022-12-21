<?php
    session_start();

    // if(isset($_SESSION['logged']) && $_SESSION['logged'] = true)
    // {
    //     header("Location: ../chat.php");
    //     exit();
    // } else {
    //     header("Location: ../index.php");
    //     exit();
    // }

    require_once("connect.php");

    // $_SESSION['index_error'] = 'Błąd';
    // unset ($_SESSION['index_error']);

    $_SESSION['index_error'] = '';

    if(isset($_POST['login']) && isset($_POST['password']))
    {
        $login = $_POST['login'];
        $pass = $_POST['password'];

        $login = htmlentities($login, ENT_QUOTES, "UTF-8");
        $pass = htmlentities($pass, ENT_QUOTES, "UTF-8");

        $_SESSION['frlogin'] = $_POST['login'];

        $db_conn = new mysqli($host,$db_user,$db_password,$db_name);
        if ($db_conn->connect_errno!=0)
        {
            $_SESSION['index_error'] = "Błąd połączenia: ".$db_conn->connect_errno;
        } else {
            // $sql = ;

            if ($result = @$db_conn->query(
                sprintf("SELECT * FROM users WHERE user='%s'",
                mysqli_real_escape_string($db_conn,$login))))
            {
                $is_user = $result->num_rows;
                if($is_user>0)
                {
                    $row = $result->fetch_assoc();

                    if (password_verify($pass, $row['pass']) == true)
                    {
                        $_SESSION['login'] = $login;
                        
                        // unset($_SESSION['frlogin']);
                        
                        // $status = "Active now";
                        $update_query = mysqli_query($conn, "UPDATE users SET status = NULL WHERE user='{$login}'");
                        if($update_query){
                            $select_sql2 = mysqli_query($conn, "SELECT id FROM users WHERE user='{$login}'");
                            // if(mysqli_num_rows($select_sql2) > 0){
                            $result = mysqli_fetch_assoc($select_sql2);
                            $_SESSION['id'] = $result['id'];

                            $_SESSION['logged'] = true;
                            // echo "success";

                            unset($_SESSION['frlogin']);
                            unset($_SESSION['index_error']);
                            // unset($_SESSION['fremail']);
                            // unset($_SESSION['reg_error']);

                            // echo $_SESSION['id'];
                            header("Location: ../chat.php");
                            exit();
                            
                            // }else{
                            //     $_SESSION['reg_error'] = "This email address not Exist!";
                            //     header("Location: ../index.php");
                            //     exit();
                            // }
                        }else{
                            $_SESSION['index_error'] = "Coś poszlo nie tak, spróbuj ponownie";
                            header("Location: ../index.php");
                            exit();
                        }

                    } else {
                        $_SESSION['index_error'] = 'Login i/lub hasło są nieprawidłowe';
                        header("Location: ../index.php");
                        exit();
                    }
                } else {
                    $_SESSION['index_error'] = 'Login i/lub hasło są nieprawidłowe';
                    header("Location: ../index.php");
                    exit();
                }
            }


            $db_conn->close();
        }
        
    } else {
        $_SESSION['index_error'] = 'Wypełnij wszystkie pola';
        
        header("Location: ../index.php");
        exit();
    }
?>