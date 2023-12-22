var input_id = null;
var input_date = null;
var input_name = null;
var input_price = null;
var input_purchase = null;
var input_qty = null;

var idItem = null;
var nameItem = null;
var priceItem = null;
var purchaseItem = null;
var qtyItem = null;
var kalender = document.getElementById('myDate'); 

document.addEventListener('DOMContentLoaded', function(){
    nameItem = "Item Name";
    priceItem = "Item Price";
    purchaseItem = "Item Purchase";
    qtyItem = "Item Quantity";
    getItemId();

    input_id = document.getElementById('id');
    input_date = document.getElementById('date');
    input_name = document.getElementById('name');
    input_price = document.getElementById('price');
    input_purchase = document.getElementById('purchase');
    input_qty = document.getElementById('qty');
    
    input_date.value = getDate();
    input_name.placeholder = nameItem;
    input_price.placeholder = priceItem;
    input_purchase.placeholder = purchaseItem;
    input_qty.placeholder = qtyItem;
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

function addItem(){
    if (validation()){
        var url = `http://localhost/generous canteen/api/item/add.php/?id=${idItem}&name=${input_name.value}&price=${input_price.value}&qty=${input_qty.value}&date=${kalender.value}&purchase=${input_purchase.value}`;
        fetch(url)
        .then(response=>response.json())
        .then(data => {
            if(data['status'] == 'success'){
                showAlertW(`${data['massage']}`, function(result){
                    
                    if(result){
                        location.reload()
                    }
                });
                ;      
            } else {
                showAlert(`${data['massage']}`, function(result){
                });
            }
        })
        .catch(error => console.error('Error:', error))
    }
}

function validation(){
    if ((input_name.value == '')){
        showAlert("Harap masukkan nama item", function(result){
        });
        return false;
    }
    if ((input_price.value == '')){
        showAlert("Harap masukkan harga jual item", function(result){
        });
        return false;
    }
    if ((input_qty.value == '')){
        showAlert("Harap masukkan banyak item", function(result){
        });
        return false;
    }
    if ((input_purchase.value == '')){
        showAlert("Harap masukkan harga beli item", function(result){
        });
        return false;
    }
    return true;

}

async function getItemId(){
    var url = "http://localhost/generous canteen/api/item/get-newest-id.php/"
    fetch(url)
        .then(response => response.json())
        .then(data => {
            if(data['status'] == 'success'){
                idItem = data['itemId']; 
                input_id.placeholder = idItem;
            }
        })
        .catch(error => console.error('Error:', error, "\n", data))
}

function getBack() {
    window.location.href = "item-report.php";
}

function getLogout(){
    showConfirm("Apakah anda yakin untuk Logout?",function(result){
        window.location.href = "../../api/logout.php";
    })
}