// const manageGroup = document.querySelector('#btn-manage-group');

const btnLeaveGroup = document.querySelector('#btn-leave-group');
const btnCloseLeaveGroup = document.querySelector('#btn-close-leave-group');
// const btnDeleteGroup = document.querySelector('#btn-delete-group');
const btnCloseDeleteGroup = document.querySelector('#btn-close-delete-group');
const btnConfirmLeaveGroup = document.querySelector('#btn-confirm-leave-group');
const btnConfirmDeleteGroup = document.querySelector('#btn-confirm-delete-group');

const btnCloseGroupManager = document.querySelector('#btn-close-group-manager');

const divManageGroup = document.querySelector('.divmanagegroup');

const divLeaveGroup = document.querySelector('.divleavegroup');

const divDeleteGroup = document.querySelector('.divdeletegroup');

const divChgroupname = document.querySelector('#div-chgroupname');
const divChgroupimg = document.querySelector('#div-chgroupimg');

const divModifyRoleGroup = document.querySelector('.divmodifyrolegroup');
const divDeleteUserFromGroup = document.querySelector('.divdeleteuserfromgroup');

const btnChgroupname = document.querySelector('#btn-chgroupname');
const btnChgroupimg = document.querySelector('#btn-chgroupimg');

const formGroupSettings = document.querySelectorAll('.form-groupsettings');

const chgroupname = document.querySelector('#chgroupname');
const chgroupimg = document.querySelector('#chgroupimg');


const groupId = document.querySelector('#groupId').value;

const listUsersInGroup = document.querySelector('#list_users_in_group');

const searchUserInGroup = document.querySelector('#search_user_in_group');

const modifyRoleUser = document.querySelector('.modifyroleuser');

const newUserRole = document.querySelector('#new-user-role');

const pDeleteUserFromGroup = document.querySelector('.p-deleteuserfromgroup');


chgroupname.onsubmit = (e)=>{
    e.preventDefault();
}
chgroupimg.onsubmit = (e)=>{
    e.preventDefault();
}

btnLeaveGroup.addEventListener("click", function(){
    divLeaveGroup.style.display="block";
})
btnCloseLeaveGroup.addEventListener("click", function(){
    divLeaveGroup.style.display="none";
})

btnConfirmLeaveGroup.addEventListener("click", function(){
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/leavegroup.php", true);
    xhr.onload = ()=>{
        if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200){
                let data = xhr.response;
                if(data == 'success'){
                    // divChgroupname.innerHTML = `<p class="error">${data}</p>`;
                    window.location.replace("http://localhost/strony/sender2/chat");
                }
            }
        }
    }
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("groupId="+groupId);
})

function btnDeleteGroup(){
    divDeleteGroup.style.display="block";
}

btnCloseDeleteGroup.addEventListener("click", function(){
    divDeleteGroup.style.display="none";
})

btnConfirmDeleteGroup.addEventListener("click", function(){
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/deletegroup.php", true);
    xhr.onload = ()=>{
        if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200){
                let data = xhr.response;
                // console.log(data);
                if(data == 'success'){
                    // divChgroupname.innerHTML = `<p class="error">${data}</p>`;
                    window.location.replace("http://localhost/strony/sender2/chat");
                }
            }
        }
    }
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("groupId="+groupId);
})

var usersInGroup = '';

function manageGroup(){
    divManageGroup.style.display="block";

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/listusersingroup.php", true);
    xhr.onload = ()=>{
        if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200){
                let data = xhr.response;
                // console.log(data);
                listUsersInGroup.innerHTML = data;
                usersInGroup = data;
            }
        }
    }
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("groupId="+groupId);
}

btnCloseGroupManager.addEventListener("click", function(){
    divManageGroup.style.display="none";
})

btnChgroupname.addEventListener("click", function(){
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/chgroupname.php", true);
    xhr.onload = ()=>{
        if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200){
                let data = xhr.response;
                if(data !== 'success'){
                    divChgroupname.innerHTML = `<p class="error">${data}</p>`;
                }
            }
        }
    }
    let DataChgroupname = new FormData(chgroupname);
    xhr.send(DataChgroupname);
})

btnChgroupimg.addEventListener("click", function(){
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/chgroupimg.php", true);
    xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
          if(xhr.status !== 200){
            let data = xhr.response;
            if(data !== 'success'){
                divChgroupimg.innerHTML = `<p class="error">${data}</p>`;
            }
            
        }
    }
    }
    let DataChgroupimg = new FormData(chgroupimg);
    xhr.send(DataChgroupimg);
})


searchUserInGroup.onkeyup = ()=>{
    let searchTerm = searchUserInGroup.value;
    if(searchTerm != ""){
        searchUserInGroup.classList.add("active");
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "php/searchingroup.php", true);
        xhr.onload = ()=>{
            if(xhr.readyState === XMLHttpRequest.DONE){
                if(xhr.status === 200){
                    let data = xhr.response;
                    listUsersInGroup.innerHTML = data;
                }
            }
        }
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send("searchTerm=" + searchTerm + "&groupId="+groupId);
    }else{
        searchUserInGroup.classList.remove("active");
        listUsersInGroup.innerHTML = usersInGroup;
    }
  }

let modifyRoleUserId = '';

function modifyRoleGroup(id){
    divModifyRoleGroup.style.display="block";
    
    let xhr = new XMLHttpRequest();
        xhr.open("POST", "php/userinfoingroup.php", true);
        xhr.onload = ()=>{
            if(xhr.readyState === XMLHttpRequest.DONE){
                if(xhr.status === 200){
                    let data = xhr.response;

                    // let data = '{"usertemplate":"123","role":"user"}';

                    let output = JSON.parse(data);
                    // let usertemplate = JSON.parse(output);

                    let select = '';

                    if (output.role == 'member') {
                        select = `
                                    <option selected value="member">Użytkownik - aktualne uprawnienia</option>
                                    <option value="administrator">Administrator</option>
                                `;
                    }else if (output.role == 'administrator') {
                        select = `
                                    <option value="member">Użytkownik</option>
                                    <option selected value="administrator">Administrator - aktualne uprawnienia</option>
                                `;
                    }

                    modifyRoleUser.innerHTML = `
                    <div class="d-flex align-items-center gap-2 py-1 user_in_group">
                        <img class="bd-placeholder-img rounded-circle m-1 photo-profile" role="img" preserveaspectratio="xMidYMid slice" focusable="false" src="images/users/${output.usertemplate[0].img}">
                        <div class="pb-0 mb-0 w-100">
                            <div class="d-flex justify-content-between">
                                <strong class="text-gray-dark">${output.usertemplate[0].user}</strong>
                            </div>
                            <span class="d-block text-start">${output.usertemplate[0].fname}</span>
                        </div>
                    </div>`;

                    newUserRole.innerHTML = `${select}`;

                    modifyRoleUserId = output.usertemplate[0].id;

                    console.log(modifyRoleUserId);   

                    // modifyRoleUser.innerHTML = data;
                }
            }
        }
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send("searchTerm=" + id + "&groupId="+groupId);

    
}

function closeModifyRoleGroup(){
    divModifyRoleGroup.style.display="none";
}

function confirmModifyRoleGroup(){
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/modifyroleuser.php", true);
    xhr.onload = ()=>{
        if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200){
                let data = xhr.response;
                if(data == "success"){
                    divModifyRoleGroup.style.display="none";
                }else{
                    document.querySelector('.p-modifyroleuser-error').innerHTML = data;
                }
            }
        }
    }
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    // console.log("userid=" + modifyRoleUserId + "&groupId="+groupId + "&newrole="+newUserRole.value);
    xhr.send("userId=" + modifyRoleUserId + "&groupId="+groupId + "&newRole="+newUserRole.value);
}

idUserToDelete = '';

function deleteUserFromGroup(user,id){
    console.log(user);
    divDeleteUserFromGroup.style.display = "flex";
    pDeleteUserFromGroup.innerHTML = user;
    idUserToDelete = id;
}

function closeDeleteUserFromGroup(){
    divDeleteUserFromGroup.style.display = "none";
}

function confirmDeleteUserFromGroup(){
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/deleteuserfromgroup.php", true);
    xhr.onload = ()=>{
        if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200){
                let data = xhr.response;
                if(data == "success"){
                    divDeleteUserFromGroup.style.display="none";
                    manageGroup();
                }else{
                    document.querySelector('.p-deleteuserfromgroup-error').innerHTML = data;
                }
            }
        }
    }
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("userId=" + idUserToDelete + "&groupId="+groupId);
}