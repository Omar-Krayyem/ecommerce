document.addEventListener("DOMContentLoaded", getProduct);
const submitbtn = document.querySelector("#submit");
const closebtn = document.querySelector(".close_btn");
const popup = document.querySelector(".upload_popup");
const popup_update = document.querySelector(".upload_popup_update");
const addbtn = document.querySelector(".add_btn");
const name = document.querySelector("#name");
const description = document.querySelector("#description");
const price = document.querySelector("#price");
const category = document.querySelector("#category").value;

const name_up = document.querySelector("#name_up");
const description_up = document.querySelector("#description_up");
const price_up = document.querySelector("#price_up");
const id_up = document.querySelector("#id_up");
const category_up = document.querySelector("#category_up").value;
const submitbtn_up = document.querySelector("#submit_up");
const closebtn_up = document.querySelector(".close_btn_up");
closebtn_up.addEventListener('click', ()=>{
    popup_update.style.display = 'none';
})

closebtn.addEventListener('click', () =>{
    popup.style.display = 'none';
})
addbtn.addEventListener('click', () =>{
    popup.style.display = 'flex';
    getCategories()
})

submitbtn.addEventListener('click', ()=>{
    addProduct()
})

async function addProduct(){
    event.preventDefault()
        if (name.value != '' && description.value != '' && price.value != '') {

            const newProduct = {
                name: name.value,
                description: description.value,
                price: price.value,
                product_categories_id: category,
            }
            try{
                const response = await fetch ("http://localhost:8000/api/admin/product/store",{
                    method:"POST",
                    headers:{
                        'Content-Type':'application/json'
                    },
                    body: JSON.stringify(newProduct)
                });

                if (!response.ok) {
                    throw new Error('Network response was not ok');
                  }

                const data = await response.json();
                console.log(data);
                if (data.status === 'Product Created Successfully') {
                    window.location.href = "../../ecommerce/ecommerce_client/products.html";
                }
                else {
                    console.error('Registration failed:', data.message);
                  }
            }
            catch(error){
                console.log('There was an error', error);
            }
        }
        else{
            // err.innerText = "Fill all requirement"
            return false;
        }
}
categoryArray =  []

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
    const categoryList = document.getElementById("category");
    categoryList.innerHTML = "";
    categoryArray.forEach((category) => {
        // console.log(product)
    //   const listItem = document.createElement("option");
    //   listItem.classList.add('category');
    categoryList.innerHTML += `
        <option value="${category.id}">${category.category}</option>
        
      `;
      //categoryList.appendChild(listItem)
    })
  
  }

  

 

let productArray = []

function getProduct() {
    fetch("http://127.0.0.1:8000/api/admin/product/all")
        .then((response) => response.json())
        .then((products) => {
            productArray = products.data;
            console.log(products)
            displayProduct()
        })
        .catch((error) => console.log(error))
}

function displayProduct() {
    const productList = document.getElementById("table_body");
    productList.innerHTML = "";
    productArray.forEach((product) => {
        // console.log(product)
        const listItem = document.createElement("tr");
      listItem.classList.add('row');
      listItem.innerHTML = `
        <td >${product.id}</td>
        <td >${product.name}</td>
        <td >${product.description}</td>
        <td>${product.category.category}</td>
        <td>
            <a href="#"  onclick='removeProduct(${product.id})'><i class="fa-solid fa-trash" style="color: black"></i></a> 
            <a href="#"  onclick='updateProduct_get(${product.id})'><i class="fa-solid fa-pen-to-square" style="color: black"></i></a>
        </td>
      `;
      productList.appendChild(listItem)
    })
}

function updateProduct_get(proid){
    popup_update.style.display = 'flex';
    submitbtn.textContent = "Update";

    getCategories_up()

    fetch("http://127.0.0.1:8000/api/admin/product/" + proid)
    .then((response) => response.json())
    .then((product) => {
        product = product.data;
        console.log(product)
        id_up.value = product.id
        name_up.value = product.name
        description_up.value = product.description
        price_up.value = product.price
        category_up.value = product.category
    })
    .catch((error) => console.log(error))
}

submitbtn_up.addEventListener('click' , ()=>{
    updateProduct_post();
})

async function updateProduct_post(){
    event.preventDefault()
        if (name_up.value != '' && description_up.value != '' && price_up.value != '') {
            console.log(id_up.value)
            const newProduct = {
                name: name_up.value,
                description: description_up.value,
                price: price_up.value,
                product_categories_id: document.querySelector('#category_up').value,
            }
            try{
                const response = await fetch ("http://localhost:8000/api/admin/product/update/" + id_up.value,{
                    method:"POST",
                    headers:{
                        'Content-Type':'application/json'
                    },
                    body: JSON.stringify(newProduct)
                });
                console.log(newProduct)
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                  }
                const data = await response.json();
                console.log("omar");
                if (data.status === 'Updated Successfully') {
                    window.location.href = "../../ecommerce/ecommerce_client/products.html";
                }
                else {
                    console.error('Registration failed:', data.message);
                  }
            }
            catch(error){
                console.log('There was an error', error);
            }
        }
        else{
            // err.innerText = "Fill all requirement"
            return false;
        }
}

function getCategories_up(){
    fetch("http://127.0.0.1:8000/api/client/home/categories")
        .then((response) => response.json())
        .then((categories) => {
            categoryArray = categories.data;
            console.log(categories)
            displayCategory_up()
        })
        .catch((error) => console.log(error))
  }

  function displayCategory_up() {
    const categoryList = document.getElementById("category_up");
    categoryList.innerHTML = "";
    categoryArray.forEach((category) => {
        // console.log(product)
    //   const listItem = document.createElement("option");
    //   listItem.classList.add('category');
    categoryList.innerHTML += `
        <option value="${category.id}">${category.category}</option>
        
      `;
      //categoryList.appendChild(listItem)
    })
  
  }

async function removeProduct(proid){
    // let product_id = proid

    // const removeItem = {
    //     id: product_id,
    // }

    try{
        const response = await fetch ("http://localhost:8000/api/admin/product/destroy/" + proid ,{
            method:"DELETE",
            headers:{
                'Content-Type':'application/json'
            },
            // body: JSON.stringify(removeItem)
        });

        if (!response.ok) {
            throw new Error('Network response was not ok');
          }
        const data = await response.json();
        console.log(data);
        if (data.status === 'Deleted Successfully') {
            console.log("added")
            getProduct()
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