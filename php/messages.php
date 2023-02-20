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

    $sql2 = "SELECT chat_id,user,img FROM chats,users WHERE (friend1_id = '{$id}' AND friend2_id = '{$user_id}' AND friend2_id=users.id) OR (friend1_id = '{$user_id}' AND friend2_id = '{$id}' AND friend1_id=users.id)";
    $query2 = mysqli_query($conn, $sql2);

    while($row1 = mysqli_fetch_assoc($query2))
    {
        $output = '';
        $chat_id = $row1['chat_id'];
        $user = $row1['user'];
        $img = $row1['img'];
    }
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
                                    <img class="photo-profile" src="images/users/'.$img.'" alt="'.$user.'">
                                </div>
                            <p class="text-muted">'.$row['time'].'<?p>
                            </div>
                        </div>';       
        }
    }
    echo $output;

    $conn->close();
?>