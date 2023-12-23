var theDay = localStorage.getItem('date');

var rowData = document.getElementById('table-body');
var kalender = document.getElementById('myDate'); 
var totalPrice = document.getElementById('TotalPrice'); 

document.addEventListener('DOMContentLoaded', function(){
    kalender.value = theDay;
    getItemData();
})

kalender.addEventListener('change', print());

function getItemData() {
    var url = `https://sabrinaazizaulia.com/generous canteen/api/supply/get-detail.php/?date=${kalender.value}`
    fetch(url)
    .then(response=>response.json())
    .then(data=>{
        rowData.innerHTML = ``;
        var total_purchase = 0;
        data.forEach(item =>{
            console.log(item);
            var totPrice = parseInt(item.purchase) * parseInt(item.qty);
            stringRow = 
            `<tr>
                <td class="item-id">${item.id}</td>
                <td class="item-name">${item.name}</td>
                <td>${item.purchase}</td>
                <td>${item.qty}</td>
                <td>${totPrice}</td>                    
            </tr>`
            rowData.innerHTML += stringRow;
            total_purchase += parseInt(totPrice);
        });
        totalPrice.innerHTML = `${total_purchase}`;
    })
}

function print(){
    console.log(kalender.value)
}

function getBack(){
    window.location.href = "stock-report.php" 
}