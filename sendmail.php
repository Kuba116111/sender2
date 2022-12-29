<?php
if (mail("gnito320@gmail.com", "Temat wiadomosci", "Tresc wiadomosci", "From: sender2@vp.pl")) {
  echo "Wiadomość została wysłana";
} else {
  echo "Wystąpił błąd podczas wysyłania wiadomości";
}

?>