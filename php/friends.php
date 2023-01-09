<?php
    session_start();

    if(!isset($_COOKIE['logged']) && $_COOKIE['logged'] != true)
    {
        header("Location: ../index.php");
        exit();
    }

    $id = $_SESSION['id'];

    require_once("connect.php");

    // $outgoing_id = $_SESSION['id'];

    // $sql = "SELECT chats,friends,friends_to_verify FROM users WHERE id = '{$id}'";
    // $query = mysqli_query($conn, $sql);
    
    // $output = "";
    // if(mysqli_num_rows($query) > 0) {
    //     while ($row = mysqli_fetch_assoc($query)) {
    //         $friends = $row['friends'];
    //         $friends_to_verify = $row['friends_to_verify'];
    //         $chats = $row['chats'];
            
    //         // echo $friends;
    //     }
    //     if ($friends_to_verify !== '') {
    //         $friends_to_verify2 = explode(',',$friends_to_verify);
    //         $i=0;
    //         foreach($friends_to_verify2 as $one_friend_to_verify)
    //         {
    //             if($i!==0) {
    //                 $sql2 = "SELECT * FROM users WHERE id = '{$one_friend_to_verify}'";
    //                 $query2 = mysqli_query($conn, $sql2);
    //                 while($row2 = mysqli_fetch_assoc($query2))
    //                 {
    //                     $user_id = $row2['id'];
    //                     $img = $row2['img'];
    //                     $fname = $row2['fname'];
    //                     $lname = $row2['lname'];
    //                     $user = $row2['user'];
    //                     $output .= '<a href="profile.php?id='.$one_friend_to_verify.'"><div class="d-flex text-muted pt-3">
    //                                 <img class="bd-placeholder-img rounded-circle me-2 rounded photo-profile" width="80" height="80" role="img" preserveAspectRatio="xMidYMid slice" focusable="false" src="images/'.$img.'">
    //                                 <div class="pb-3 mb-0 small lh-sm border-bottom w-100">
    //                                     <div class="d-flex justify-content-between">
    //                                         <strong class="text-gray-dark">'.$fname.' '.$lname.'</strong>
    //                                         <!--<a href="#">Zobacz</a> -->
    //                                         <span class="d-block">Potwierdź znajomość</span>
    //                                     </div>
    //                                 <span class="d-block">@'.$user.'</span>
    //                                 </div>
    //                             </div></a>';  
    //                 }
    //             }
    //             $i++;
    //         }
    //         $output .= "<hr>";
    //     }
    //     if ($friends !== '') {
    //         $friends2 = explode(',',$friends);
    //         $i=0;
    //         foreach($friends2 as $one_friend)
    //         {
    //             // $output .= '<a href="messages.php?chatid='.$one_chat.'&userid='.$one_friend.'"><div class="d-flex text-muted pt-3">
    //             //             <img class="bd-placeholder-img rounded-circle me-2 rounded photo-profile" width="80" height="80" role="img" preserveAspectRatio="xMidYMid slice" focusable="false" src="images/'.$img.'">
    //             //             <div class="pb-3 mb-0 small lh-sm border-bottom w-100">
    //             //                 <div class="d-flex justify-content-between">
    //             //                     <strong class="text-gray-dark">'.$fname.' '.$lname.'</strong>
    //             //                     <!--<a href="#">Zobacz</a>--->
    //             //                 </div>
    //             //             '//<span class="d-block">@'.$user.'</span><br>
    //             //             //<p>'.$you.$msg.'</p>
    //             //             .'</div>
    //             //         </div></a>';  

    //             if($i!==0) {
    //                 $sql2 = "SELECT * FROM users WHERE id = '{$one_friend}'";
    //                 $query2 = mysqli_query($conn, $sql2);
    //                 while($row2 = mysqli_fetch_assoc($query2))
    //                 {
    //                     $user_id = $row2['id'];
    //                     $img = $row2['img'];
    //                     $fname = $row2['fname'];
    //                     $lname = $row2['lname'];
    //                     $user = $row2['user'];
    //                     $output .= '<a href="php/newmessage.php?id='.$one_friend.'"><div class="d-flex text-muted pt-3">
    //                                 <img class="bd-placeholder-img rounded-circle me-2 rounded photo-profile" width="80" height="80" role="img" preserveAspectRatio="xMidYMid slice" focusable="false" src="images/'.$img.'">
    //                                 <div class="pb-3 mb-0 small lh-sm border-bottom w-100">
    //                                     <div class="d-flex justify-content-between">
    //                                         <strong class="text-gray-dark">'.$fname.' '.$lname.'</strong>
    //                                         <!--<a href="#">Zobacz</a>--->
    //                                     </div>
    //                                 <span class="d-block">@'.$user.'</span>'
    //                                 //<p>'.$you.$msg.'</p>
    //                                 .'</div>
    //                             </div></a>';  
    //                 }
    //             }
    //             $i++;
    //         }
    //     }else{
    //         $output .= "Nie masz potwierdzonych znajomości";
    //         // exit();
    //     }
    // }

    // echo $output;

    $sql_select_friend_to_verify = "SELECT * FROM friends WHERE (friend1_id = '{$id}' OR friend2_id = '{$id}') AND verify='no'";
    $query_select_friend_to_verify = mysqli_query($conn, $sql_select_friend_to_verify);
    
    $output = "";
    if(mysqli_num_rows($query_select_friend_to_verify) > 0) {
        while($row = mysqli_fetch_assoc($query_select_friend_to_verify)){
            $friend1_id = $row['friend1_id'];
            $friend2_id = $row['friend2_id'];
            $verify = $row['verify'];

            if($friend1_id === $id){
                $sql2 = "SELECT * FROM users WHERE id = '{$friend2_id}'";
                $query2 = mysqli_query($conn, $sql2);
                while($row2 = mysqli_fetch_assoc($query2))
                {
                    $user_id = $row2['id'];
                    $img = $row2['img'];
                    $fname = $row2['fname'];
                    $lname = $row2['lname'];
                    $user = $row2['user'];
                    $output .= '<a href="profile.php?id='.$user_id.'"><div class="d-flex text-muted pt-3">
                                <img class="bd-placeholder-img rounded-circle me-2 rounded photo-profile" width="80" height="80" role="img" preserveAspectRatio="xMidYMid slice" focusable="false" src="images/'.$img.'">
                                <div class="pb-3 mb-0 small lh-sm border-bottom w-100">
                                    <div class="d-flex justify-content-between">
                                        <strong class="text-gray-dark">'.$fname.' '.$lname.'</strong>
                                        <!--<a href="#">Zobacz</a> -->
                                        <span class="d-block">Oczekuje na potwierdzenie</span>
                                    </div>
                                <span class="d-block">@'.$user.'</span>
                                </div>
                            </div></a>';  
                }
            }else{
                $sql2 = "SELECT * FROM users WHERE id = '{$friend1_id}'";
                $query2 = mysqli_query($conn, $sql2);
                while($row2 = mysqli_fetch_assoc($query2))
                {
                    $user_id = $row2['id'];
                    $img = $row2['img'];
                    $fname = $row2['fname'];
                    $lname = $row2['lname'];
                    $user = $row2['user'];
                    $output .= '<a href="profile.php?id='.$user_id.'"><div class="d-flex text-muted pt-3">
                                <img class="bd-placeholder-img rounded-circle me-2 rounded photo-profile" width="80" height="80" role="img" preserveAspectRatio="xMidYMid slice" focusable="false" src="images/'.$img.'">
                                <div class="pb-3 mb-0 small lh-sm border-bottom w-100">
                                    <div class="d-flex justify-content-between">
                                        <strong class="text-gray-dark">'.$fname.' '.$lname.'</strong>
                                        <!--<a href="#">Zobacz</a> -->
                                        <span class="d-block">Potwierdź znajomość</span>
                                    </div>
                                <span class="d-block">@'.$user.'</span>
                                </div>
                            </div></a>';  
                }
            }
        }
            $output .= "<hr>";
    }

    $sql_select_friend = "SELECT * FROM friends WHERE (friend1_id = '{$id}' OR friend2_id = '{$id}') AND verify='yes'";
    $query_select_friend = mysqli_query($conn, $sql_select_friend);

    if(mysqli_num_rows($query_select_friend) > 0) {
        while($row = mysqli_fetch_assoc($query_select_friend)){
            $friend1_id = $row['friend1_id'];
            $friend2_id = $row['friend2_id'];
            $verify = $row['verify'];

            if($friend1_id === $id){
                $sql2 = "SELECT * FROM users WHERE id = '{$friend2_id}'";
            }else{
                $sql2 = "SELECT * FROM users WHERE id = '{$friend1_id}'";
            }
            $query2 = mysqli_query($conn, $sql2);
            while($row2 = mysqli_fetch_assoc($query2))
            {
                $user_id = $row2['id'];
                $img = $row2['img'];
                $fname = $row2['fname'];
                $lname = $row2['lname'];
                $user = $row2['user'];
                $output .= '<a href="profile.php?id='.$user_id.'"><div class="d-flex text-muted pt-3">
                            <img class="bd-placeholder-img rounded-circle me-2 rounded photo-profile" width="80" height="80" role="img" preserveAspectRatio="xMidYMid slice" focusable="false" src="images/'.$img.'">
                            <div class="pb-3 mb-0 small lh-sm border-bottom w-100">
                                <div class="d-flex justify-content-between">
                                    <strong class="text-gray-dark">'.$fname.' '.$lname.'</strong>
                                    <!--<a href="#">Zobacz</a>--->
                                </div>
                            <span class="d-block">@'.$user.'</span>'
                            //<p>'.$you.$msg.'</p>
                            .'</div>
                        </div></a>';  
            }
        }
    }else{
        $output .= "Nie masz potwierdzonych znajomości";
        // exit();
    }

    echo $output;
    
    $conn->close();
?>