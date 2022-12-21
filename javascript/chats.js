const allchats = document.querySelector('.div-allchats');

setInterval(() =>{
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/chats.php", true);
    xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
          if(xhr.status === 200){
            let data = xhr.response;
            allchats.innerHTML = data;
            // allchats.innerHTML = "ok";
        }
    }
    }
    xhr.send();
  }, 500);