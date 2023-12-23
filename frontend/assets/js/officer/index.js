var rowData = null;
var saveButton = document.getElementById('Save');
var cash = document.getElementById('Cash-input');

document.addEventListener('DOMContentLoaded', function(){
    rowData = document.getElementById('table-body');
    getItemData();
    getCash();
})


function getItemData() {
    var url = "https://sabrinaazizaulia.com/generous canteen/api/item/get-avaliable.php/"
    fetch(url)
    .then(response=>response.json())
    .then(data=>{
        rowData.innerHTML = ``;
        data.forEach(item =>{
            stringRow = 
            `<tr>
                <td class="item-id">${item.id}</td>
                <td class="item-name">${item.name}</td>
                <td>${item.price}</td>
                <td>${item.qty}</td>
                <td class="edit-container"><button class="button" id="Edit" onclick="getEdit(this)">Edit</button> </td>                  
            </tr>`
            rowData.innerHTML += stringRow;
        });
    })
}


function getEdit(button) {
    // Get the row containing the button
    var row = button.parentNode.parentNode;

    // Get the value from the desired cell in the row
    localStorage.setItem('itemId', row.cells[0].textContent); // Assuming the value is in the first cell, adjust index as needed
    localStorage.setItem('itemName', row.cells[1].textContent);
    localStorage.setItem('itemPrice', row.cells[2].textContent);
    localStorage.setItem('itemQty', row.cells[3].textContent);


    window.location.href = "edit-stock.php";
}

function getLogout(){
    showConfirm("Apakah anda yakin untuk Logout?", function(result){
        if(result){
            window.location.href = "../../api/logout.php";
        }
    })
}

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

function getCash(){
    var url = `https://sabrinaazizaulia.com/generous canteen/api/sales/get-price.php/?date=${getDate()}`;
    fetch(url)
    .then(response=>response.json())
    .then(data=>{
        if(data['status'] == 'success'){
            if(data['price'] >= 0){
                cash.value = data['price'];
                cash.disabled = true;
                cash.classList.add('cash-disabled');
                saveButton.innerHTML = `Edit`;
                saveButton.onclick = setEditable;
            } else {
                cash.value = `0`;
                cash.disabled = false;
                cash.classList.remove('cash-disabled');
                saveButton.innerHTML = `Save`;
                saveButton.onclick = setCash;
            }
        } else {
            data['massage'];
        }
    })
}

function setCash(){
    showConfirm('Yakin ingin menyimpan data?', function(result){
        if(result){
            var cash = document.getElementById('Cash-input').value;
            var url = `https://sabrinaazizaulia.com/generous canteen/api/sales/set.php/?date=${getDate()}&price=${cash}`;
            fetch(url)
            .then(response=>response.json())
            .then(data=>{
                if(data['status'] == 'success'){
                    showAlert(data['message'], function(result){
                        if(result){
                            location.reload();
                        }
                    });                    
                } else {
                    showAlert(data['message'], function(result){
                        if(result){
                            location.reload();
                        }
                    });
                }
            })
        }
    })
}


function setEditable(){
    saveButton.innerHTML = `Save`;
    cash.disabled = false;
    cash.classList.remove('cash-disabled');
    saveButton.onclick = setCash;
}
