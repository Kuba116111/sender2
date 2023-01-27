<?php
    session_start();

    if(!isset($_COOKIE['logged']) && $_COOKIE['logged'] != true)
    {
        header("Location: ../index.php");
        exit();
    }

    $id = $_SESSION['id'];

    require_once("connect.php");

    $chat_id = mysqli_real_escape_string($conn, $_POST['chat_id']);
    $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);

    // $outgoing_id = $_SESSION['id'];

    $output = '';

    $sql2 = "SELECT * FROM users WHERE id = '{$user_id}'";
    $query2 = mysqli_query($conn, $sql2);

    while($row1 = mysqli_fetch_assoc($query2))
    {
        $output = '';
        // $output = '<h2 class="mt-5 pb-2 border-bottom fixed-top userinfo">'.$row1['user'].'</h2>';
        $img = $row1['img'];
        $user = $row1['user'];
        $chats = $row1['chats'];
    }

    if ($chats !== '') {
        $chats2 = explode(',',$chats);
        $i=0;
        foreach($chats2 as $one_chat)
        {
            if($i!==0) {
                if($one_chat === $chat_id)
                {
                    $sql = "SELECT * FROM messages_$chat_id ORDER BY id";
                    $query = mysqli_query($conn, $sql);
                    $date = 1;
                    while($row = mysqli_fetch_assoc($query))
                    {
                        if($row['date'] !== $date) {
                            $date = $row['date'];
                            $output .= '<hr><p>'.$row['date'].'</p>';
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
                        }elseif ($row['to_user'] === $id){
                            $output .= '<div class="row row-cols-1 row-cols-lg-1 mb-1 chat">
                                            <div class="col">
                                                <div class="d-inline-flex align-items-center justify-content-start">
                                                    <p class="message-text">'.$row['text'].'</p>
                                                    <img class="photo-profile" src="images/'.$img.'" alt="'.$user.'">
                                                </div>
                                            <p class="text-muted">'.$row['time'].'<?p>
                                            </div>
                                        </div>';       
                        }
                    }
                }
            }
            $i++;

        }
    }
    echo $output;

    $conn->close();
?>