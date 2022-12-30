<?php
    session_start();

    // if(isset($_SESSION['logged']) && $_SESSION['logged'] = true)
    // {
    //     header("Location: chat.php");
    //     exit();
    // }
    if(isset($_COOKIE['logged']) && $_COOKIE['logged'] = true)
    {
        header("Location: chat.php");
        exit();
    }

?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sender2 | Logowanie</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
    <main class="form-signin w-100 m-auto">
        <form method="post" action="php/login.php">
            <!-- <img class="mb-4" src="/docs/5.2/assets/brand/bootstrap-logo.svg" alt="" width="72" height="57"> -->
            <h1 class="h3 mb-3 fw-normal">Zaloguj się</h1>
        
            <div class="form-floating">
                <input type="text" class="form-control" id="floatingInput" placeholder="Marek123" name="login" value="<?php
                if(isset($_SESSION['frlogin'])){
                    echo $_SESSION['frlogin'];
                }
                ?>">
                <label for="floatingInput">Login</label>
            </div>
            <div class="form-floating">
                <input type="password" class="form-control" id="floatingPassword" placeholder="Hasło" name="password">
                <label for="floatingPassword">Hasło</label>
            </div>
            <!-- <div class="checkbox mb-3">
                <label>
                <input type="checkbox" value="remember-me"> Zapamiętaj mnie
                </label>
            </div> -->
            <p class="error">
                <?php
                    if(isset($_SESSION['index_error'])){
                    echo $_SESSION['index_error'];
                    }
                    // echo $_COOKIE['logged'];
                ?>
            </p>
          <button class="w-100 btn btn-lg btn-primary" type="submit">Zaloguj</button>
        </form>
        <p><a href="resetpassword">Nie pamiętam hasła</a></p>
        <br>
        <p>Nie masz konta? <a href="register.php"><button type="button" class="btn btn-outline-secondary btn-lg px-2">Kliknij tutaj aby je utworzyć</button></a></p>
        <p class="mt-5 mb-3 text-muted">&copy; 2022</p>
      </main>
</body>
</html>