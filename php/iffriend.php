<?php
    // session_start();

    if(!isset($_COOKIE['logged']) && $_COOKIE['logged'] != true)
    {
        header("Location: ../index.php");
        exit();
    }

    $id = $_SESSION['id'];

    require_once("connect.php");

    // $page_id = mysqli_real_escape_string($conn, $_GET['id']);

    // $outgoing_id = $_SESSION['id'];

    $output = '';

    $sql = "SELECT * FROM users WHERE id = '{$id}'";
    $query = mysqli_query($conn, $sql);
    // $sql2 = "SELECT * FROM users WHERE id = '{$page_id}'";
    // $query2 = mysqli_query($conn, $sql2);

    while($row = mysqli_fetch_assoc($query))
    {
        // $output = '';
        $friends = $row['friends'];
        $newfriends = $row['friends'];

    }
    // while($row2 = mysqli_fetch_assoc($query2))
    // {
    //     // $output2 = '';
    //     $friends2 = $row2['friends'];
    //     $newfriends2 = $row2['friends'];

    // }

    $friends = explode(',',$friends);
    // $friends2 = explode(',',$friends2);
    foreach($friends as $one_friend)
    {
        // foreach($friends2 as $one_friend2)
        // {
            // if($i!==0) {
                if(($one_friend === $page_id))
                {
                    // echo 1;
                    $my_profile = '<div class="col-lg-20 col-md-20 mx-auto">';
                    $my_profile .= '<img class="bd-placeholder-img rounded-circle photo-profile" width="140" height="140" role="img" preserveAspectRatio="xMidYMid slice" focusable="false" src="images/users/'.$img.'">';
                    $my_profile .= '<h2 class="fw-normal">'.$login."<br>".$fname." ".$lname."</h2>";
                    $my_profile .= "<p>Data dołączenia: $date</p>";
                    $my_profile .= '<p><form action="php/delfriend.php" id="form-friend-id"><input type="text" name="friend-id" value="'.$id_user.'"><button type="submit" class="btn btn-secondary w-100" id="btn-del-friend">Usuń z grona znajomych znajomych &raquo;</button></form></p>';
                    $my_profile .= '<p><a class="btn btn-secondary w-100" href="php/newmessage.php?id='.$id_user.'">Napisz coś &raquo;</a></p>';
                    $my_profile .= '</div>';
                    echo $my_profile;
                    exit();         
                }
            // }
            
        // }
    }
    
    // $newfriends = $newfriends.','.$rand;                    
    // $newfriends2 = $newfriends2.','.$rand;
    
    // print_r($newfriends.$newfriends2);
    // $sql_update = "UPDATE `users` SET `friends`='{$newfriends}' WHERE `id` = '{$id}';";
    // $sql_update2 = "UPDATE `users` SET `friends`='{$newfriends2}' WHERE `id` = '{$user_id}';";
    // $query_update = mysqli_query($conn, $sql_update);
    // $query_update2 = mysqli_query($conn, $sql_update2);
    // header("Location: ../messages.php?chatid=$rand&userid=$user_id");
    
    $my_profile = '<div class="col-lg-20 col-md-20 mx-auto">';
    $my_profile .= '<img class="bd-placeholder-img rounded-circle photo-profile" width="140" height="140" role="img" preserveAspectRatio="xMidYMid slice" focusable="false" src="images/users/'.$img.'">';
    $my_profile .= '<h2 class="fw-normal">'.$login."<br>".$fname." ".$lname."</h2>";
    $my_profile .= "<p>Data dołączenia: $date</p>";
    $my_profile .= '<p><button class="btn btn-secondary w-100" id="btn-add-friend" value="'.$id_user.'">Dodaj do znajomych &raquo;</button></p>';
    $my_profile .= '<p><a class="btn btn-secondary w-100" href="php/newmessage.php?id='.$id_user.'">Napisz coś &raquo;</a></p>';
    $my_profile .= '</div>';
    echo $my_profile;

    $conn->close();
?>