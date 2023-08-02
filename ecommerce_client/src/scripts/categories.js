document.addEventListener("DOMContentLoaded", getCategories);

const addbtn = document.querySelector(".add_btn");
const closebtn = document.querySelector(".close_btn");
const popup = document.querySelector(".upload_popup");
const submitbtn = document.querySelector("#submit");
const category_input = document.querySelector("#category") 
closebtn.addEventListener('click', () =>{
    popup.style.display = 'none';
})
addbtn.addEventListener('click', () =>{
    popup.style.display = 'flex';
    getCategories()
})
submitbtn.addEventListener('click', ()=>{
// console.log(category_input.value)
    addCategory()
})

let categorytArray = []

function getCategories() {
    fetch("http://127.0.0.1:8000/api/admin/category/all")
        .then((response) => response.json())
        .then((category) => {
            categorytArray = category.data;
            // console.log(category.data)
            displayCategory()
        })
        .catch((error) => console.log(error))
}

function displayCategory() {
    const categorytList = document.getElementById("table_body");
    categorytList.innerHTML = "";
    categorytArray.forEach((category) => {
        // console.log(category)
        const listItem = document.createElement("tr");
        listItem.classList.add('row');
        listItem.innerHTML = `
            <td >${category.id}</td>
            <td >${category.category}</td>
            <td>
                <a href="#"  onclick='removeCategory(${category.id})'><i class="fa-solid fa-trash" style="color: black"></i></a> 
            </td>
      `;
      categorytList.appendChild(listItem)
    })
}


async function removeCategory(proid){
    try{
        const response = await fetch ("http://localhost:8000/api/admin/category/destroy/" + proid ,{
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
            getCategories()
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


async function addCategory(){
    event.preventDefault()
        if (category_input.value != '') {
            const newCategory = {
                category: category_input.value,
            }
            try{
                const response = await fetch ("http://localhost:8000/api/admin/category/store",{
                    method:"POST",
                    headers:{
                        'Content-Type':'application/json'
                    },
                    body: JSON.stringify(newCategory)
                });

                if (!response.ok) {
                    throw new Error('Network response was not ok');
                  }

                const data = await response.json();
                console.log(data);
                if (data.status === 'Category Created Successfully') {
                    window.location.href = "../../ecommerce/ecommerce_client/categories.html";
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