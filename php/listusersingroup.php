<?php
    session_start();

    include_once("connect.php");

    $group_id = $_POST['groupId'];

    $sql_select_users_in_group = "SELECT users.id, user, fname, lname, img, role FROM users,groups_members WHERE users.id=user_id AND group_id=$group_id";

    $query_select_users_in_group = mysqli_query($conn, $sql_select_users_in_group);

    $output = '';

    while($users = mysqli_fetch_assoc($query_select_users_in_group)){
        // $output .= '<li>
        //                 <div class="dropdown-item d-flex align-items-center gap-2 py-1 user_in_group">
        //                     <img class="bd-placeholder-img rounded-circle m-1 photo-profile" role="img" preserveaspectratio="xMidYMid slice" focusable="false" src="images/users/'.$users['img'].'">
        //                     <div class="pb-0 mb-0 w-100">
        //                         <div class="d-flex justify-content-between">
        //                             <strong class="text-gray-dark">'.$users['user'].'</strong>
        //                             <div class="col-md-9 text-start">
        //                                 <button type="button" id="'.$users['fname'].$users['lname'].'" class="btn btn-sm btn-primary btn_modify_role_group" value="'.$users['id'].'" onclick="deleteFromGroup()">Modyfikuj uprawnienia</button>
        //                                 <button type="button" id="'.$users['fname'].$users['lname'].'" class="btn btn-lg btn-link fs-6 text-decoration-none col-6 m-0 rounded-0 btn_delete_user_from_group" value="'.$users['id'].'" onclick="deleteUserFromGroup('.$users['user'].')">Usuń z grupy</button>
        //                             </div>
        //                         </div>
        //                         <span class="d-block">'.$users['fname'].$users['lname'].'</span>
        //                     </div>
        //                 </div>
        //             </li>';

        if ($users['role'] == 'administrator') {
            $role = 'Administrator';
        }elseif ($users['role'] == 'member') {
            $role = 'Członek';
        }

        $output .= '<li>
                        <div class="modal-content">
                            <div class="modal-body p-2">
                                <div class="d-flex align-items-center gap-2 py-1 user_in_group">
                                    <img class="bd-placeholder-img rounded-circle m-1 photo-profile" role="img" preserveaspectratio="xMidYMid slice" focusable="false" src="images/users/'.$users['img'].'">
                                    <div class="pb-0 mb-0 w-100">
                                        <div class="d-flex justify-content-between">
                                            <strong class="text-gray-dark">'.$users['user'].'</strong>
                                            <strong class="text-gray-dark">'.$role.'</strong>
                                        </div>
                                        <span class="d-block">'.$users['fname'].' '.$users['lname'].'</span>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer flex-nowrap p-0">
                                <button type="button" id="'.$users['fname'].$users['lname'].'" class="btn btn-lg btn-link fs-6 text-decoration-none col-6 m-0 rounded-0 btn_modify_role_group border-end" value="'.$users['id'].'" onclick="modifyRoleGroup('.$users['id'].')">Modyfikuj uprawnienia</button>
                                <button type="button" id="'.$users['fname'].$users['lname'].'" class="btn btn-lg btn-link fs-6 text-decoration-none col-6 m-0 rounded-0 btn_delete_user_from_group" value="'.$users['id'].'" onclick="deleteUserFromGroup('."'".$users['user']."',".$users['id'].')">Usuń z grupy</button>
                            </div>
                        </div>
                    </li>';
    }

    echo $output;

?>