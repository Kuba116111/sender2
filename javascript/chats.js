const allchats = document.querySelector('.div-allchats');
const allFriends = document.querySelector('.div-allfriends');

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
