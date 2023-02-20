<!doctype html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.108.0">
    <title>Weryfikacja</title>
    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/sign-in/">
    <link href="https://getbootstrap.com/docs/5.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
 
    <!-- Custom styles for this template -->
    <link href="https://getbootstrap.com/docs/5.3/examples/sign-in/sign-in.css" rel="stylesheet">

    <style>
        .error {
            color: red;
        }
    </style>
</head>
<body class="text-center">   
    <main class="form-signin w-100 m-auto">
    <form method="post" action="php/verify.php">
        <h1 class="h3 mb-3 fw-normal">Na podany adres e-mail został wysłany kod weryfikacyjny</h1>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="floatingInput" placeholder=" " name="verifycode">
            <label for="floatingInput">Kod weryfikacyjny</label>
        </div>
        <button class="w-100 btn btn-lg btn-primary" type="submit">Weryfikuj</button>
    </form>
    <?php
        // require_once "php/verify.php";
        // if(weryfikacja2($_GET["verify"])==true)
        // {
        //     echo '<h1 class="h3 mb-3 fw-normal">Adres e-mail został zweryfikowany, możesz zamknąc to okno</h1>';
        // }
        session_start();
        echo $_SESSION['return'];
        echo (!isset($_SESSION['verifyerror']) ? '' : $_SESSION['verifyerror']);
    ?>
    
    </main>
</body>
</html>
