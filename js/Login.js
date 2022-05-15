function loginCheck() {
    let uname = document.getElementById("username").value;
    let pass = document.getElementById("password").value;
    if (uname == "") {
        document.getElementById("username").placeholder = "* Required"; 
    }
    if (pass == "") {
        document.getElementById("password").placeholder = "* Required"; 
    }

    if (uname == "customer" && pass == "1234") {
        window.location.href = "Customer.html"
    }
    else if (uname == "manager" && pass == "1234") {
        window.location.href = "Manager_Overview.html";
    }
    else {
        if (uname !== "" && pass !== "") {
            document.getElementById("errorTag").style.visibility = "visible";
        }
    }
}

function signup() {
    window.location.href = "Signup.php";
}

function signupCheck() {
    let uname = document.getElementById("uname").value;
    let pass = document.getElementById("pass").value;
    let name = document.getElementById("name").value;
    let email = document.getElementById("email").value;
    let repass = document.getElementById("repassword").value;

    let btn = document.getElementById("errorTag")
    if (uname != "" && pass != "" && name != "" && email != "" && repass != "") {
        
        btn.style.visibility = "visible";
    }
    else {
        btn.style.visibility = "hidden";
    }

}