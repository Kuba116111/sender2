const groupUserId = document.querySelector(".group-user-id");
const group_id = document.querySelector('#group_id').value;
const allmessages = document.querySelector('.messages');
const formSendMessage = document.querySelector('.formsendmessage');
const sendMessage = document.querySelector('#floatingMessage');
const sendBtn = document.querySelector('.sendbtn');
const group_id1 = document.querySelector('#group_id1').value;
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
    xhr.open("POST", "php/sendgroupsmessage.php", true);
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

let data_old = '';

setInterval(() =>{
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "php/groups-messages.php", true);
  xhr.onload = ()=>{
    if(xhr.readyState === XMLHttpRequest.DONE){
      if(xhr.status === 200){
        let data = xhr.response;
        if(data !== data_old)
        {
          data_old = data;
          allmessages.innerHTML = data;
        }
        // dateTime.innerHTML = DateAndTime();
          // allchats.innerHTML = "ok";
          // scrollToBottom();
      }
    }
  }
  let DataGroupUserId = new FormData(groupUserId);
  xhr.send(DataGroupUserId);
  }, 100);

function scrollToBottom(){
  setTimeout(() => {
    allmessages.scrollTop = allmessages.scrollHeight;
  }, 150);
}