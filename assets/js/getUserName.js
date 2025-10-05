const form = document.getElementById("loginForm");
const userName = document.getElementById("username");

form.addEventListener("submit", function(event){
    event.preventDefault();// Chặn reload trang

    let valid = true;

    if(!userName.value.trim()){
        valid = false;
    } else {
        localStorage.setItem("username" , userName.value);
    }

    if(valid){
        window.location.href = "../../shop.php";
    }

})