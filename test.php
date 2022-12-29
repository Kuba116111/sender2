<?php
require_once "php/verify.php";
$email = 'gnito320@gmail.com';
$temat = 'Weryfikacja adesu e-mail';

// weryfikacja($email, $temat, 'verify');

if(isset($_SESSION['verify']) && $_SESSION['verify'] == true)
{
    echo "ok";
    unset($_SESSION['verify']);
}else{
    weryfikacja($email, $temat, 'verify', '../test.php');
    echo "nieok";
}

?>

<!-- <button type="submit" action>Weryfikuj</button> -->