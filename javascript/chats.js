const btnNewGroupChat = document.querySelector('#btn-newgroupchat');
const formNewGroupChat = document.querySelector('.formnewgroupchat');
const formUserToGroup = document.querySelector('#formusertogroup');
const searchUserToGroup = document.querySelector('#search_user_to_group');
const listUsersToGroup = document.querySelector('#list_users_to_group');
const selectedUsers = document.querySelector('.selected-users');
const userToSelect = document.getElementsByClassName('user_to_select');
const btnInviteToGroup = document.querySelectorAll('.btn_invite_to_group');
const allchats = document.querySelector('.div-allchats');
const allgroups = document.querySelector('.div-allgroups');
const allFriends = document.querySelector('.div-allfriends');
const membersIdForm = document.querySelector('#members_id_form');
const membersId = document.querySelector('#members_id');

// formNewGroupChat.onsubmit = (e)=>{
//   e.preventDefault();
// }

let dataGroupsOld = '';

setInterval(() =>{
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/groups.php", true);
    xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
          if(xhr.status === 200){
            let data = xhr.response;
            // allchats.innerHTML = "ok";
            if(data !== dataGroupsOld)
            {
              dataGroupsOld = data;
              allgroups.innerHTML = data;
            }
        }
    }
    }
    xhr.send();
  }, 100);

let dataChatsOld = '';

setInterval(() =>{
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/chats.php", true);
    xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
          if(xhr.status === 200){
            let data = xhr.response;
            // allchats.innerHTML = "ok";
            if(data !== dataChatsOld)
            {
              dataChatsOld = data;
              allchats.innerHTML = data;
            }
        }
    }
    }
    xhr.send();
  }, 100);

let dataFriendsOld = '';

setInterval(() =>{
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/friends.php", true);
    xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
          if(xhr.status === 200){
            let data = xhr.response;
            // allFriends.innerHTML = "ok";
            if(data !== dataFriendsOld)
            {
              dataFriendsOld = data;
              allFriends.innerHTML = data;
            }
        }
    }
    }
    xhr.send();
  }, 100);

function showDivNewGroupChat(){
  formNewGroupChat.style.display = "block";
}

function hideDivNewGroupChat(){
  formNewGroupChat.style.display = "none";
}

searchUserToGroup.onkeyup = ()=>{
  let searchTerm = searchUserToGroup.value;
  if(searchTerm != ""){
    searchUserToGroup.classList.add("active");
  }else{
    searchUserToGroup.classList.remove("active");
  }
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "php/searchtogroup.php", true);
  xhr.onload = ()=>{
    if(xhr.readyState === XMLHttpRequest.DONE){
        if(xhr.status === 200){
          let data = xhr.response;
          listUsersToGroup.innerHTML = data;
        }
    }
  }
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send("searchTerm=" + searchTerm);
}

var selectedUsersBtn = [];
var thisSelectedUsersBtn = [];
selectedUsers.innerHTML = '';


function inviteToGroup(){
  console.log(event.target.value);
  if(!selectedUsersBtn.some(element => element.toString() === [event.target.value,event.target.id].toString())) {
    selectedUsers.innerHTML += `<button class="btn btn-sm btn-primary btn_cancel_invite_to_group" id="${event.target.id}" value="${event.target.value}" onclick="cancelinviteToGroup()">${event.target.id}</button>`;
    selectedUsersBtn.push([event.target.value,event.target.id]);
  }else{
    console.log(selectedUsersBtn);
  }
  var data = '';
  selectedUsersBtn.forEach(element => {
    data += element[0]+',';
  });
  membersId.value = data;
};

function cancelinviteToGroup(){
  console.log('----')
  console.log(event.target.value);
  console.log(event.target.id);
  if(selectedUsersBtn.some(element => element.toString() === [event.target.value, event.target.id].toString())) {
    var index = selectedUsersBtn.findIndex(element => element.toString() === [event.target.value, event.target.id].toString());
    // var index = selectedUsersBtn.indexOf([event.target.value, event.target.id]);
    console.log('index: ' + index);
    // console.log(`['${event.target.value}', '${event.target.id}']`.toString());
    selectedUsersBtn.splice(index, 1);
    // selectedUsers.innerHTML -= `<button class="btn btn-sm btn-primary btn_cancel_invite_to_group" value="${event.target.value}" onclick="cancelinviteToGroup()">${event.target.id} X</button>`;
    var users = ''
    selectedUsersBtn.forEach(element => {
      users += `<button class="btn btn-sm btn-primary btn_cancel_invite_to_group" id="${element[1]}" value="${element[0]}" onclick="cancelinviteToGroup()">${element[1]}</button>`;
      // console.log(`<button class="btn btn-sm btn-primary btn_cancel_invite_to_group" value="${element[0]}" onclick="cancelinviteToGroup()">${element[1]} X</button>`);
    });
    selectedUsers.innerHTML = users;
    var data = '';
    selectedUsersBtn.forEach(element => {
      data += element[0]+',';
    });
    membersId.value = data;
  }
  console.log(selectedUsersBtn);
  console.log('----')
};

// function createGroup(){
//   var data = '';
//   selectedUsersBtn.forEach(element => {
//     data += element[0]+',';
//   });
//   let xhr = new XMLHttpRequest();
//   xhr.open("POST", "php/newgroupmessage.php", true);
//   xhr.onload = ()=>{
//     if(xhr.readyState === XMLHttpRequest.DONE){
//       if(xhr.status === 200){
//         console.log(xhr.response);
//       }
//     }
//   }
//   // xhr.setRequestHeader("Content-Type", "application/json");
//   let DataSendMessage = new FormData(membersIdForm);
//   xhr.send(DataSendMessage);
//   console.log(DataSendMessage);
// };
// function createGroup(){
//   var data = '';
//   selectedUsersBtn.forEach(element => {
//     data += element[0]+',';
//   });
//   let xhr = new XMLHttpRequest();
//   xhr.open("POST", "php/newgroupmessage.php", true);
//   xhr.onload = ()=>{
//     if(xhr.readyState === XMLHttpRequest.DONE){
//       if(xhr.status === 200){
//         console.log(xhr.response);
//       }
//     }
//   }
//   xhr.setRequestHeader("Content-Type", "application/json");
//   xhr.send(JSON.stringify(data));
//   console.log(data);
// };
