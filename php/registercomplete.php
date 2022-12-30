<?php
    session_start();

    require_once "connect.php";
    // require_once "verify.php";

    // echo $_SESSION['verify'];

    if(isset($_SESSION['verify']) && $_SESSION['verify'] == true)
    {
        // echo 1;
        unset($_SESSION['verify']);

        $id = $_SESSION['id'];

        $sql = "UPDATE `users` SET `verified`='yes' WHERE `id` = $id";
        mysqli_query($conn, $sql);

        $_SESSION['logged'] = true;
        // echo "success";
        
        setcookie('logged', true, 0, "/");
        
        unset($_SESSION['frlogin']);
        unset($_SESSION['fremail']);
        unset($_SESSION['reg_error']);
        header("Location: ../chat.php");
        // exit();
    }

    $conn->close();
?>