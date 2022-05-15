<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <link rel="stylesheet" href="css/Login.css">
    <script src="js/Login.js"></script>
    <style>
        label {
            text-align: left;
        }
        #exit-btn {
            float: right; 
            color: white;
            background-color: red;
            padding: 3px;
            border-radius: 4px;
            margin: 1px;
        }
        #exit-btn:hover {
            opacity: 0.6;
        }
    </style>
</head>
<body>
    <?php
    $serverName = 'localhost';
    $username = 'root';
    $password = '';
    $db = 'car_rental';
    $conn = new mysqli($serverName, $username, $password, $db);

    if ($conn->connect_error) {
        die("error: " . $conn->connect_error);
    }

    
    $username = $name = $email = $password = $repassword = "";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['uname'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['pass'];
        $repassword = $_POST['repassword'];
    }
    ?>
    <div id="center">
        <div id="login">
            <a id="exit-btn" href="Login.php">X</a>
            <h3 style="text-align: center;"> Signup Part</h3>
            
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <div id="container">
                    <br>
                    <label for="name">Name: </label>
                    <input type="text" id="name" name="name" value="<?php
                        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                            if ($_POST['name'] != "") {
                                echo $name;
                            }
                        }
                    ?>" placeholder="<?php 
                        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                            if ($_POST['name'] == "") {
                                echo "Required";
                            }
                        }
                        else {
                            echo "Enter Name";
                        }
                    ?>"> 
                    <br><br>
                    <label for="uname">Username: </label>
                    <input type="text" id="uname" name="uname" value="<?php
                        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                            if ($_POST['uname'] != "") {
                                echo $username;
                            }
                        }
                    ?>" placeholder="<?php 
                        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                            if ($_POST['uname'] == "") {
                                echo "Required";
                            }
                            else {
                                echo "$username";
                            }
                        }
                        else {
                            echo "Enter Username";
                        }
                    ?>"> 
                    <br><br>
                    <label for="email">Email: </label><span><?php if ($_SERVER['REQUEST_METHOD'] == 'POST'){if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                        echo "Invalid email format";
                    }} ?></span>
                    <input type="text" id="email" name="email" value="<?php
                        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                            if ($_POST['email'] != "") {
                                echo $email;
                            }
                        }
                    ?>" placeholder="<?php 
                        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                            if ($_POST['email'] == "") {
                                echo "Required";
                            }
                            else {
                                echo "$email";
                            }
                        }
                        else {
                            echo "Enter Email";
                        }
                    ?>"> 
                    <br><br>
                    <label for="pass">Password: </label>
                    <input type="text" id="pass" name="pass" value="<?php
                        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                            if ($_POST['pass'] != "") {
                                echo $password;
                            }
                        }
                    ?>" placeholder="<?php 
                        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                            if ($_POST['pass'] == "") {
                                echo "Required";
                            }
                            else {
                                echo "$password";
                            }
                        }
                        else {
                            echo "Enter Password";
                        }
                    ?>">    
                    <br><br>
                    <label for="repassword">Repassword: </label>
                    <input type="text" id="repassword" name="repassword" value="<?php
                        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                            if ($_POST['repassword'] != "") {
                                echo $repassword;
                            }
                        }
                    ?>" placeholder="<?php 
                        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                            if ($_POST['repassword'] == "") {
                                echo "Required";
                            }
                            else {
                                echo "$repassword";
                            }
                        }
                        else {
                            echo "Enter Repassword";
                        }
                    ?>"> 
                    <br><br><br>
                    <input type="submit" id = "signup-btn" value="Signup">
                    <?php 
                            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                $username = $_POST['uname'];
                                $name = $_POST['name'];
                                $email = $_POST['email'];
                                $password = $_POST['pass'];
                                $repassword = $_POST['repassword'];
                                if ($username != "" && $name != "" && $email != "" && $password != "" && $repassword != "") {
                                    $password = MD5($_POST['pass']);
                                    $repassword = MD5($_POST['repassword']);
                                    $sql = "SELECT username FROM users WHERE username = '$username'";
                                    $sql2 = "SELECT email FROM users WHERE email = '$email'";
                                    if ($result = mysqli_query($conn, $sql)) {
                                        if ($result->num_rows > 0) {

                                            echo "<h3 id='errorTag'>User already exist !!!</h3>";
                                        }
                                        else {
                                            $result = mysqli_query($conn, $sql2);
                                            if ($result->num_rows > 0) {
                                                echo "<h3 id='errorTag'>User already exist !!!</h3>";
                                            }
                                            else if ($password != $repassword) {
                                                echo "<h3 id='errorTag'>Unmatched password !!!</h3>";
                                            }
                                            else {
                                                $sql = "INSERT INTO users VALUES('$name','$username','$email','$password','1')";
                                                $conn->query($sql);
                                                header("Location:../Car Rental Software/Login.php");
                                            }
                                        }
                                    }
                                }     
                            }
                            $conn->close();
                        ?>
                    
                </div>
            </form>
        </div>
    </div>
    


</body>
</html>