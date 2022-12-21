<?php
    session_start();

    if(!isset($_SESSION['logged']) && $_SESSION['logged'] != true)
    {
        header("Location: index.php");
        exit();
    }

    require_once("php/connect.php");
    // require_once("php/paths.php");

    $id = $_SESSION['id'];

    if (!empty($_GET['id'])) {
        $page_id = $_GET['id'];
    } else {
        $page_id = $id;
    }

    $name = "SELECT id, user, fname, lname, img, date FROM users WHERE id=$page_id";

    $query = mysqli_query($conn, $name);

    while($row = mysqli_fetch_assoc($query)){
        $id_user = $row['id'];
        $login = $row['user'];
        $fname = $row['fname'];
        $lname = $row['lname'];
        $img = $row['img'];
        $date = $row['date'];
    }
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="css/profile.css">
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
                        <a class="nav-link active" aria-current="page" href="profile.php?id=<?php echo $id ?>">Mój profil</a>
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
    <main>
        <?php 
            if($page_id === $id){
                $my_profile = '<div class="col-lg-10 col-md-20 mx-auto">';
                    $my_profile .= '<div class="profile"><img class="bd-placeholder-img rounded-circle photo-profile" width="140" height="140" role="img" preserveAspectRatio="xMidYMid slice" focusable="false" src="images/'.$img.'">';
                    $my_profile .= '<h2 class="fw-normal">'.$login."<br>".$fname." ".$lname."</h2>";
                    $my_profile .= "<p>Data dołączenia: $date</p>";
                    $my_profile .= '<p><button class="btn btn-secondary btn-show-link">Udostępnij link do swojego konta &raquo;</button></p></div>';
                    $my_profile .= '<div class="col div-link">
                                        <div class="card mb-4 rounded-3 shadow-sm">
                                            <div class="card-body">
                                                <p class="card-title">https://localhost/strony/sender2/profile.php?id='.$id.'</p>
                                                <input type="text" hidden class="profile-link" value="https://localhost/strony/sender2/profile.php?id='.$id.'">
                                                <button onclick="profilelinkcopy()" type="button" id="btn-profile-link" class="w-100 btn btn-lg btn-outline-primary">Kopiuj link</button>
                                                <br><br>
                                                <p class="card-title btn-profile-id">'.$id.'</p>
                                                <input type="text" hidden class="profile-id" value="'.$id.'">
                                                <button onclick="profileidcopy()" type="button" id="btn-profile-id" class="w-100 btn btn-lg btn-outline-primary">Kopiuj unikalny kod</button>
                                            </div>
                                        </div>
                                    </div>';
                $my_profile .= '</div>';
                echo $my_profile;
            }else{
                $my_profile = '<div class="col-lg-20 col-md-20 mx-auto">';
                    $my_profile .= '<img class="bd-placeholder-img rounded-circle photo-profile" width="140" height="140" role="img" preserveAspectRatio="xMidYMid slice" focusable="false" src="images/'.$img.'">';
                    $my_profile .= '<h2 class="fw-normal">'.$login."<br>".$fname." ".$lname."</h2>";
                    $my_profile .= "<p>Data dołączenia: $date</p>";
                    $my_profile .= '<p><a class="btn btn-secondary w-100" href="php/newmessage.php?id='.$id_user.'">Napisz coś &raquo;</a></p>';
                $my_profile .= '</div>';
                echo $my_profile;
            }
        ?>
        
    </main>

    <script src="https://getbootstrap.com/docs/5.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <script src="javascript/offcanvas.js"></script>
    <script src="javascript/profile.js"></script>
</body>
</html>