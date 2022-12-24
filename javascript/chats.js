const allchats = document.querySelector('.div-allchats');

let data_old = '';

setInterval(() =>{
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/chats.php", true);
    xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
          if(xhr.status === 200){
            let data = xhr.response;
            // allchats.innerHTML = "ok";
            if(data !== data_old)
            {
              data_old = data;
              allchats.innerHTML = data;
            }
        }
    }
    }
    xhr.send();
  }, 100);