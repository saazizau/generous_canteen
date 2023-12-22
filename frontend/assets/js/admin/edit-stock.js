var input_id = document.getElementById('id');
var input_date = document.getElementById('date');
var input_name = document.getElementById('name');
var input_price = document.getElementById('price');
var input_purchase = document.getElementById('purchase');
var input_qty = document.getElementById('qty');

var idItem = null;
var nameItem = null;
var priceItem = null;
var purchaseItem = null;
var qtyItem = null;
var kalender1 =null; 

document.addEventListener('DOMContentLoaded', function(){
    idItem = localStorage.getItem('itemId');
    nameItem = localStorage.getItem('itemName');
    priceItem = localStorage.getItem('itemPrice');
    qtyItem = localStorage.getItem('itemQty');
    kalender1 = document.getElementById('myDate'); 
    
    input_id = document.getElementById('id');
    input_date = document.getElementById('myDate');
    input_name = document.getElementById('name');
    input_price = document.getElementById('price');
    input_purchase = document.getElementById('purchase');
    input_qty = document.getElementById('qty');
    
    input_id.value = idItem;
    input_date.value = getDate();
    input_name.value = nameItem;
    input_price.value = priceItem;
    input_qty.value = qtyItem;
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


function getUpdate() {
    console.log(kalender1.value);
    var url = `http://localhost/generous canteen/api/item/get-purchase.php/?id=${idItem}`;
    fetch(url) 
    .then(response=>response.json())
    .then(data => {
        var url = `http://localhost/generous canteen/api/item/edit.php/?id=${idItem}&name=${input_name.value}&price=${input_price.value}&qty=${input_qty.value}&date=${kalender1.value}&purchase=${data['purchase']}`;
        fetch(url)
        .then(response=>response.json())
        .then(data => {
            if(data['status'] == 'success'){
                showAlert(`${data['massage']}`, function(result){
                    if(result){
                        window.location.href = "../../frontend/admin/item-report.php";  
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


function getBack(){
    window.location.href = "item-report.php";
}

function getLogout(){
    showConfirm("Apakah anda yakin untuk Logout?", function(result){
        if(result){
            window.location.href = "../../api/logout.php";
        }
    })
}