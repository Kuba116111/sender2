<?php
    session_start();

    if(!isset($_SESSION['logged']) && $_SESSION['logged'] != true)
    {
        header("Location: index.php");
        exit();
    }

    $id = $_SESSION['id'];

    require_once("connect.php");

    $outgoing_id = $_SESSION['id'];

    $sql = "SELECT chats FROM users WHERE id = '{$id}'";
    $query = mysqli_query($conn, $sql);
    
    $output = "";
    if(mysqli_num_rows($query) === 0){
        $output = "Coś tu pusto";
    }elseif (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_assoc($query)) {
            $chats = $row['chats'];
            // echo $chats;
        }
        if ($chats !== '') {
            $chats2 = explode(',',$chats);
            $i=0;
            foreach($chats2 as $one_chat)
            {
                if($i!==0) {
                    // echo $one_chat;
                    $sql_search = "SELECT * FROM messages_$one_chat";
                    $query_search = mysqli_query($conn, $sql_search);
                    
                    if (mysqli_num_rows($query_search) > 0) {
                        $sql2 = "SELECT * FROM messages_$one_chat ORDER BY id DESC";
                        $query2 = mysqli_query($conn, $sql2);
                        $row2 = mysqli_fetch_assoc($query2);
                        if(mysqli_num_rows($query2) > 0){
                            while ($row3 = mysqli_fetch_assoc($query2)) {
                                $from_user = $row3['from_user'];
                                $to_user = $row3['to_user'];
                            }
                            print_r($row3);
                            if ($from_user === $id) {
                                $select_user = "SELECT * FROM users WHERE id = '{$to_user}'";
                                $query_select_user = mysqli_query($conn, $select_user);
                            }elseif ($to_user === $id){
                                $select_user = "SELECT * FROM users WHERE id = '{$from_user}'";
                                $query_select_user = mysqli_query($conn, $select_user);
                            }
                            if(mysqli_num_rows($query_select_user) > 0){
                                while ($row4 = mysqli_fetch_assoc($query_select_user)) {
                                    $user_id = $row4['id'];
                                    $img = $row4['img'];
                                    $fname = $row4['fname'];
                                    $lname = $row4['lname'];
                                    $user = $row4['user'];
                                }
                                $result = $row2['text'];
                                (strlen($result) > 28) ? $msg =  substr($result, 0, 28) . '...' : $msg = $result;
                                if($to_user === $row2['to_user']){
                                    if($outgoing_id === $row2['to_user']){
                                        $you = $user.': ';
                                    }else{
                                        $you = "Ty: ";
                                    }
                                    // $you = "Ty: ";
                                }else{
                                    $you = $user.': ';
                                }
                    
                                $output .= '<a href="messages.php?chatid='.$one_chat.'&userid='.$user_id.'"><div class="d-flex text-muted pt-3">
                                                <img class="bd-placeholder-img rounded-circle me-2 rounded photo-profile" width="80" height="80" role="img" preserveAspectRatio="xMidYMid slice" focusable="false" src="images/'.$img.'">
                                                <div class="pb-3 mb-0 small lh-sm border-bottom w-100">
                                                    <div class="d-flex justify-content-between">
                                                        <strong class="text-gray-dark">'.$fname.' '.$lname.'</strong>
                                                        <!--<a href="#">Zobacz</a>--->
                                                    </div>
                                                <span class="d-block">@'.$user.'</span><br>
                                                <p>'.$you.$msg.'</p>
                                                </div>
                                            </div></a>';
                            }else{
                                $output ="Brak wiadomości";
                            }
                        }else{
                            $output = "Błąd!";
                        }
                    }
                }
                $i++;
            }
        }else{
            $output .= "Coś tu pusto";
        }
    }
    
    
    // $chats2;

    // $database_name = 'messages_'.$id;

    if(mysqli_num_rows($query) == 0){
        // $output .= "Coś tu pusto";
    }elseif(mysqli_num_rows($query) > 0){
        // while($row = mysqli_fetch_assoc($query)){
        //     $sql2 = "SELECT * FROM messages WHERE (from_user = {$row['id']}
        //             OR to_user = {$row['id']}) AND (from_user = {$outgoing_id} 
        //             OR to_user = {$outgoing_id}) ORDER BY message_id DESC LIMIT 1";
        //     $query2 = mysqli_query($conn, $sql2);
        //     $row2 = mysqli_fetch_assoc($query2);
        //     if(mysqli_num_rows($query2) > 0){
        //         $result = $row2['text'];
        //         (strlen($result) > 28) ? $msg =  substr($result, 0, 28) . '...' : $msg = $result;
        //         if(isset($row2['to_user'])){
        //             ($outgoing_id == $row2['to_user']) ? $you = "Ty: " : $you = $row['user'].': ';
        //         }else{
        //             $you = $row['user'].': ';
        //         }
    
        //         $output .= '<a href="messages.php?id='.$row['id'].'"><div class="d-flex text-muted pt-3">
        //                         <img class="bd-placeholder-img rounded-circle me-2 rounded photo-profile" width="80" height="80" role="img" preserveAspectRatio="xMidYMid slice" focusable="false" src="images/'.$row['img'].'">
        //                         <div class="pb-3 mb-0 small lh-sm border-bottom w-100">
        //                             <div class="d-flex justify-content-between">
        //                                 <strong class="text-gray-dark">'.$row['fname'].' '.$row['lname'].'</strong>
        //                                 <!--<a href="#">Zobacz</a>--->
        //                             </div>
        //                         <span class="d-block">@'.$row['user'].'</span><br>
        //                         <p>'. $you . $msg .'</p>
        //                         </div>
        //                     </div></a>';
        //     }
            // else{
            //     $result ="Brak wiadomości";
            // }

        // }
    }
    echo $output;
?>