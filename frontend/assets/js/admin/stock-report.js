var rowData = null;

document.addEventListener('DOMContentLoaded', function(){
    rowData = document.getElementById('table-body');
    getItemData();
})


function getDetail(){
    localStorage.setItem('date',getDate());
    window.location.href = "stock-detail.php"
}

function getView(button){
    var row = button.parentNode.parentNode;
    
    localStorage.setItem('date',row.cells[1].textContent);
    window.location.href = "stock-detail.php"
}



function getItemData() {
    var url = "http://localhost/generous canteen/api/supply/get.php/"
    fetch(url)
    .then(response=>response.json())
    .then(data=>{
        rowData.innerHTML = ``;
        data.forEach(supply =>{
            console.log(supply);
            stringRow = 
            `<tr>
                <td class="supply-id">${supply.id_supply}</td>
                <td class="supply-name">${supply.date}</td>
                <td>${supply.purchase}</td>
                <td>${supply.name}</td>
                <td class="edit-container"><button class="button" id="Edit" onclick="getView(this)">View</button> </td>
                <td><i class="fa-regular fa-trash-can" onclick="deleteItem(this)"></i></th>                    
            </tr>`
            rowData.innerHTML += stringRow;
        });
    })
}

function addItem() {
    window.location.href = "add-stock.php"
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
        if(result){
            url = `http://localhost/generous canteen/api/supply/delete.php/?id=${row.cells[0].textContent}`;
            fetch(url)
            .then(response=>response.json())
            .then(data=>{
                showAlert(data['massage'], function(result){
                    if(result){
                        location.reload();  
                    }
                });
            })
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