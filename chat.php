<?php
    session_start();

    // if(!isset($_SESSION['logged']) && $_SESSION['logged'] != true)
    // {
    //     header("Location: index.php");
    //     exit();
    // }
    if(!isset($_COOKIE['logged']) && $_COOKIE['logged'] != true)
    {
        header("Location: index.php");
        exit();
    }

    require_once("php/connect.php");
    // require_once("php/paths.php");

    $id = $_SESSION['id'];
    $name = "SELECT user, fname, lname, img FROM users WHERE id=$id";

    $query = mysqli_query($conn, $name);

    while($row = mysqli_fetch_assoc($query)){
        $login = $row['user'];
        $fname = $row['fname'];
        $lname = $row['lname'];
        $img = $row['img'];
    }
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Czat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="css/chat.css">
    <link rel="stylesheet" href="css/offcanvas.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark" aria-label="Main navigation">
        <div class="container-fluid">
            <a class="navbar-brand" href="">Sender2</a>
            <button class="navbar-toggler p-0 border-0" type="button" id="navbarSideCollapse" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="navbar-collapse offcanvas-collapse" id="navbarsExampleDefault">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="chat.php">Czaty</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="profile.php?id=<?php echo $id ?>">Mój profil</a>
                </li>
                <!-- <li class="nav-item">
                    <a class="nav-link" href="#">Switch account</a>
                </li> -->
                <li class="nav-item">
                    <a class="nav-link" href="settings.php">Ustawienia</a>
                </li>
            </ul>
            <form class="d-flex" role="search" action="search.php">
                <input class="form-control me-2" type="search" placeholder="Login/ID" aria-label="Login/ID" name="search_user" minlength="4">
                <button class="btn btn-outline-success" type="submit">Szukaj</button>
            </form>
                <a class="btn-outline-succes logout" href="php/logout.php"><button class="btn btn-outline-success" type="submit">Wyloguj</button></a>
            </div>
        </div>
    </nav>
    <main class="container">
        <div class="d-flex align-items-center p-3 my-3 text-white bg-purple rounded shadow-sm">
            <img class="me-3 rounded-circle photo-profile" src="images/<?php echo $img ?>" alt="" width="48" height="48">
            <div class="lh-1">
                <h1 class="h6 mb-0 text-white lh-1"><?php
                    echo $login."<br>";
                    echo $fname." ".$lname;
                ?></h1>
                <!-- <small>Aktywny(a) teraz</small> -->
            </div>
        </div>
        <div class="my-3 p-3 bg-body rounded shadow-sm allchats">
            <h6 class="border-bottom pb-2 mb-0">Rozmowy</h6>
            <div class="div-allchats">
                
            </div>
        </div>

        <div class="my-3 p-3 bg-body rounded shadow-sm allfriends">
            <h6 class="border-bottom pb-2 mb-0">Znajomi</h6>
            <div class="div-allfriends">

            </div>
            <!-- <div class="d-flex text-muted pt-3">
                <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#007bff"/><text x="50%" y="50%" fill="#007bff" dy=".3em">32x32</text></svg>
                <div class="pb-3 mb-0 small lh-sm border-bottom w-100">
                    <div class="d-flex justify-content-between">
                        <strong class="text-gray-dark">Full Name</strong>
                        <a href="#">Follow</a>
                    </div>
                    <span class="d-block">@username</span>
                </div>
            </div> -->
            <!-- <small class="d-block text-end mt-3">
            <a href="#">Wyświetl więcej</a>
            </small> -->
        </div>


    </main>

    <script src="https://getbootstrap.com/docs/5.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

    <script src="javascript/offcanvas.js"></script>
    <script src="javascript/chats.js"></script>
</body>
</html>