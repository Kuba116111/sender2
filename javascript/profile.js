const btnShowLink = document.querySelector('.btn-show-link');
const divLink = document.querySelector('.div-link');
const profileLink = document.querySelector('.profile-link');
const profileId = document.querySelector('.profile-id');
const btnProfileLink = document.querySelector('#btn-profile-link');
const btnProfileId = document.querySelector('#btn-profile-id');
const formIdFriend = document.querySelectorAll('.form-friend-id');
const btnDelFriend = document.querySelector('#btn-del-friend');
const btnAddFriend = document.querySelector('#btn-add-friend');

// formIdFriend.onsubmit = (e)=>{
//     e.preventDefault();
// }

function ShowLink(){
    if (divLink.style.display == "none") {
        divLink.style.display = "block";
    } else {
        divLink.style.display = "none";
    }
};

function restorebtnlink() {
    btnProfileLink.innerHTML = "Kopiuj link";
}

function restorebtnid() {
    btnProfileId.innerHTML = "Kopiuj unikalny kod";
}

function profilelinkcopy(){
    // console.log('ok');
    profileLink.select();
    profileLink.setSelectionRange(0, 99999); // For mobile devices
    
    // Copy the text inside the text field
    navigator.clipboard.writeText(profileLink.value);
    
    // Alert the copied text
    btnProfileLink.innerHTML = "Skopiowano!";

    setInterval(restorebtnlink, 2000);
}


function profileidcopy(){
    // console.log('ok');
    profileId.select();
    profileId.setSelectionRange(0, 99999); // For mobile devices
    
    // Copy the text inside the text field
    navigator.clipboard.writeText(profileId.value);
    
    // Alert the copied text
    btnProfileId.innerHTML = "Skopiowano!";

    setInterval(restorebtnid, 2000);
}

function delFriend(){
    // console.log(1);
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/delfriend.php", true);
    xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
          if(xhr.status === 200){
            let data = xhr.response;
            console.log(data);
            if(data==="success"){
                btnDelFriend.style.display="none";
                btnAddFriend.style.display="block";
            }
        }
    }
    }
    let DataFormIdFriend = new FormData(formIdFriend);
    xhr.send(DataFormIdFriend);
  };

function addFriend(){
    // console.log(1);
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/addfriend.php", true);
    xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
          if(xhr.status === 200){
            let data = xhr.response;
            console.log(data);
            if(data==="success"){
                btnAddFriend.style.display="none";
                btnDelFriend.style.display="block";
            }
        }
    }
    }
    let DataFormIdFriend = new FormData(formIdFriend);
    xhr.send(DataFormIdFriend);
  };

function acceptFriend(){
    // console.log(1);
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/acceptfriend.php", true);
    xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
          if(xhr.status === 200){
            let data = xhr.response;
            console.log(data);
            if(data==="success"){
                btnAddFriend.style.display="none";
                btnDelFriend.style.display="block";
            }
        }
    }
    }
    let DataFormIdFriend = new FormData(formIdFriend);
    xhr.send(DataFormIdFriend);
  };