<?php
    $error = $_SERVER["REDIRECT_STATUS"];

    if($error == 404)
    {
        $text = "Strony nie znaleziono";
    }
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        $text;
    ?>
</body>
</html>