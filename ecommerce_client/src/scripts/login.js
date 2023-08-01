document.addEventListener("DOMContentLoaded", async function (){
    let email = document.getElementById('email');
    let password = document.getElementById('password');
    let err = document.getElementById("error");
    const login_btn = document.getElementById('loginbtn');

    login_btn.addEventListener("click", async()=>{
        event.preventDefault()
        if ( email.value != '' && password.value != '') {
            const user = {
                email: email.value,
                password: password.value
            }
            try{
                const response = await fetch ("http://localhost:8000/api/login",{
                    method:"POST",
                    headers:{
                        'Content-Type':'application/json'
                    },
                    body: JSON.stringify(user)
                });

                if (!response.ok) {
                    throw new Error('Network response was not ok');
                  }
                const data = await response.json();
                console.log(data);
                if (data.status === 'success') {
                    console.log(data.authorisation.token);
                    localStorage.setItem("user_id", data.user.id);
                    localStorage.setItem("token", data.authorisation.token);
                    window.location.href = "../../ecommerce/ecommerce_client/home.html";
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
            err.innerText = "Fill all requirement"
        }
    });
})