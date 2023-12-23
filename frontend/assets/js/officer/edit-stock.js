var input_id = document.getElementById('id');
var input_date = document.getElementById('date');
var input_name = document.getElementById('name');
var input_qty = document.getElementById('qty');

var idItem = null;
var nameItem = null;
var qtyItem = null;
var kalender1 =null; 

document.addEventListener('DOMContentLoaded', function(){
    idItem = localStorage.getItem('itemId');
    nameItem = localStorage.getItem('itemName');
    qtyItem = localStorage.getItem('itemQty');
    kalender1 = document.getElementById('myDate'); 
    
    input_id = document.getElementById('id');
    input_date = document.getElementById('myDate');
    input_name = document.getElementById('name');
    input_qty = document.getElementById('qty');
    input_lastQty = document.getElementById('lastQty');
    
    input_id.value = idItem;
    input_date.value = getDate();
    input_name.value = nameItem;
    input_lastQty.value = qtyItem;
})

function getDate(){
    // Create a new Date object with the current date and time
    var currentDate = new Date();

    // Extract the components of the date (year, month, day)
    var year = currentDate.getFullYear();
    var month = currentDate.getMonth() + 1; // Months are zero-based, so we add 1
    var day = currentDate.getDate();

    // Display the current date
    return `${year}-${month}-${day}`;
}


function getReport() {
    if(validation()){
        var url = `https://sabrinaazizaulia.com/generous canteen/api/item/get.php/?itemId=${idItem}`;
        fetch(url) 
        .then(response=>response.json())
        .then(data => {
            var url = `https://sabrinaazizaulia.com/generous canteen/api/item/edit.php/?id=${idItem}&name=${input_name.value}&price=${data[0]['price']}&qty=${input_qty.value}&date=${kalender1.value}&purchase=${data[0]['purchase']}`;
            fetch(url)
            .then(response=>response.json())
            .then(data => {
                if(data['status'] == 'success'){
                    showAlert(`${data['massage']} ${data['track'][0]} \n ${data['track'][1]} \n ${data['track'][2]} \n ${data['track'][3]}`, function(result){
                        if(result){
                            window.location.href = "../../frontend/officer/index.php"; 
                        }
                    });    
                         
                } else {
                    showAlert(`${data['massage']} \n ${data['track'][0]} \n ${data['track'][1]} \n ${data['track'][2]} \n ${data['track'][3]}`, function(result){
                    });
                }
            })
            .catch(error => console.error('Error:', error))
        })
        .catch(error => console.error('Error:', error))  
    }
}

function validation(){
    
    if(input_qty.value > input_lastQty.value){
        showAlert("Quantity harus lebih dari atau sama dengan dari Latest Quantity", function(result){
            if(result){

            }
        });
        return false; 
        
    }
    if(input_qty.value < 0){
        showAlert("Quantity tidak bisa negatif", function(result){
            if(result){

            }
        });
        return false; 
    }
    return true;
}

function getBack(){
    window.location.href = "index.php";
}

function getLogout(){
    showConfirm("Apakah anda yakin untuk Logout?", function(result){
        if(result){
            window.location.href = "../../api/logout.php";
        }
    })
}

