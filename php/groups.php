<?php
    session_start();

    if(!isset($_COOKIE['logged']) && $_COOKIE['logged'] != true)
    {
        header("Location: ../index.php");
        exit();
    }

    $id = $_SESSION['id'];

    require_once("connect.php");

    $outgoing_id = $_SESSION['id'];

    $sql = "SELECT * FROM groups,groups_members WHERE (groups_members.user_id = '$id' AND groups.group_id = groups_members.group_id) ORDER BY date DESC";
    $query = mysqli_query($conn, $sql);
    
    $output = "";
    if(mysqli_num_rows($query) === 0){
        $output = "Coś tu pusto";
    }elseif (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_assoc($query)) {
            $group_id = $row['group_id'];
            $group_name = $row['group_name'];
            $img = $row['img'];
            $date = $row['date'];
            $creator = $row['creator'];
            $sql_search = "SELECT * FROM groups_$group_id";
            $query_search = mysqli_query($conn, $sql_search);

            if (mysqli_num_rows($query_search) > 0) {
                $sql2 = "SELECT * FROM groups_$group_id ORDER BY id DESC";
                $sql3 = "SELECT * FROM groups_$group_id ORDER BY id DESC";
                $query2 = mysqli_query($conn, $sql2);
                $row2 = mysqli_fetch_assoc($query2);
                // print_r($row2);
                if(mysqli_num_rows($query2) > 0){
                    // print_r($row2);
                    $query3 = mysqli_query($conn, $sql3);
                    // while ($row3 = mysqli_fetch_assoc($query3)) {
                        $from_user = $row2['from_user'];
                        // $to_user = $row3['to_user'];
                    // }
                    // print_r($row2);
                    // if ($from_user === $id) {
                    //     $select_user = "SELECT * FROM users WHERE id = '{$to_user}'";
                    //     $query_select_user = mysqli_query($conn, $select_user);
                    // }elseif ($to_user === $id){
                    //     $select_user = "SELECT * FROM users WHERE id = '{$from_user}'";
                    //     $query_select_user = mysqli_query($conn, $select_user);
                    // }
                    // if(mysqli_num_rows($query_select_user) > 0){
                        
                            
                        $result = $row2['text'];
                        (strlen($result) > 28) ? $msg =  substr($result, 0, 28) . '...' : $msg = $result;
                        if($id === $row2['from_user']){
                            if($outgoing_id === $row2['to_user']){
                                $you = $user.': ';
                            }else{
                                $you = "Ty: ";
                            }
                            $you = "Ty: ";
                        }else{
                            $you = $user.': ';
                        }
            
                        $output .= '<a href="groups.php?groupid='.$group_id.'"><div class="d-flex text-muted pt-3">
                                        <img class="bd-placeholder-img rounded-circle me-2 rounded photo-profile" width="80" height="80" role="img" preserveAspectRatio="xMidYMid slice" focusable="false" src="images/'.$img.'">
                                        <div class="pb-3 mb-0 small lh-sm border-bottom w-100">
                                            <div class="d-flex justify-content-between">
                                                <strong class="text-gray-dark">'.$group_name.'</strong>
                                                <!--<a href="#">Zobacz</a>--->
                                            </div>
                                        <p>'.$you.$msg.'</p>
                                        </div>
                                    </div></a>';
                        
                    // }else{
                    //     $output ="Brak wiadomości";
                    // }
                }else{
                    $output = "Błąd!";
                }
            }else{
                $sql_search_creator = "SELECT * FROM users WHERE id = $creator";
                $query_search_creator = mysqli_query($conn, $sql_search_creator);
                $row_search_creator = mysqli_fetch_assoc($query_search_creator);
                $user = $row_search_creator['user'];

                $output .= '<a href="groups.php?groupid='.$group_id.'"><div class="d-flex text-muted pt-3">
                                <img class="bd-placeholder-img rounded-circle me-2 rounded photo-profile" width="80" height="80" role="img" preserveAspectRatio="xMidYMid slice" focusable="false" src="images/'.$img.'">
                                <div class="pb-3 mb-0 small lh-sm border-bottom w-100">
                                    <div class="d-flex justify-content-between">
                                        <strong class="text-gray-dark">'.$group_name.'</strong>
                                        <!--<a href="#">Zobacz</a>--->
                                    </div>
                                <p>Grupa utworzona przez: '.$user.'</p>
                                </div>
                            </div></a>';
            }
        }
    }
    
    echo $output;
    
    $conn->close();
?>