document.addEventListener("DOMContentLoaded", getFavorites);

let productArray = []

function getFavorites(){
    let user_id = localStorage.getItem('user_id')
    fetch("http://127.0.0.1:8000/api/client/favorite/" + user_id)
        .then((response) => response.json())
        .then((products) => {
            productArray = products.data;
            console.log(products.data)
            displayProduct()
        })
        .catch((error) => console.log(error))
}



function displayProduct() {
    const productList = document.getElementById("cards");
    productList.innerHTML = "";
    productArray.forEach((product) => {
        console.log(product)
      const listItem = document.createElement("card");
      listItem.classList.add('card');
      listItem.innerHTML = `
        <div class="face front">
            <div class="card_img"><img src="src/img/laptop.jpg"></div>
            <div class="card_title"><h3>${product.name}</h3></div>
        </div>
        <div class="face back">
            <div class="card_title"><h3>${product.name}</h3></div>
            <div class="card_desc"><p>${product.description}</p></div>
            <div class="card_price">${product.price}</div>
            <div class="card_link">
                <a href="#" onclick=removeFavorite(${product.id})><i class="fa-solid fa-heart" style="color: white ;"></i></a>
                <a href="#" onclick=addCart(${product.id})><i class="fa-solid fa-cart-shopping" style="color: white ;"></i></a>
            </div>
        </div> 
      `;
      productList.appendChild(listItem)
    })
  
}

async function removeFavorite(id){

    let user_id = localStorage.getItem('user_id')
    let product_id = id

    const removeItem = {
        product_id: product_id,
        user_id: user_id,
    }

    try{
        const response = await fetch ("http://127.0.0.1:8000/api/client/favorite/destroy",{
            method:"POST",
            headers:{
                'Content-Type':'application/json'
            },
            body: JSON.stringify(removeItem)
        });

        if (!response.ok) {
            throw new Error('Network response was not ok');
          }
        const data = await response.json();
        console.log(data);
        if (data.status === 'Added Successfully') {
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
    getFavorites()
}


async function addCart(product_id){

    let user_id = localStorage.getItem('user_id')

    console.log(product_id , user_id)
    const newItem = {
        product_id: product_id,
        user_id: user_id,
    }

    try{
        const response = await fetch ("http://127.0.0.1:8000/api/client/cart/add/",{
            method:"POST",
            headers:{
                'Content-Type':'application/json'
            },
            body: JSON.stringify(newItem)
        });

        if (!response.ok) {
            throw new Error('Network response was not ok');
          }
        const data = await response.json();
        console.log(data);
        if (data.status === 'Added Successfully') {
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
}

