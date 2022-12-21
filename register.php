<?php
  session_start();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sender2 | Rejestracja</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
    <main class="form-signin w-100 m-auto">
        <form method="post" action="php/register.php" enctype="multipart/form-data">
          <!-- <img class="mb-4" src="/docs/5.2/assets/brand/bootstrap-logo.svg" alt="" width="72" height="57"> -->
          <h1 class="h3 mb-3 fw-normal">Utwórz konto</h1>
          <div class="form-floating">
            <input type="text" class="form-control" id="floatingInput" placeholder="marek" name="login" value="<?php
                if(isset($_SESSION['frlogin'])){
                    echo $_SESSION['frlogin'];
                }
                ?>" minlength="8" required>
            <label for="floatingInput">Nazwa użytkownika</label>
          </div>
          <div class="form-floating">
            <input type="text" class="form-control" id="floatingInput" placeholder="marek" name="fname" value="<?php
                if(isset($_SESSION['frfname'])){
                    echo $_SESSION['frfname'];
                }
                ?>" required>
            <label for="floatingInput">Imię</label>
          </div>
          <!-- <div class="form-floating">
            <input type="text" class="form-control" id="floatingInput" placeholder="marek">
            <label for="floatingInput">Nazwisko</label>
          </div> -->
          <div class="form-floating">
            <input type="email" class="form-control" id="floatingInput" placeholder="imie@przyklad.com" name="email" value="<?php
                if(isset($_SESSION['fremail'])){
                    echo $_SESSION['fremail'];
                }
                ?>" required>
            <label for="floatingInput">Adres e-mail</label>
          </div>
          <div class="form-floating">
            <input type="password" class="form-control" id="floatingPassword" placeholder="Hasło" name="password" required>
            <label for="floatingPassword">Hasło</label>
          </div>
          <div class="form-floating">
            <input type="password" class="form-control" id="floatingPassword" placeholder="Powtórz hasło" name="password1" required>
            <label for="floatingPassword">Powtórz hasło</label>
          </div>
          <div class="mb-3">
            <label for="floatingFile">Wybierz awatar</label>
            <input type="file" class="form-control" id="floatingFile" name="image" accept="image/x-png,image/gif,image/jpeg,image/jpg">
          </div>
          
          <div class="checkbox mb-3">
            <label>
              <input type="checkbox" name="accept"> Akceptuję <a href="terms-and-conditions.php">regulamin</a>
            </label>
          </div>
          <p class="error">
          <?php
              if(isset($_SESSION['reg_error'])){
              echo $_SESSION['reg_error'];
              }
          ?>
        </p>
          <button class="w-100 btn btn-lg btn-primary" type="submit">Utwórz konto</button>
        </form>
        <br>
        <p>Masz już konto? <a href="index.php"><button type="button" class="btn btn-outline-secondary btn-lg px-2">Kliknij tutaj aby się zalogować</button></a></p>
        <p class="mt-5 mb-3 text-muted">&copy; 2022</p>
      </main>
</body>
</html>