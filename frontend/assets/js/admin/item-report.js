var rowData = null;

document.addEventListener('DOMContentLoaded', function(){
    rowData = document.getElementById('table-body');
    getItemData();
})


function getItemData() {
    var url = "https://sabrinaazizaulia.com/generous canteen/api/item/get.php/"
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
                <td><i class="fa-regular fa-trash-can" onclick="deleteItem(this)"></i></th>                    
            </tr>`
            rowData.innerHTML += stringRow;
        });
    })
}

function addItem() {
    window.location.href = "add-stock.php";
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

function deleteItem(trashcan){
    var row = trashcan.parentNode.parentNode;
    showConfirm(`Yakin untuk menghapus item ${row.cells[1].textContent}`, function(result){
        console.log(result);
        if(result){
            url = `https://sabrinaazizaulia.com/generous canteen/api/item/delete.php/?id=${row.cells[0].textContent}`;
            fetch(url)
            .then(response=>response.json())
            .then(data=>{
                showAlert(data['massage'], function(result){
                    console.log(result);
                    if(result){
                        location.reload();  
                    }
                });
            })
        }
    })
}

function getDetail(){
    window.location.href = "stock-report.php"
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
