const savedUserName = localStorage.getItem("username");

if(username){
    document.getElementById("yourAccount").textContent = "Hello, " + savedUserName + "!👋";
}else {
    window.location.href("../../index.html");
}