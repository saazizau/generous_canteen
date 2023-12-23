var theDay = localStorage.getItem('date');

var rowData = document.getElementById('table-body');
var kalender = document.getElementById('myDate'); 
var totalPrice = document.getElementById('TotalPrice'); 

document.addEventListener('DOMContentLoaded', function(){
    kalender.value = theDay;
    getItemData();
    getPrice();
})

kalender.addEventListener('change', function(){
    getItemData();
    getPrice();
});

function getItemData() {
    rowData.innerHTML = ``;
    var url = `http://localhost/generous canteen/api/sales/get.php/?date=${kalender.value}`
    fetch(url)
    .then(response=>response.json())
    .then(data=>{
        
        var total_price = 0;
        data.forEach(item =>{
            console.log(item);
            var totPrice = parseInt(item.price) * parseInt(item.item_sold);
            stringRow = 
            `<tr>
                <td class="item-id">${item.id}</td>
                <td class="item-name">${item.name}</td>
                <td>${item.price}</td>
                <td>${item.item_sold}</td>
                <td>${totPrice}</td>                    
            </tr>`
            rowData.innerHTML += stringRow;
            total_price += parseInt(totPrice);
        });
        totalPrice.innerHTML = `${total_price}`;
    })
}

function getPrice(){
    var totSel = document.getElementById("TotalSell");
    var url = `http://localhost/generous canteen/api/sales/get-price.php/?date=${kalender.value}`;
    console.log(url);
    fetch(url)
    .then(response=>response.json())
    .then(data=>{
        totSel.innerHTML = data['price'];
    });
}

function print(){
    console.log(kalender.value)
}

function getBack(){
    window.location.href = "index.php" 
}

function getLogout(){
    showConfirm("Apakah anda yakin untuk Logout?", function(result){
        if(result){
            window.location.href = "../../api/logout.php";
        }
    })
}