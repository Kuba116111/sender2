const divChPassword = document.querySelector('#div-chpassword');

function hideChPassworderror() {
    divChPassword.style.display = "none";
}

function fnChPasswordError() {
    setTimeout(hideChPassworderror, 2000);
}

function kolor(){
    a=document.getElementsByTagName('link');
    a[1].setAttribute('href','css/style2.css');
    //b=document.getElementsByTagName('a');
    //b[0].setAttribute('onclick','kolor2()');
}