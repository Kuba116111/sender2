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
    $sql = "SELECT * FROM users WHERE NOT id = {$outgoing_id} ORDER BY id DESC";
    $query = mysqli_query($conn, $sql);
    $output = "";
    if(mysqli_num_rows($query) == 0){
        $output .= "No users are available to chat";
    }elseif(mysqli_num_rows($query) > 0){
        while($row = mysqli_fetch_assoc($query)){
            $sql2 = "SELECT * FROM messages WHERE (from_user = {$row['id']}
                    OR to_user = {$row['id']}) AND (from_user = {$outgoing_id} 
                    OR to_user = {$outgoing_id}) ORDER BY message_id DESC LIMIT 1";
            $query2 = mysqli_query($conn, $sql2);
            $row2 = mysqli_fetch_assoc($query2);
            if(mysqli_num_rows($query2) > 0){
                $result = $row2['text'];
                (strlen($result) > 28) ? $msg =  substr($result, 0, 28) . '...' : $msg = $result;
                if(isset($row2['to_user'])){
                    ($outgoing_id == $row2['to_user']) ? $you = "Ty: " : $you = $row['user'].': ';
                }else{
                    $you = $row['user'].': ';
                }
                // ($row['status'] == "Offline now") ? $offline = "offline" : $offline = "";
                // ($outgoing_id == $row['id']) ? $hid_me = "hide" : $hid_me = "";
    
                $output .= '<a href="messages.php?id='.$row['id'].'"><div class="d-flex text-muted pt-3">
                                <img class="bd-placeholder-img rounded-circle me-2 rounded photo-profile" width="80" height="80" role="img" preserveAspectRatio="xMidYMid slice" focusable="false" src="images/'.$row['img'].'">
                                <div class="pb-3 mb-0 small lh-sm border-bottom w-100">
                                    <div class="d-flex justify-content-between">
                                        <strong class="text-gray-dark">'.$row['fname'].' '.$row['lname'].'</strong>
                                        <!--<a href="#">Zobacz</a>--->
                                    </div>
                                <span class="d-block">@'.$row['user'].'</span><br>
                                <p>'. $you . $msg .'</p>
                                </div>
                            </div></a>';
            }
            // else{
            //     $result ="Brak wiadomości";
            // }

        }
    }
    echo $output;
?>