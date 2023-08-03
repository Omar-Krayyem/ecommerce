document.addEventListener("DOMContentLoaded", getCartItems);

let itemArray = []

function getCartItems(){
    let user_id = localStorage.getItem('user_id')
    fetch("http://127.0.0.1:8000/api/client/cart/" + user_id)
        .then((response) => response.json())
        .then((items) => {
            itemArray = items.data;
            displayItems()
        })
        .catch((error) => console.log(error))
}

function displayItems() {
    const itemList = document.getElementById("table_body");
    itemList.innerHTML = "";
    itemArray.forEach((item) => {
        // console.log(item)
        const listItem = document.createElement("tr");
        listItem.classList.add('row');
        listItem.innerHTML = `
        <td ><img src="src/img/laptop.jpg"></td>
        <td >${item.product.name}</td>
        <td >${item.product.description}</td>
        <td>${item.product.price}</td>
        <td>
            <a href="#"  onclick='removeitem(${item.id})'><i class="fa-solid fa-trash" style="color: black"></i></a> 
        </td>
      `;
      itemList.appendChild(listItem)
    })
}

async function removeitem(id){
    let item_id = id

    try{
        const response = await fetch ("http://127.0.0.1:8000/api/client/cart/destroy/"+item_id,{
            method:"GET",
            headers:{
                'Content-Type':'application/json'
            },
        });

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        const data = await response.json();
        console.log(data);
        if (data.status === 'Deleted Successfully') {
            console.log("added")
            // window.location.href = "../../ecommerce/ecommerce_client/home.html";
        }
        else {
            console.error('Registration failed:', data.message);
          }

    }
    catch(error){
        console.log('There was an error', error);
    }
    getCartItems()
}