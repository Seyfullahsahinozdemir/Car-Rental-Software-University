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
    window.location.href = "Signup.html";
}

function signupCheck() {
    let name = document.getElementById("name").value;
    let uname = document.getElementById("uname").value;
    let email = document.getElementById("email").value;
    let pass = document.getElementById("pass").value;
    let repass = document.getElementById("repassword").value;

    if (name == "") {
        document.getElementById("name").placeholder = "* Required"; 
    }
    if (uname == "") {
        document.getElementById("uname").placeholder = "* Required"; 
    }
    if (email == "") {
        document.getElementById("email").placeholder = "* Required"; 
    }
    if (pass == "") {
        document.getElementById("pass").placeholder = "* Required"; 
    }
    if (repass == "") {
        document.getElementById("repassword").placeholder = "* Required"; 
    }

    if (pass !== "" && repass !== "" && pass !== repass) {
        document.getElementById("errorTag").style.visibility = "visible";
    }
    
    if (name !=="" && uname !== "" && email !== "" && pass !== "" && repass !== "" && pass == repass) {
        window.location.href = "Login.html";
    }


}