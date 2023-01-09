<?php
    session_start();

    if(!isset($_SESSION['verify']) && $_SESSION['verify'] !== true)
    {
        header("Location: index.php");
        exit();
    }
?>

<!doctype html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Resetowanie hasła</title>

    <link href="https://getbootstrap.com/docs/5.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <link href="css/index.css" rel="stylesheet">
</head>
<body class="text-center">  
    <main class="form-signin w-100 m-auto">
        <form method="POST" action="php/resetpasswordcomplete.php">
            <h1 class="h3 mb-3 fw-normal">Resetowanie hasła</h1>

            <div class="form-floating mb-1">
                <input type="password" class="form-control" id="floatingPassword" placeholder="name@example.com" name="password">
                <label for="floatingPassword">Wprowadź nowe hasło</label>
            </div>
            <div class="form-floating mb-1">
                <input type="password" class="form-control" id="floatingPassword" placeholder="name@example.com" name="password1">
                <label for="floatingPassword">Powtórz nowe hasło</label>
            </div>
            <p class="error">
                <?php
                    if(isset($_SESSION['resetpassword_error'])){
                    echo $_SESSION['resetpassword_error'];
                    }
                    // echo $_COOKIE['logged'];
                ?>
            </p>
            <button class="w-100 btn btn-lg btn-primary" type="submit">Ustaw nowe hasło</button>
        </form> 
    </main>
</body>
</html>