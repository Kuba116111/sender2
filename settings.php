<?php
    session_start();

    if(!isset($_COOKIE['logged']) && $_COOKIE['logged'] != true)
    {
        header("Location: index.php");
        exit();
    }

    require_once("php/connect.php");
    // require_once("php/paths.php");

    $id = $_SESSION['id'];
    $name = "SELECT user, fname, lname, email, img FROM users WHERE id=$id";

    $query = mysqli_query($conn, $name);

    while($row = mysqli_fetch_assoc($query)){
        $login = $row['user'];
        $fname = $row['fname'];
        $lname = $row['lname'];
        $email = $row['email'];
        $img = $row['img'];
    }
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ustawienia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="css/<?php echo $d; ?>settings.css"> -->
    <link rel="stylesheet" href="css/settings.css">
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
                    <a class="nav-link" href="chat.php">Czaty</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="profile.php?id=<?php echo $id ?>">Mój profil</a>
                </li>
                <!-- <li class="nav-item">
                    <a class="nav-link" href="#">Switch account</a>
                </li> -->
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="settings.php">Ustawienia</a>
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
        <div class="col-md-7 col-lg-8">
            <!-- <button onclick="kolor()">Test</button>  -->
            <h4 class="mb-3">Zmień dane konta</h4>
            <hr class="my-4">
            <form id="chpassword" class="needs-validation" method="post" action="php/chpassword.php">
                <h5 class="mb-3">Zmień hasło</h5>
                <div class="col-sm-12">
                    <label for="password" class="form-label">Aktualne hasło</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                    <label for="chpassword1" class="form-label">Nowe hasło</label>
                    <input type="password" class="form-control" id="chpassword1" name="chpassword1" required>
                    <label for="chpassword2" class="form-label">Powtórz nowe hasło</label>
                    <input type="password" class="form-control" id="chpassword2" name="chpassword2" required>
                </div>
                <br>
                <button class="w-100 btn btn-primary btn-lg" type="submit">Zatwierdź zmiany</button>
                <!-- <button class="w-100 btn btn-primary btn-lg" type="submit" onclick="fnChPasswordError()">Zatwierdź zmiany</button> -->
                <div id="div-chpassword">
                    <?php
                        if(isset($_SESSION['chpassword_error'])){
                        echo $_SESSION['chpassword_error'];
                        }
                    ?>
                </div>
            </form>
            <hr class="my-4">
            <form id="chdata" class="needs-validation" novalidate method="post" action="php/chdata.php">
                <h5 class="mb-3">Zmień informacje o koncie</h5>
                <span class="text-muted">Zmiany zostaną wprowadzone tylko dla pól ktorych wartości zostały zmienione</span>
                <div class="col-12">
                    <label for="username" class="form-label">Nazwa użytkownika <span class="text-muted">(nie można zmienić)</span></label>
                    <div class="input-group has-validation">
                        <span class="input-group-text">@</span>
                        <input type="text" class="form-control" id="username" placeholder="<?php echo $login ?>" disabled>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-sm-6">
                        <label for="firstName" class="form-label">Imię</label>
                        <input type="text" class="form-control" id="firstName" name="fname" value="<?php echo $fname ?>">
                    </div>
                    
                    <div class="col-sm-6">
                        <label for="lastName" class="form-label">Nazwisko</label>
                        <input type="text" class="form-control" id="lastName" name="lname" value="<?php echo $lname ?>">
                    </div>
                    
                    <div class="col-12">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo $email ?>" required>
                    </div>
                    
                    <button class="w-100 btn btn-primary btn-lg" type="submit">Zatwierdź zmiany</button>
                    <div id="div-chdata">
                        <?php
                            if(isset($_SESSION['chdata_error'])){
                            echo $_SESSION['chdata_error'];
                            }
                        ?>
                    </div>
                </form>
                <hr class="my-4">
                <form id="chavatar" class="needs-validation" method="post" action="php/chavatar.php" enctype="multipart/form-data">
                <h5 class="mb-3">Zmień awatar</h5>
                <div class="mb-4">
                    <label for="floatingFile">Wybierz nowy awatar</label>
                    <input type="file" class="form-control" id="floatingFile" name="image" accept="image/x-png,image/gif,image/jpeg,image/jpg">
                </div>
                <button class="w-100 btn btn-primary btn-lg" type="submit">Zmień awatar</button> 
                <div id="div-chavatar">
                    <?php
                        if(isset($_SESSION['chavatar_error'])){
                        echo $_SESSION['chavatar_error'];
                        }
                    ?>
                </div>
            </form>
        </div>
        <hr class="my-4">
        <div>
            <form id="chtheme" class="needs-validation" method="post" action="php/chtheme.php">
                <h5 class="mb-3">Zmień motyw</h5>
                <div class="col-sm-12">
                    <label for="motyw" class="form-label">Wybierz motyw<p class="text-muted">Funkcja dostępna już wkrótce</p></label>
                    <select class="form-control" name="motyw" id="motyw" disabled>
                        <option value="white">Jasny</option>
                        <option value="black">Ciemny</option>
                        <option value="Schoko-Bons">Schoko-Bons</option>
                    </select>
                </div>
                <br>
                <button class="w-100 btn btn-primary btn-lg" type="submit" disabled>Zatwierdź zmiany</button>
                <!-- <button class="w-100 btn btn-primary btn-lg" type="submit" onclick="fnChPasswordError()">Zatwierdź zmiany</button> -->
            </form>
        </div>
        <br>
        <p>Wersja <i>0.1.12.22</i></p>
    </main>

    <script src="https://getbootstrap.com/docs/5.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

    <script src="javascript/offcanvas.js"></script>
    <script src="javascript/settings.js"></script>
</body>
</html>