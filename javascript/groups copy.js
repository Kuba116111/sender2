const manageGroup = document.querySelector('#btn-manage-group');

const btnLeaveGroup = document.querySelector('#btn-leave-group');
const btnCloseLeaveGroup = document.querySelector('#btn-close-leave-group');
const btnDeleteGroup = document.querySelector('#btn-delete-group');
const btnCloseDeleteGroup = document.querySelector('#btn-close-delete-group');
const btnConfirmLeaveGroup = document.querySelector('#btn-confirm-leave-group');
const btnConfirmDeleteGroup = document.querySelector('#btn-confirm-delete-group');

const btnCloseGroupManager = document.querySelector('#btn-close-group-manager');

const divManageGroup = document.querySelector('.divmanagegroup');

const divLeaveGroup = document.querySelector('.divleavegroup');

const divDeleteGroup = document.querySelector('.divdeletegroup');

const divChgroupname = document.querySelector('#div-chgroupname');
const divChgroupimg = document.querySelector('#div-chgroupimg');

const btnChgroupname = document.querySelector('#btn-chgroupname');
const btnChgroupimg = document.querySelector('#btn-chgroupimg');

const formGroupSettings = document.querySelectorAll('.form-groupsettings');

const chgroupname = document.querySelector('#chgroupname');
const chgroupimg = document.querySelector('#chgroupimg');


const groupId = document.querySelector('#groupId').value;

const listUsersInGroup = document.querySelector('#list_users_in_group');

const searchUserInGroup = document.querySelector('#search_user_in_group');


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

btnDeleteGroup.addEventListener("click", function(){
    divDeleteGroup.style.display="block";
})
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

manageGroup.addEventListener("click", function(){
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
})

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