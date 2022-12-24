<?php
    session_start();

    include_once "connect.php";

    $_SESSION['reg_error'] = '';

    $conn = new mysqli($host,$db_user,$db_password,$db_name);

    // $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    // $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $password1 = mysqli_real_escape_string($conn, $_POST['password1']);
    $login = mysqli_real_escape_string($conn, $_POST['login']);
    if(!empty($email) && !empty($password) && !empty($login)){
        if($password === $password1)
        {
            if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                $sql = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
                if(mysqli_num_rows($sql) > 0){
                    $_SESSION['reg_error'] = "$email - Ten e-mail jest już zajęty";
                    header("Location: ../register.php");
                    exit();
                }else{
                    $sql1 = mysqli_query($conn, "SELECT * FROM users WHERE user = '{$login}'");
                    if(mysqli_num_rows($sql1) > 0){
                        $_SESSION['reg_error'] = "$login - Ten login jest już zajęty";
                        header("Location: ../register.php");
                        exit();
                    }else{
                        if(isset($_POST['accept'])){
                            $ran_id = rand(time(), 100000000);
                            $status = "Active now";
                            $encrypt_pass = password_hash($password, PASSWORD_DEFAULT);
                            $insert_query = mysqli_query($conn, "INSERT INTO users (id, user, fname, lname, email, pass, status)
                            VALUES ('{$ran_id}', '{$login}', NULL, NULL, '{$email}', '{$encrypt_pass}', '{$status}')");
                            if($insert_query){
                                $select_sql2 = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
                                if(mysqli_num_rows($select_sql2) > 0){
                                    $result = mysqli_fetch_assoc($select_sql2);
                                    $_SESSION['id'] = $result['id'];

                                    $_SESSION['logged'] = true;
                                    // echo "success";
    
                                    unset($_SESSION['frlogin']);
                                    unset($_SESSION['fremail']);
                                    // unset($_SESSION['reg_error']);
                                    header("Location: ../chat.php");
                                    exit();
                                }else{
                                    $_SESSION['reg_error'] = "This email address not Exist!";
                                    header("Location: ../register.php");
                                    exit();
                                }
                            }else{
                                $_SESSION['reg_error'] = "Coś poszlo nie tak, spróbuj ponownie później";
                                header("Location: ../register.php");
                                exit();
                            }
                        }else{
                            $_SESSION['reg_error'] = "Zaakceptuj regulamin";
                            header("Location: ../register.php");
                            exit();
                        }
                    }
                }
            }else{
                $_SESSION['reg_error'] = "$email - jest błędny";
                header("Location: ../register.php");
                exit();
            }
        }else{
            $_SESSION['reg_error'] = "Hasła nie są zgodne";
                header("Location: ../register.php");
                exit();
        }
    }else{
        $_SESSION['reg_error'] = "Wypełnij wszystkie pola";
        header("Location: ../register.php");
        exit();
    }

    $conn->close();
?>