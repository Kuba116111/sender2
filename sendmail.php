<?php

$to = "pkuba04@wp.pl";
$subject = "Temat wiadomości";
$message = "Treść wiadomości";
$headers = "From: gnito320@gmail.com" . "\r\n" .
           "CC: pkuba04@wp.pl";

if (mail($to, $subject, $message, $headers)) {
  echo "Wiadomość została wysłana";
} else {
  echo "Wystąpił błąd podczas wysyłania wiadomości";
}

// print_r(phpinfo());

?>