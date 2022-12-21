const chatUserId = document.querySelector(".chat-user-id");
const chat_id = document.querySelector('#chat_id').value;
const user_id = document.querySelector('#user_id').value;
const allmessages = document.querySelector('.messages');
const formSendMessage = document.querySelector('.formsendmessage');
const sendMessage = document.querySelector('#floatingMessage');
const sendBtn = document.querySelector('.sendbtn');
const chat_id1 = document.querySelector('#chat_id1').value;
const user_id1 = document.querySelector('#user_id1').value;
// const dateTime = document.querySelector('#datetime').value;

formSendMessage.onsubmit = (e)=>{
  e.preventDefault();
}

// function DateAndTime() {
//   const actuall = new Date();
//   day = `${actuall.getDate()} ${actuall.getMonth()} ${actuall.getFullYear()}`;
//   return day;
// }

sendBtn.onclick = ()=>{
  if(sendMessage.value !== '' && sendMessage.value !== ' ')
  {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/sendmessage.php", true);
    xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
        if(xhr.status === 200){
          sendMessage.value = "";
          scrollToBottom();
        }
      }
    }
    let DataSendMessage = new FormData(formSendMessage);
    xhr.send(DataSendMessage);
  }
}

setInterval(() =>{
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "php/messages.php", true);
  xhr.onload = ()=>{
    if(xhr.readyState === XMLHttpRequest.DONE){
      if(xhr.status === 200){
        let data = xhr.response;
        allmessages.innerHTML = data;
        // dateTime.innerHTML = DateAndTime();
          // allchats.innerHTML = "ok";
          // scrollToBottom();
      }
    }
  }
  let DataChatUserId = new FormData(chatUserId);
  xhr.send(DataChatUserId);
  }, 100);



function scrollToBottom(){
  setTimeout(() => {
    allmessages.scrollTop = allmessages.scrollHeight;
  }, 150);
}