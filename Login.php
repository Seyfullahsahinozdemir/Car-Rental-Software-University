<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/Login.css">
    <script src="js/Login.js"></script>
</head>
<body>
<?php
    session_start();
    $serverName = 'localhost';
    $username = 'root';
    $password = '';
    $db = 'car_rental';
    $conn = new mysqli($serverName, $username, $password, $db);

    if ($conn->connect_error) {
        die("error: " . $conn->connect_error);
    }

    
    $username = $password = "";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['username'];
    }
    ?>
    <div id="center">
        <div id="login">
            <h3> Welcome to Car Rental Software</h3>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <div id="container">
                    <div>
                        <img  id="login-img" src="img/car-rental.png" alt="login-img">
                    </div>
                    <br><br>
                    <label for="uname">Username: </label>
                    <input type="text" id="username" name="username" value="<?php
                        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                            if ($_POST['username'] != "") {
                                echo $username;
                            }
                        }
                    ?>" placeholder="<?php 
                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                        if ($_POST['username'] == "") {
                            echo "Required";
                        }
                    }
                    else {
                        echo "Enter Username";
                    }
                ?>"> 
                    <br><br>
                    <label for="password">Password: </label>
                    <input type="text" id="password" name="password" placeholder="Enter Password">    
                    <br><br><br>
                    <input type="submit" id="login-btn" value="Login">
                    <input onclick="signup()" type="button" id="signup-btn" value="Signup">
                    <?php 
                            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                $username = $_POST['username'];
                                $password = $_POST['password'];
                                if ($username != "" && $password != "") {
                                    $password = MD5($_POST['password']);
                                    $sql = "SELECT username, password,statu FROM users WHERE username = '$username' AND password = '$password'";                                   
                                    if ($result = mysqli_query($conn, $sql)) {
                                        if ($result->num_rows > 0) {
                                            $row = $result->fetch_assoc();                                           
                                            if ($row['statu'] == "1") {
                                                $_SESSION['username'] = $row['username'];
                                                $_SESSION['statu'] = $row['statu'];
                                                header("Location:../Car Rental Software/Customer.php");
                                            }
                                            else {
                                                $_SESSION['username'] = $row['username'];
                                                $_SESSION['statu'] = $row['statu'];
                                                header("Location:../Car Rental Software/MyReservation.php");
                                            }                                   
                                        }
                                        else {
                                            echo "<h3 id='errorTag'>User not found !!!</h3>";
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
    <?php 
         
    ?>
</body>
</html>