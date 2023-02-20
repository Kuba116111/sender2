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
                    // $result .= '<a href="profile.php?id='.$row['id'].'" class="allchats"><div class="d-flex text-muted pt-3 pb-3">';
                    //     $result .= '<img class="bd-placeholder-img rounded-circle m-3 photo-profile" role="img" preserveAspectRatio="xMidYMid slice" focusable="false" src="images/users/'.$row['img'].'">';
                    //     $result .= '<div class="pb-3 mb-0 small lh-sm border-bottom w-100">';
                    //         $result .= '<div class="d-flex justify-content-between">';
                    //         $result .= '<strong class="text-gray-dark">@'.$row['user'].'</strong>';
                    //         // $result .= '<a href="profile.php?id='.$row['id'].'">Odwiedź profil</a>';
                    //         $result .= '</div>';
                    //         $result .= '<span class="d-block">'.$row['fname'].' '.$row['lname'].'</span>';
                    //         $result .= '<span class="d-block">Data dołączenia: '.$row['date'].'</span>';
                    //         // $result .= '<span class="d-block">'.$row['status'].'</span>';
                    //     $result .= '</div>';
                    // $result .= '</div></a>';
                        // $result .= '<li>
                        //                 <div class="dropdown-item d-flex align-items-center gap-2 py-1 user_in_group">
                        //                     <img class="bd-placeholder-img rounded-circle m-1 photo-profile" role="img" preserveaspectratio="xMidYMid slice" focusable="false" src="images/users/'.$row['img'].'">
                        //                     <div class="pb-0 mb-0 w-100">
                        //                         <div class="d-flex justify-content-between">
                        //                             <strong class="text-gray-dark">'.$row['user'].'</strong>
                        //                             <div class="col-md-6 text-start">
                        //                                 <button type="button" id="'.$row['fname'].$row['lname'].'" class="btn btn-sm btn-primary btn_modify_role_group" value="'.$row['id'].'" onclick="deleteFromGroup()">Modyfikuj uprawnienia</button>
                        //                                 <button type="button" id="'.$users['fname'].$users['lname'].'" class="btn btn-lg btn-link fs-6 text-decoration-none col-6 m-0 rounded-0 btn_delete_user_from_group" value="'.$users['id'].'" onclick="deleteUserFromGroup('.$users['user'].')">Usuń z grupy</button>
                        //                             </div>
                        //                         </div>
                        //                         <span class="d-block">'.$row['fname'].$row['lname'].'</span>
                        //                     </div>
                        //                 </div>
                        //             </li>';

                        if ($row['role'] == 'administrator') {
                            $role = 'Administrator';
                        }elseif ($row['role'] == 'member') {
                            $role = 'Członek';
                        }

                        $result .= '<li>
                                        <div class="modal-content">
                                            <div class="modal-body p-2">
                                                <div class="d-flex align-items-center gap-2 py-1 user_in_group">
                                                    <img class="bd-placeholder-img rounded-circle m-1 photo-profile" role="img" preserveaspectratio="xMidYMid slice" focusable="false" src="images/users/'.$row['img'].'">
                                                    <div class="pb-0 mb-0 w-100">
                                                        <div class="d-flex justify-content-between">
                                                            <strong class="text-gray-dark">'.$row['user'].'</strong>
                                                            <strong class="text-gray-dark">'.$role.'</strong>
                                                        </div>
                                                        <span class="d-block">'.$row['fname'].' '.$row['lname'].'</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer flex-nowrap p-0">
                                                <button type="button" id="'.$row['fname'].$row['lname'].'" class="btn btn-lg btn-link fs-6 text-decoration-none col-6 m-0 rounded-0 btn_modify_role_group border-end" value="'.$row['id'].'" onclick="modifyRoleGroup('.$row['id'].')">Modyfikuj uprawnienia</button>
                                                <button type="button" id="'.$row['fname'].$row['lname'].'" class="btn btn-lg btn-link fs-6 text-decoration-none col-6 m-0 rounded-0 btn_delete_user_from_group" value="'.$row['id'].'" onclick="deleteUserFromGroup('.$row['user'].')">Usuń z grupy</button>
                                            </div>
                                        </div>
                                    </li>';
                    
                }

            }
            
            if(mysqli_num_rows($query1)>0){
                $result = '';
                $i=1;
                while($row = mysqli_fetch_assoc($query1))
                {
                    // if($i<4){
                        $search .= $row['user'].'<br>';
                        $login = $row['user'];
                        $fname = $row['fname'];
                        $lname = $row['lname'];
                        $img = $row['img'];
        
        
                        // $result .= '<a href="profile.php?id='.$row['id'].'" class="allchats"><div class="d-flex text-muted pt-3 border-bottom">';
                        //     $result .= '<img class="bd-placeholder-img rounded-circle m-3 photo-profile" role="img" preserveAspectRatio="xMidYMid slice" focusable="false" src="images/users/'.$row['img'].'">';
                        //     $result .= '<div class="pb-3 mb-0 w-100">';
                        //         $result .= '<div class="d-flex justify-content-between">';
                        //         $result .= '<strong class="text-gray-dark">@'.$row['user'].'</strong>';
                        //         // $result .= '<a href="profile.php?id='.$row['id'].'">Odwiedź profil</a>';
                        //         $result .= '</div>';
                        //         $result .= '<span class="d-block">'.$row['fname'].' '.$row['lname'].'</span>';
                        //         $result .= '<span class="d-block">Data dołączenia: '.$row['date'].'</span>';
                        //         // $result .= '<span class="d-block">'.$row['status'].'</span>';
                        //     $result .= '</div>';
                        // $result .= '</div></a>';
                        // $result .= '<li>
                        //                 <div class="dropdown-item d-flex align-items-center gap-2 py-1 user_in_group">
                        //                     <img class="bd-placeholder-img rounded-circle m-1 photo-profile" role="img" preserveaspectratio="xMidYMid slice" focusable="false" src="images/users/'.$row['img'].'">
                        //                     <div class="pb-0 mb-0 w-100">
                        //                         <div class="d-flex justify-content-between">
                        //                             <strong class="text-gray-dark">'.$row['user'].'</strong>
                        //                             <div class="col-md-6 text-start">
                        //                                 <button type="button" id="'.$row['fname'].$row['lname'].'" class="btn btn-sm btn-primary btn_modify_role_group" value="'.$row['id'].'" onclick="deleteFromGroup()">Modyfikuj uprawnienia</button>
                        //                                 <button type="button" id="'.$row['fname'].$row['lname'].'" class="btn btn-sm btn-primary btn_delete_from_group" value="'.$row['id'].'" onclick="deleteFromGroup()">Usuń z grupy</button>
                        //                             </div>
                        //                         </div>
                        //                         <span class="d-block">'.$row['fname'].$row['lname'].'</span>
                        //                     </div>
                        //                 </div>
                        //             </li>';

                        if ($row['role'] == 'administrator') {
                            $role = 'Administrator';
                        }elseif ($row['role'] == 'member') {
                            $role = 'Członek';
                        }
                        
                        $result .= '<li>
                                        <div class="modal-content">
                                            <div class="modal-body p-2">
                                                <div class="d-flex align-items-center gap-2 py-1 user_in_group">
                                                    <img class="bd-placeholder-img rounded-circle m-1 photo-profile" role="img" preserveaspectratio="xMidYMid slice" focusable="false" src="images/users/'.$row['img'].'">
                                                    <div class="pb-0 mb-0 w-100">
                                                        <div class="d-flex justify-content-between">
                                                            <strong class="text-gray-dark">'.$row['user'].'</strong>
                                                            <strong class="text-gray-dark">'.$role.'</strong>
                                                        </div>
                                                        <span class="d-block">'.$row['fname'].' '.$row['lname'].'</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer flex-nowrap p-0">
                                                <button type="button" id="'.$row['fname'].$row['lname'].'" class="btn btn-lg btn-link fs-6 text-decoration-none col-6 m-0 rounded-0 btn_modify_role_group border-end" value="'.$row['id'].'" onclick="modifyRoleGroup('.$row['id'].')">Modyfikuj uprawnienia</button>
                                                <button type="button" id="'.$row['fname'].$row['lname'].'" class="btn btn-lg btn-link fs-6 text-decoration-none col-6 m-0 rounded-0 btn_delete_from_group" value="'.$row['id'].'" onclick="deleteUserFromGroup('."'".$row['user']."',".$row['id'].')">Usuń z grupy</button>
                                            </div>
                                        </div>
                                    </li>';
                    // }
                }
            }
        }
    }

    echo $result;
?>