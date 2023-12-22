
///////////////////////FUNGSI POPUP
var waitingCallback;
  
function handleAlert(choice) {
    if (waitingCallback) {
        waitingCallback(choice);
    }
    hideAlert();
}


function showAlert(message, callback) {
    document.getElementById('Message').innerHTML = message;
    document.getElementById('Title').innerHTML = "Alert!";
    waitingCallback = callback;
    document.getElementById('alertPopup').style.display = 'flex';
    document.getElementById('overlay').style.display = 'flex';
    document.getElementById('alertPopup').classList.add('show');
    document.getElementById('overlay').classList.add('show');
  }
  
  // Fungsi untuk menyembunyikan pop-up
function hideAlert() {
    document.getElementById('alertPopup').style.display = 'none';
    document.getElementById('overlay').style.display = 'none';
}

var confirmationCallback;

function showConfirm(message, callback) {
    document.getElementById('MessageC').innerHTML = message;
    confirmationCallback = callback;
    document.getElementById('confirmPopup').style.display = 'flex';
    document.getElementById('overlay').style.display = 'flex';
    document.getElementById('confirmPopup').classList.add('show');
    document.getElementById('overlay').classList.add('show');
}

function hideConfirm() {
    document.getElementById('confirmPopup').style.display = 'none';
    document.getElementById('overlay').style.display = 'none';
}

function handleConfirm(choice) {
    if (confirmationCallback) {
        confirmationCallback(choice);
    }
    hideConfirm();
}
