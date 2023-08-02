document.addEventListener("DOMContentLoaded", getCustomer);


let CustomerArray = []

function getCustomer() {
    fetch("http://localhost:8000/api/admin/customers")
        .then((response) => response.json())
        .then((customers) => {
            CustomerArray = customers.data;
            // console.log(customers.data)
            displayProduct()
        })
        .catch((error) => console.log(error))
}

function displayProduct() {
    const customerList = document.getElementById("table_body");
    customerList.innerHTML = "";
    CustomerArray.forEach((customer) => {
        // console.log(customer)
        const listItem = document.createElement("tr");
      listItem.classList.add('row');
      listItem.innerHTML = `
        <td >${customer.email}</td>
        <td >${customer.first_name}</td>
        <td >${customer.last_name}</td>
      `;
      customerList.appendChild(listItem)
    })
}
