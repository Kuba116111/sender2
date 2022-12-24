<?php
    session_start();

    if(isset($_COOKIE['logged']) && $_COOKIE['logged'] = true)
    {
        header("Location: ../chat.php");
        exit();
    } else {
        header("Location: ../index.php");
        exit();
    }

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
                                    if(move_uploaded_file($tmp_name,"../images/".$new_img_name)){
                                        if(isset($_POST['accept'])){
                                            $status = "Aktywny(a) teraz";
                                            $encrypt_pass = password_hash($password, PASSWORD_DEFAULT);
                                            $date = date("d.m.Y");
                                            $insert_query = mysqli_query($conn, "INSERT INTO users (id, user, fname, lname, email, pass, img, status, date)
                                            VALUES ('{$ran_id}', '{$login}', NULL, NULL, '{$email}', '{$encrypt_pass}', '{$new_img_name}', NULL, '{$date}')");
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