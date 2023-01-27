<?php
    session_start();

    if(!isset($_COOKIE['logged']) && $_COOKIE['logged'] != true)
    {
        header("Location: ../index.php");
        exit();
    }

    $id = $_SESSION['id'];

    require_once("connect.php");

    $group_id = mysqli_real_escape_string($conn, $_POST['group_id']);
    // $group_id = 848192390;
    // $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);

    // $outgoing_id = $_SESSION['id'];

    $output = '';

    $sql2 = "SELECT group_name, img, creator FROM groups,groups_members WHERE (groups.group_id = $group_id AND groups_members.user_id = $id) AND (groups.group_id = groups_members.group_id)";
    $query2 = mysqli_query($conn, $sql2);

    if(mysqli_num_rows($query2)>0){
        while($row1 = mysqli_fetch_assoc($query2))
        {
            // echo 1;
            $output = '';
            $creator = $row1['creator'];
            $group_name = $row1['group_name'];
            // $group_id = $row1['group_id'];
            // $user = $row1['user'];
            $img = $row1['img'];
        }
        $sql = "SELECT * FROM groups_$group_id ORDER BY id";
        $query = mysqli_query($conn, $sql);
        $date = 1;
        if(mysqli_num_rows($query) > 0){
            while($row = mysqli_fetch_assoc($query))
            {
                if($row['date'] !== $date) {
                    $date = $row['date'];
                    $output .= '<hr><p class="date">'.$row['date'].'</p>';
                }
                if ($row['from_user'] === $id) {
                    $output .= '<div class="row row-cols-1 row-cols-lg-1 mb-1 chat-right">
                                    <div class="row d-inline-flex justify-content-right">
                                        <div class="d-inline-flex align-items-center justify-content-right">
                                            <p class="message-text">'.$row['text'].'</p>
                                        </div>  
                                        <p class="text-muted time">'.$row['time'].'<?p>
                                    </div>
                                </div>';
                }else{
                    $sql_select_member = "SELECT user,img FROM users WHERE id = ".$row['from_user'];
                    $query_select_member = mysqli_query($conn, $sql_select_member);
                    $from_member = mysqli_fetch_assoc($query_select_member);
                    $output .= '<div class="row row-cols-1 row-cols-lg-1 mb-1 chat">
                                    <div class="col">
                                        <div class="d-inline-flex align-items-center justify-content-left">
                                            <p class="message-text">'.$row['text'].'</p>
                                            <img class="photo-profile" src="images/'.$from_member['img'].'" alt="'.$from_member['user'].'">
                                        </div>
                                        <p class="user">'.$from_member['user'].'</p>
                                        <p class="text-muted">'.$row['time'].'<?p>
                                    </div>
                                </div>';       
                }
            }
        }else{
            $sql_search_creator = "SELECT * FROM users WHERE id = $creator";
            $query_search_creator = mysqli_query($conn, $sql_search_creator);
            $row_search_creator = mysqli_fetch_assoc($query_search_creator);
            $user = $row_search_creator['user'];
    
            $output .= '<div class="text-center"><strong class="text-gray-dark">'.$group_name.'</strong>
                        <p>Grupa utworzona przez: '.$user.'</p><div>';
        }
    }else{
        $output = '<div class="text-center"><strong class="text-gray-dark">Błąd</strong>
                    <p>Grupa nie została odnaleziona lub nie należysz do niej</p><div>';
    }
    echo $output;

    $conn->close();
?>