document.addEventListener("DOMContentLoaded",()=>{
    getCategories()
    getProduct()
} );

//getCategories

let productArray = []

let categoryArray = []

function getProduct() {
    fetch("http://127.0.0.1:8000/api/client/home/all")
        .then((response) => response.json())
        .then((products) => {
            productArray = products.data;
            // console.log(products)
            displayProduct()
        })
        .catch((error) => console.log(error))
}

function displayProduct() {
    const productList = document.getElementById("cards");
    productList.innerHTML = "";
    productArray.forEach((product) => {
        // console.log(product)
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
                <a href="#" onclick=addFavorite(${product.id})><i class="fa-solid fa-heart" style="color: white ;"></i></a>
                <a href="#" onclick=addCart(${product.id})><i class="fa-solid fa-cart-shopping" style="color: white ;"></i></a>
            </div>
        </div> 
      `;
      productList.appendChild(listItem)
    })
  
  }

async function addFavorite(product_id){

    let user_id = localStorage.getItem('user_id')

    console.log(product_id , user_id)
    const newUser = {
        product_id: product_id,
        user_id: user_id,
    }

    try{
        const response = await fetch ("http://127.0.0.1:8000/api/client/favorite/add",{
            method:"POST",
            headers:{
                'Content-Type':'application/json'
            },
            body: JSON.stringify(newUser)
        });

        if (!response.ok) {
            throw new Error('Network response was not ok');
          }
        const data = await response.json();
        console.log(data);
        if (data.status === 'Favorite Added Successfully') {
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




//   http://127.0.0.1:8000/api/client/favorite/add


  function getCategories(){
    fetch("http://127.0.0.1:8000/api/client/home/categories")
        .then((response) => response.json())
        .then((categories) => {
            categoryArray = categories.data;
            console.log(categories)
            displayCategory()
        })
        .catch((error) => console.log(error))
  }

  function displayCategory() {
    const categoryList = document.getElementById("categories");
    categoryList.innerHTML = "";
    categoryArray.forEach((category) => {
        // console.log(product)
      const listItem = document.createElement("category");
    //   listItem.classList.add('category');
      listItem.innerHTML = `
        <a onclick='getProductById(${category.id})'>${category.category}</a>
        
      `;
      categoryList.appendChild(listItem)
    })
  
  }


  function getProductById($category_id) {
    fetch("http://127.0.0.1:8000/api/client/home/category/" + $category_id)
        .then((response) => response.json())
        .then((products) => {
            productArray = products.data;
            console.log(products.data)
            displayProduct()
        })
        .catch((error) => console.log(error))
}