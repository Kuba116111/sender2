<?php
    session_start();

    // if(isset($_COOKIE['logged']) && $_COOKIE['logged'] = true)
    // {
    //     header("Location: ../chat.php");
    //     exit();
    // } else {
    //     header("Location: ../index.php");
    //     exit();
    // }

    include_once "connect.php";

    $_SESSION['reg_error'] = '';

    // $conn = new mysqli($host,$db_user,$db_password,$db_name);

    // $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $password1 = mysqli_real_escape_string($conn, $_POST['password1']);
    $login = mysqli_real_escape_string($conn, $_POST['login']);

    $_SESSION['frlogin'] = $login;
    $_SESSION['frfname'] = $fname;
    $_SESSION['fremail'] = $email;


    require_once "verify.php";

    function verify() {
        // $temat = 'Weryfikacja adesu e-mail';
        // if(isset($_SESSION['verify']) && $_SESSION['verify'] == true)
        // {
        //     unset($_SESSION['verify']);

        //     $_SESSION['logged'] = true;
        //     // echo "success";
            
        //     setcookie('logged', true, 0, "/");
            
        //     unset($_SESSION['frlogin']);
        //     unset($_SESSION['fremail']);
        //     unset($_SESSION['reg_error']);
        //     header("Location: ../chat.php");
        //     exit();
        // }else{
        //     weryfikacja($email, $temat, 'verify', 'register.php');
        // }
    }
    
    
    
    
    // $_SESSION['reg_error'] = "tu";
    if(!empty($email) && !empty($password) && !empty($login) && !empty($fname)){
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
                                    if(move_uploaded_file($tmp_name,"../images/users/".$new_img_name)){
                                        if(isset($_POST['accept'])){
                                            $status = "Aktywny(a) teraz";
                                            $encrypt_pass = password_hash($password, PASSWORD_DEFAULT);
                                            $date = date("d.m.Y");
                                            $insert_query = mysqli_query($conn, "INSERT INTO users (id, user, fname, lname, email, pass, img, status, date, theme, groups, verified)
                                            VALUES ('{$ran_id}', '{$login}', '{$fname}', NULL, '{$email}', '{$encrypt_pass}', '{$new_img_name}', NULL, '{$date}', 'white', ',', 'no')");
                                            if($insert_query){
                                                $select_sql2 = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
                                                if(mysqli_num_rows($select_sql2) > 0){
                                                    $result = mysqli_fetch_assoc($select_sql2);
                                                    
                                                    $_SESSION['id'] = $result['id'];
                                                    // $_SESSION['logged'] = true;
                                                    // // echo "success";

                                                    // setcookie('logged', true, 0, "/");
                    
                                                    // unset($_SESSION['frlogin']);
                                                    // unset($_SESSION['fremail']);
                                                    // unset($_SESSION['reg_error']);
                                                    // header("Location: ../chat.php");
                                                    // exit();

                                                    // verify();

                                                    $temat = 'Weryfikacja adesu e-mail';

                                                    weryfikacja($email, $temat, 'verify', 'registercomplete.php');
                                                    
                                                }else{
                                                    $_SESSION['reg_error'] = "Coś poszło nie tak, spróbuj ponownie później";
                                                    header("Location: ../register.php");
                                                    exit();
                                                }
                                                    // $_SESSION['reg_error'] = "123";
                                            }else{
                                                $_SESSION['reg_error'] = "Coś poszło nie tak, spróbuj ponownie później";
                                                header("Location: ../register.php");
                                                exit();
                                            }
                                        }else{
                                            $_SESSION['reg_error'] = "Zaakceptuj regulamin";
                                            header("Location: ../register.php");
                                            exit();
                                        }
                                    }
                                }else{
                                    $_SESSION['reg_error'] = "Obsługiwane formaty obrazów - jpeg, png, jpg";
                                    header("Location: ../register.php");
                                    exit();
                                }
                            }else{
                                $_SESSION['reg_error'] = "Prześlij swój awatar. Prawidłowe formaty - jpeg, png, jpg";
                                header("Location: ../register.php");
                                exit();
                            }
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