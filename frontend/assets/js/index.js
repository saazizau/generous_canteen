function adminLogin(){
    localStorage.setItem('extentionAsk','Admin')
}

function officerLogin(){
    localStorage.setItem('extentionAsk','Officer')
}

function getLogout(){
    window.location.href = "../../api/logout.php";
}