<?php
    session_start();

    if(!isset($_COOKIE['logged']) && $_COOKIE['logged'] != true)
    {
        header("Location: ../index.php");
        exit();
    }

    $id = $_SESSION['id'];

    require_once("connect.php");
    
    $search_value = $_POST['searchTerm'];
    $search_value = mysqli_escape_string($conn, $search_value);
    $group_id = $_POST['groupId'];
    $group_id = mysqli_escape_string($conn, $group_id);

    $sql_check = "SELECT role FROM groups_members WHERE user_id=$id AND group_id=$group_id";

    $role = mysqli_fetch_assoc(mysqli_query($conn, $sql_check));
    
    $result = '';
    
    if ($role['role'] == "administrator") {
        if(strlen($_POST['searchTerm']) > 0)
        {
            $search_value = '%'.$search_value.'%';
            // $search_id = "SELECT users.id,user,fname,lname,img FROM users,friends WHERE (users.id=friends.friend1_id OR users.id=friends.friend2_id) AND users.id NOT LIKE $id AND users.id LIKE '".$search_value."' AND verify='yes'";
            // $search_login = "SELECT users.id,user,fname,lname,img FROM users,friends WHERE (users.id=friends.friend1_id OR users.id=friends.friend2_id) AND users.id NOT LIKE $id AND user LIKE '".$search_value."' AND verify='yes'";
            $search_id = "SELECT users.id, user, fname, lname, img, role FROM users,groups_members WHERE users.id=user_id AND group_id=$group_id AND users.id LIKE '".$search_value."'";
            $search_login = "SELECT users.id, user, fname, lname, img, role FROM users,groups_members WHERE users.id=user_id AND group_id=$group_id AND user LIKE '".$search_value."'";
            
            $query = mysqli_query($conn, $search_id);
            $query1 = mysqli_query($conn, $search_login);
        
            // $result = mysqli_query($sql);
        
            $num = mysqli_num_rows($query);
            // echo $num;
        
            $num1 = mysqli_num_rows($query1);
            // echo $num1;

            $search = '';

            // echo strlen($_GET['search_user']);

            $result = 'Nikogo nie znaleziono';

            if(mysqli_num_rows($query)>0){
                $result = '';
                while($row = mysqli_fetch_assoc($query))
                {
                    $id = $row['id'];
                    $img = $row['img'];
                    $user = $row['user'];
                    $fname = $row['fname'];
                    $lname = $row['lname'];
                    // $template .=  '{"img":"'.$row['img']'","user":"'.$row['user'].'","fname":"'.$row['fname'].'","lname":"'$row['lname']'"}';
                    $template = '{"id":"'.$id.'","img":"'.$img.'","user":"'.$user.'","fname":"'.$fname.' '.$lname.'"}';
                    $role = $row['role'];
                    
                }

            }
            
            // if(mysqli_num_rows($query1)>0){
            //     $result = '';
            //     $i=1;
            //     while($row = mysqli_fetch_assoc($query1))
            //     {
            //         // if($i<4){
            //             $search .= $row['user'].'<br>';
            //             $login = $row['user'];
            //             $fname = $row['fname'];
            //             $lname = $row['lname'];
            //             $img = $row['img'];
        
            //             $result .= '<div class="d-flex align-items-center gap-2 py-1 user_in_group">
            //                             <img class="bd-placeholder-img rounded-circle m-1 photo-profile" role="img" preserveaspectratio="xMidYMid slice" focusable="false" src="images/users/'.$row['img'].'">
            //                             <div class="pb-0 mb-0 w-100">
            //                                 <div class="d-flex justify-content-between">
            //                                     <strong class="text-gray-dark">'.$row['user'].'</strong>
            //                                 </div>
            //                                 <span class="d-block text-start">'.$row['fname'].' '.$row['lname'].'</span>
            //                             </div>
            //                         </div>';
            //         // }
            //     }
            // }
        }
    }

    echo '{"usertemplate": ['.$template.'],"role":"'.$role.'"}';
?>