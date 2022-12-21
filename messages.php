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
    <!-- <link rel="stylesheet" href="css/chat.css"> -->
    <link rel="stylesheet" href="css/messages.css">
    <link rel="stylesheet" href="css/offcanvas.css">
    
</head>
<body onload="scrollToBottom()">
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
            <?php
                if(!empty($_GET['chatid']) && !empty($_GET['userid'])){
                    $chat_id = $_GET['chatid'];
                    $user_id = $_GET['userid'];
                    echo '<form action="#" class="chat-user-id"><input type="text" id="chat_id" name="chat_id" value="'.$chat_id.'" hidden>';
                    echo '<input type="text" id="user_id" name="user_id" value="'.$user_id.'" hidden></form>';
                    // include_once('php/messages.php');
                }else{
                    echo "Coś poszło nie tak";
                }

                // echo $_SESSION['messages'];
            ?>
        <div class="container messages" id="featured-3">
            <!-- <div class="mb-5"></div> -->
        </div>
        
        <div class="fixed-bottom container">
            <form class="col-12 m-auto row formsendmessage">
                <div class="form-floating col-8">
                    <!-- <input type="text" class="form-control" id="floatingMessage" placeholder="Treść wiadomości" name="message"> -->
                    <textarea class="form-control" id="floatingMessage" placeholder="Treść wiadomości" name="message" required></textarea>
                    <label for="floatingPassword">Treść wiadomości</label>
                </div>
                <button class="btn btn-lg btn-primary col-4 sendbtn" type="submit">Wyślij</button>
                <input type="text" id="user_id1" name="user_id" value="<?php echo $user_id ?>" hidden>
                <input type="text" id="chat_id1" name="chat_id" value="<?php echo $chat_id ?>" hidden>
                <!-- <input type="datetime" id="datetime" name="datetime" value="" hidden> -->
                <!-- <input type="text" id="chat_id1" name="chat_id" value="<?php echo $chat_id ?>" hidden> -->
            </form>
        </div>
    </main>

    <script src="https://getbootstrap.com/docs/5.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    
    <script src="javascript/offcanvas.js"></script>
    <script src="javascript/messages.js"></script>
</body>
</html>