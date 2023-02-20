<?php
    session_start();

    if(!isset($_COOKIE['logged']) && $_COOKIE['logged'] != true)
    {
        header("Location: index.php");
        exit();
    }

    require_once("php/connect.php");
    // require_once("php/paths.php");

    if(!empty($_GET['groupid'])){
        $group_id = $_GET['groupid'];

        $id = $_SESSION['id'];
        $name = "SELECT user, fname, lname, img, role FROM users,groups_members WHERE users.id=$id AND group_id=$group_id AND users.id=user_id";
    
        $query = mysqli_query($conn, $name);

        $short_group_name='';
        $group_img='';
        $menu='';

        if(mysqli_num_rows($query)>0){
            while($row = mysqli_fetch_assoc($query)){
                $login = $row['user'];
                $fname = $row['fname'];
                $lname = $row['lname'];
                $img = $row['img'];
                $role = $row['role'];
            }
        
            if($role=='administrator'){
                $menu = '<li class="nav-item dropdown">
                            <button class="btn nav-link dropdown-toggle" data-bs-toggle="dropdown" type="button">Grupa</button>
                            <ul class="dropdown-menu">
                                <li><button id="btn-manage-group" class="dropdown-item" onclick="manageGroup()">Zarządzaj grupą</button></li>
                                <hr>
                                <li><button id="btn-leave-group" class="dropdown-item">Opuść grupę</button></li>
                                <li><button id="btn-delete-group" class="dropdown-item" onclick="btnDeleteGroup()">Usuń grupę</button></li>
                            </ul>
                        </li>';
            }elseif($role=='member') {
                $menu = '<li class="nav-item dropdown">
                            <button class="btn nav-link dropdown-toggle" data-bs-toggle="dropdown" type="button">Grupa</button>
                            <ul class="dropdown-menu">
                                <li><button id="btn-leave-group" class="dropdown-item">Opuść grupę</button></li>
                            </ul>
                        </li>';
            }
    
            $group_info_sql = "SELECT group_name, img, members FROM groups WHERE group_id = $group_id";
            $group_info_query = mysqli_query($conn, $group_info_sql);
            while ($group_info_row = mysqli_fetch_assoc($group_info_query)) {
                $group_name = $group_info_row['group_name'];
                $group_img = $group_info_row['img'];
                $group_members = $group_info_row['members'];
            }
    
            (strlen($group_name) > 28) ? $short_group_name =  substr($group_name, 0, 28) . '...' : $short_group_name = $group_name;
        }
    
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
            <a class="navbar-brand" href="chat.php">Sender2</a>
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
                    <!-- <li class="nav-item">
                        <button class="nav-link bg-dark border-0">Zarządzanie grupą</button>
                    </li> -->
                    <?php
                        echo $menu;
                    ?>
                    <li class="nav-item">
                        <!-- <div class="d-flex">
                            <img class="photo-profile" src="images/groups/<?php echo $group_img; ?>" alt="<?php echo $group_name; ?>">
                            <p class="groupname"><?php echo $group_name; ?></p>

                        </div> -->
                        <div class="d-flex align-items-center text-white ms-5 rounded shadow-sm">
                            <img class="me-3" src="images/<?php echo $group_img; ?>" alt="" width="48" height="38">
                            <div class="lh-1">
                            <h1 class="h6 mb-0 text-white lh-1 p-2"><?php echo $short_group_name; ?></h1>
                            </div>
                        </div>
                    
                    </li>
                </ul>
                <!-- <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
                </ul> -->
                <form class="d-flex" role="search" action="search.php">
                    <input class="form-control me-2" type="search" placeholder="Login/ID" aria-label="Login/ID" name="search_user" minlength="4">
                    <button class="btn btn-outline-success" type="submit">Szukaj</button>
                </form>
                <a class="btn-outline-succes logout" href="php/logout.php"><button class="btn btn-outline-success" type="submit">Wyloguj</button></a>
            </div>
        </div>
    </nav>
    
    <main class="container">
        <div class="divmanagegroup" id="divmanagegroup">
            <div class="modal modal-tour position-static d-block py-5" tabindex="-1" role="dialog" id="modalTour">
                <div class="modal-dialog modal-dialog-scrollable" role="document">
                    <div class="modal-content rounded-4 shadow">
                        <h2 class="modal-header fw-bold mx-0">Zarządzanie grupą</h2>
                        <div class="modal-body p-3 pt-0 border-bottom border-2">
                            <span class="text-muted">Zmiany zostaną wprowadzone tylko jeśli wartości zostały zmienione</span>
                            <ul class="d-grid list-unstyled">
                                <li class="d-flex">
                                    <div class="w-100">
                                        <form id="chgroupname" class="needs-validation form-groupsettings" novalidate method="post" action="php/chgroupname.php">
                                            <h5 class="mb-3">Zmień nazwę grupy</h5>
                                            <div class="mb-2">
                                                <input type="text" class="form-control" id="groupName" name="group-name" placeholder="Nazwa grupy" value="<?php echo $group_name; ?>">
                                                <input type="text" class="form-control" id="groupId" name="group-id" value="<?php echo $group_id; ?>" hidden>
                                            </div>
                                            <button class="w-100 btn btn-primary btn-lg" id="btn-chgroupname" type="submit">Zatwierdź zmiany</button>
                                            <div id="div-chgroupname">
                                                <!-- <?php
                                                    if(isset($_SESSION['chgroupname_error'])){
                                                        echo $_SESSION['chgroupname_error'];
                                                    }
                                                    ?> -->
                                            </div>
                                        </form>
                                    </div>
                                </li>
                                <hr>
                                <li class="d-flex">
                                    <div class="w-100">
                                        <form id="chgroupimg" class="needs-validation form-groupsettings" method="post" action="php/chgroupimg.php" enctype="multipart/form-data">
                                            <h5 class="mb-3">Zmień zdjęcie grupy</h5>
                                            <div class="mb-4">
                                                <label for="floatingFile">Wybierz nowe zdjęcie grupy</label>
                                                <input type="file" class="form-control" id="floatingFile" name="image" accept="image/x-png,image/gif,image/jpeg,image/jpg">
                                                <input type="text" class="form-control" id="groupId" name="group-id" value="<?php echo $group_id; ?>" hidden>
                                            </div>
                                            <button class="w-100 btn btn-primary btn-lg" id="btn-chgroupimg" type="submit">Zmień zdjęcie grupy</button> 
                                            <div id="div-groupimg">
                                                <!-- <?php
                                                    if(isset($_SESSION['chgroupimg_error'])){
                                                    echo $_SESSION['chgroupimg_error'];
                                                    }
                                                ?> -->
                                            </div>
                                        </form>
                                    </div>
                                </li>
                                <hr>
                                <li class="d-flex gap-4 mb-2">
                                    <div>
                                        <h5 class="mb-2">Członkowie grupy: </h5>
                                    </div>
                                </li>
                                <li class="d-flex">
                                    <div class="dropdown-menu d-block position-static pt-0 mx-0 rounded-3 shadow overflow-hidden w-100">
                                        <input type="search" id="search_user_in_group" class="form-control" placeholder="Wyszukaj użytkowników...">
                                        <ul class="list-unstyled mb-0" id="list_users_in_group">
                                            <!-- <?php echo $group_members; ?> -->
                                        </ul>
                                    </div>
                                </li>
                                <li class="d-flex">
                                    <div>
                                        <div class="group-members"></div>
                                    </div>
                                </li>
                                <input type="text" name="members" id="members_id" value="" hidden="">
                                
                            </ul>
                        </div>
                        <button type="button" id="btn-close-group-manager" class="btn btn-lg btn-link fs-6 text-decoration-none m-0 rounded-0" data-bs-dismiss="modal">Wyjdź</button>
                        <!-- <div class="modal-footer flex-nowrap p-0">
                        </div>                         -->
                    </div>
                </div>
            </div>
        </div>
        <div class="divleavegroup">
            <div class="modal modal-tour position-static d-block py-5" tabindex="-1" role="dialog" id="modalTour">
                <div class="modal-dialog" role="document">
                    <div class="modal-content rounded-4 shadow">
                        <div class="modal-content rounded-3 shadow">
                            <div class="modal-body p-4 text-center">
                              <h5 class="mb-0">Potwierdź opuszczenie grupy <?php echo $group_name; ?></h5>
                              <p class="mb-0">Jeśli jesteś jedynym administratorem grupy upewnij się że przemyślałeś co robisz</p>
                            </div>
                            <div class="modal-footer flex-nowrap p-0">
                              <button type="button" id="btn-confirm-leave-group" class="btn btn-danger rounded-0 border-end"><strong>Wiem co robię, zabierz mnie stąd</strong></button>
                              <button type="button" id="btn-close-leave-group" class="btn btn-lg btn-link fs-6 text-decoration-none col-6 m-0 rounded-0" data-bs-dismiss="modal">Jednak chcę tu jeszcze zostać</button>
                            </div>
                          </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="divdeletegroup">
            <div class="modal modal-tour position-static d-block py-5" tabindex="-1" role="dialog" id="modalTour">
                <div class="modal-dialog" role="document">
                    <div class="modal-content rounded-4 shadow">
                        <div class="modal-content rounded-3 shadow">
                            <div class="modal-body p-4 text-center">
                              <h5 class="mb-0">Potwierdź usunięcie grupy <?php echo $group_name; ?></h5>
                              <p class="mb-0">Usunięcie grupy jest nieodwracalne więc upewnij się że przemyślałeś co robisz</p>
                            </div>
                            <div class="modal-footer flex-nowrap p-0">
                              <button type="button" id="btn-confirm-delete-group" class="btn btn-danger rounded-0 border-end"><strong>Wiem co robię, usuń grupę</strong></button>
                              <button type="button" id="btn-close-delete-group" class="btn btn-lg btn-link fs-6 text-decoration-none col-6 m-0 rounded-0" data-bs-dismiss="modal">Jednak się rozmyśliłem</button>
                            </div>
                          </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="divmodifyrolegroup">
            <div class="modal modal-tour position-static d-block py-5" tabindex="-1" role="dialog" id="modalTour">
                <div class="modal-dialog" role="document">
                    <div class="modal-content rounded-4 shadow">
                        <div class="modal-content rounded-3 shadow">
                            <div class="modal-body p-4 text-center">
                                <h5 class="mb-0">Potwierdź zmianę uprawnień użytkownika</h5>
                                <!-- <p class="mb-0">Usunięcie grupy jest nieodwracalne więc upewnij się że przemyślałeś co robisz</p> -->
                                <div class="modifyroleuser"></div>
                                    <select name="new-user-role" id="new-user-role" class="form-select form-select-sm new-user-role">

                                    </select>
                                </div>
                                <p class="p-modifyroleuser-error error"></p>
                            <div class="modal-footer flex-nowrap p-0">
                              <button type="button" id="btn-confirm-modify-role-group" onclick="confirmModifyRoleGroup()" class="btn btn-danger rounded-0 border-end"><strong>Modyfikuj uprawnienia użytkownika</strong></button>
                              <button type="button" id="btn-close-modify-role-group" onclick="closeModifyRoleGroup()" class="btn btn-lg btn-link fs-6 text-decoration-none col-6 m-0 rounded-0" data-bs-dismiss="modal">Jednak się rozmyśliłem</button>
                            </div>
                          </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="divdeleteuserfromgroup">
            <div class="modal modal-tour position-static d-block py-5" tabindex="-1" role="dialog" id="modalTour">
                <div class="modal-dialog" role="document">
                    <div class="modal-content rounded-4 shadow">
                        <div class="modal-content rounded-3 shadow">
                            <div class="modal-body p-4 text-center">
                                <h5 class="mb-0">Potwierdź usunięcie z grupy użytkownika:</h5>
                                <p class="p-deleteuserfromgroup"></p>
                                <p class="p-deleteuserfromgroup-error error"></p>
                            </div>
                            <div class="modal-footer flex-nowrap p-0">
                              <button type="button" id="btn-confirm-delete-user-from-group" onclick="confirmDeleteUserFromGroup()" class="btn btn-danger rounded-0 border-end"><strong>Wiem co robię, usuń użytkownika</strong></button>
                              <button type="button" id="btn-close-delete-user-from-group" onclick="closeDeleteUserFromGroup()" class="btn btn-lg btn-link fs-6 text-decoration-none col-6 m-0 rounded-0" data-bs-dismiss="modal">Jednak się rozmyśliłem</button>
                            </div>
                          </div>
                    </div>
                </div>
            </div>
        </div>
    
        <?php
            if(!empty($_GET['groupid'])){
                $group_id = $_GET['groupid'];
                // $user_id = $_GET['userid'];
                echo '<form action="#" class="group-user-id"><input type="text" id="group_id" name="group_id" value="'.$group_id.'" hidden>';
                echo '</form>';
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
                <!-- <input type="text" id="user_id1" name="user_id" value="<?php echo $user_id ?>" hidden> -->
                <input type="text" id="group_id1" name="group_id" value="<?php echo $group_id ?>" hidden>
                <!-- <input type="datetime" id="datetime" name="datetime" value="" hidden> -->
                <!-- <input type="text" id="chat_id1" name="chat_id" value="<?php echo $chat_id ?>" hidden> -->
            </form>
        </div>
    </main>

    <script src="https://getbootstrap.com/docs/5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    
    <script src="javascript/offcanvas.js"></script>
    <script src="javascript/groups-messages.js"></script>
    <script src="javascript/groups.js"></script>
</body>
</html>