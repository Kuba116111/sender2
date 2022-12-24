<?php
    session_start();
    unset($_SESSION['logged']);
    // unset($_COOKIE['logged']);
    setcookie('logged', "", time() -3600, "/");
    
    header("Location: ../index.php");
    session_destroy();
?>