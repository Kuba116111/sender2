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

    $sql = "SELECT user,groups FROM users WHERE id = '{$id}'";
    $query = mysqli_query($conn, $sql);
    $output = "";

    while($row=mysqli_fetch_assoc($query)) {
        $user = $row['user'];
        $groups = $row['groups'];
    }

    $groups = explode(',',$groups);

    foreach ($groups as $one_group) {
        // echo $one_group;
        if($one_group !== '')
        {
            $sql_select_group = "SELECT * FROM groups WHERE id = '".$one_group."' ORDER BY date DESC";
            $query_select_group = mysqli_query($conn, $sql_select_group);
            
            if(mysqli_num_rows($query_select_group) === 0){
                $output = "Coś tu pusto";
            }elseif (mysqli_num_rows($query_select_group) > 0) {
                while ($row = mysqli_fetch_assoc($query_select_group)) {
                    $group_id = $row['group_id'];
                    $group_name = $row['group_name'];
                    $img = $row['img'];


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
                            while ($row3 = mysqli_fetch_assoc($query3)) {
                                $from_user = $row3['from_user'];
                                // $to_user = $row3['to_user'];
                            }
                            // print_r($row2);
                            // if ($from_user === $id) {
                                //     $select_user = "SELECT * FROM users WHERE id = '{$to_user}'";
                                //     $query_select_user = mysqli_query($conn, $select_user);
                                // }elseif ($to_user === $id){
                                //     $select_user = "SELECT * FROM users WHERE id = '{$from_user}'";
                                //     $query_select_user = mysqli_query($conn, $select_user);
                                // }
                                // if(mysqli_num_rows($query_select_user) > 0){
                                    // echo 1;
                                    // while ($row4 = mysqli_fetch_assoc($query2)) {
                                        // $output = '1';
                                        // $user_id = $row4['id'];
                                        
                                    $result = $row2['text'];
                                    (strlen($result) > 28) ? $msg =  substr($result, 0, 28) . '...' : $msg = $result;
                                    if($id === $row2['from_user']){
                                        $you = "Ty: ";
                                    }else{
                                        // $sql_select_from_user = "SELECT user FROM users WHERE id = '{$id}'";
                                        // $query_select_from_user = mysqli_query($conn, $sql_select_from_user);
                                        $you = $user.': ';
                                    }
                        
                                    $output .= '<a href="groups.php?groupid='.$group_id.'"><div class="d-flex text-muted pt-3">
                                                    <img class="bd-placeholder-img rounded-circle me-2 rounded photo-profile" width="80" height="80" role="img" preserveAspectRatio="xMidYMid slice" focusable="false" src="images/users/'.$img.'">
                                                    <div class="pb-3 mb-0 small lh-sm border-bottom w-100">
                                                        <div class="d-flex justify-content-between">
                                                            <strong class="text-gray-dark">'.$group_name.'</strong>
                                                            <!--<a href="#">Zobacz</a>--->
                                                        </div>
                                                    <p>'.$you.$msg.'</p>
                                                    </div>
                                                </div></a>';
                                // }
                            // }else{
                            //     $output ="Brak wiadomości";
                            // }
                        }else{
                            $output = "Błąd!";
                        }
                    }
                }
            }
        }
    }

    
    echo $output;
    
    $conn->close();
?>