var greetingPlace = document.getElementById('greeting');
var massagePlace = document.getElementById('massage');
var usernamePlace = document.getElementById('username');
var passwordPlace = document.getElementById('password');

document.addEventListener('DOMContentLoaded', function(){
    greetingPlace.innerHTML = `<h1 class="greeting-title">Hi, ${localStorage.getItem('extentionAsk')}!</h1>`;
    massagePlace.innerHTML = '';
})

function getLogin(){
    var level = (localStorage.getItem('extentionAsk') == 'Admin') ? 1 : 2;
    var url = `http://localhost/generous canteen/api/login.php/?username=${usernamePlace.value}&password=${passwordPlace.value}&level=${level}`;
    fetch(url)
    .then(response => response.json())
    .then(data => {
        if(data['status'] == 'success'){
            switch(data['level']){
                case "1":
                    window.location.href = "admin/index.php";
                    break;
                case "2":
                    window.location.href = "officer/index.php";
                    break; 
                default:
                    break;                   
            }
        } else {
            greetingPlace.innerHTML = `<h1 class="greeting-title">Try Again</h1>`;
            massagePlace.innerHTML = `${data['message']}`;
        }
    })
    .catch(error => console.error('Error:', error));    
}

document.getElementById('button-login').addEventListener('click', function (event) {
    // Prevent the default form submission or anchor click behavior
    event.preventDefault();

    // Call the fetchData function
    getLogin();
  });