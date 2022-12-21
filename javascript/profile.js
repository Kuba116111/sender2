const btnShowLink = document.querySelector('.btn-show-link');
const divLink = document.querySelector('.div-link');
const profileLink = document.querySelector('.profile-link');
const profileId = document.querySelector('.profile-id');
const btnProfileLink = document.querySelector('#btn-profile-link');
const btnProfileId = document.querySelector('#btn-profile-id');

btnShowLink.addEventListener("click", function(){
    if (divLink.style.display == "none") {
        divLink.style.display = "block";
    } else {
        divLink.style.display = "none";
    }
});

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