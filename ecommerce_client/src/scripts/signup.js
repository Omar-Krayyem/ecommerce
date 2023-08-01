document.addEventListener("DOMContentLoaded", async function (){
    let first_name = document.getElementById('first_name');
    let last_name = document.getElementById('last_name');
    let email = document.getElementById('email');
    let password = document.getElementById('password');
    let err = document.getElementById("error");
    const signup_btn = document.getElementById('signupbtn');

    signup_btn.addEventListener("click", async()=>{
        event.preventDefault()
        if (first_name.value != '' && last_name.value != '' && email.value != '' && password.value != '') {
            const body = {
                email: email.value,
                first_name: first_name.value,
                last_name: last_name.value,
                password: password.value
            }
            const newUser = JSON.stringify(body);
            try{
                const response = await fetch ("http://localhost:8000/api/register",{
                    method:"POST",
                    headers:{
                        'Content-Type':'application/json'
                    },
                    body: newUser
                })
                const data = await response.json();
                if (data.success) {
                    window.location.href = "../../home.html";
                } else {
                    err.innerText = data.message;
                }
                // .then(response =>{
                //     console.log(response.json())
                //     window.location.href = "../../home.html";
                // })
            }
            catch(error){
                console.log('There was an error', error);
            }
        }
        else{
            err.innerText = "Fill all requirement"
        }
        
    });
})