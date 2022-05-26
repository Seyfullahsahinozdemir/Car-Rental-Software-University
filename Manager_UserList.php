<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager User List</title>
    <link rel="stylesheet" href="css/Navbar.css">
    <link rel="stylesheet" href="css/Table.css">
    <link rel="stylesheet" href="css/Manager.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="js/Navbar.js"></script>
    <script src="js/Manager.js"></script>
    <script>
        
        $(document).ready(function() {
            let user_username = document.getElementsByClassName('user-username');
            let delete_btn = document.getElementsByClassName('delete-btn');
            console.log(delete_btn.length);
            
            for (var i=0; i < delete_btn.length; i++) {
                let id = user_username[i].textContent;
                delete_btn[i].onclick = function () {
                    deleteForm(id);
                }
            }
        });
            

    </script>
    <style>
        #active {
            background-color: #BBEEBB;
            color: white;
            border-radius: 3px;
            padding: 5px 10px;
            margin: 3px 3px;
            width: 30%;
        }

        #active:hover {
            opacity: 0.8;
        }

        #deactive {
            background-color: #fb607f;
            color: white;
            border-radius: 3px;
            padding: 5px 10px;
            margin: 3px 3px;
            width: 30%;
        }

        #deactive:hover {
            opacity: 0.8;
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

    session_start();
    if (!isset($_SESSION['statu'])) {
        header("Location: /web/Car Rental Software/Login.php");
    }
    else {
        if ($_SESSION['statu'] == 1) {
        header("Location: /web/Car Rental Software/Login.php");

        }
    }
?>
    <div class="box">
        <div class="navbar">
            <?php include "Manager_Navbar.php"; ?>
        </div>
        <div class="content">
            <div id="login">
                <div id="car-list-div">
                    <a onclick="openForm()" id="manager-add-btn">Add New User</a>                    
                    <div class="form-popup" id="myForm" style="<?php if (isset($_POST['add_form'])) { checkAll($conn,1); } ?>">
                        <form id='add_form' enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="form-container">
                          <h3>Add New Car</h3>
                      
                          <label for="name"><b>Name:</b></label>
                          <input id="name" type="text" placeholder="Enter Name" value="<?php
                            if (isset($_POST['add_form'])) {
                                echo $_POST['name'];
                            }
                          ?>" name="name" required>
                      
                          <label for="username"><b>Username:</b></label><span style = 'color:red;'>*<?php if (isset($_POST['add_form'])) { checkUsername($conn,1); } ?></span>
                          <input id="username" type="text" placeholder="Enter Username" value="<?php
                            if (isset($_POST['add_form'])) {
                                if (checkUsername($conn,0) != 1) {
                                    echo $_POST['username'];
                                 }
                            }
                          ?>" name="username" maxlength="30" required>

                        <label for="email"><b>Email:</b></label><span style = 'color:red;'>*<?php if (isset($_POST['add_form'])) { checkEmail($conn,1); } ?></span>
                          <input id="email" type="text" placeholder="Enter Email" value="<?php
                            if (isset($_POST['add_form'])) {
                                if (checkEmail($conn,0) != 1) {
                                    echo $_POST['email'];
                                 }
                            }
                          ?>" name="email" required>

                        <label for="password"><b>Password:</b></label>
                          <input id="password" type="text" placeholder="Enter Password" value="<?php
                            if (isset($_POST['add_form'])) {
                                echo $_POST['password'];
                            }
                          ?>" name="password" required>

                            <input type="submit" name = 'add_form' class="btn" form="add_form" value="Add User"></input>
                            <a href="Manager_UserList.php" onclick="closeForm()" class="close"></a>

                          <?php  

                            function checkUsername($conn,$val) {
                                $username = $_POST['username'];

                                $sql = "SELECT username FROM users WHERE username ='$username'";
                                $result = mysqli_query($conn,$sql);
                                if ($result->num_rows > 0) {
                                    if ($val == 1) {echo "username already used";}                                       

                                    return 1;
                                }
                                return 0;
                            }

                            function checkEmail($conn,$val) {
                                $email = $_POST['email'];

                                $sql = "SELECT email FROM users WHERE email ='$email'";
                                $result = mysqli_query($conn,$sql);
                                if ($result->num_rows > 0) {
                                    if ($val == 1) {echo "email already used";}                                       

                                    return 1;
                                }
                                if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                                    if ($val == 1) {
                                    echo "Invalid email format";
                                    }
                                }
                                return 0;
                            }
                            
                            
                            function checkAll($conn,$val) {
                                if (checkEmail($conn,0) == 1 || checkUsername($conn,0) == 1) {
                                    if ($val == 1) {
                                        echo "display: block;";
                                        return 1;
                                    }
                                    else {
                                        return 1;
                                    }
                                }
                                return 0;
                            }

                            if (isset($_POST['add_form'])) {
                                $name = $_POST['name'];
                                $username = $_POST['username'];
                                $email = $_POST['email'];
                                $password = MD5($_POST['password']);
 
                                if (!empty($name) && !empty($username) && !empty($email) && !empty($password) && !checkAll($conn,0)) {
                                    $sql = "INSERT INTO users (name,username,email,password,statu,active) VALUES ('$name','$username','$email','$password','1',1)";
                                    $conn->query($sql);
                                }
                            }
                                
                          ?>
                        </form>
                      </div>

                      <!-- Delete Section -->
                   

                    <div style="height: 175px; overflow-y:hidden" class="form-popup" id="deleteForm">
                      
                      <form style="height: 100%;" id='delete_form' enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="form-container">
                        <h4>Delete User</h4>
                        <label for=""><b>Do you really want to delete the user?</b></label><br>
                        <input name="deleteid" type = "hidden" id="deleteid" readonly>
                        <input type="submit" name='yes' form="delete_form" value="Yes" style="width: 20%; position:absolute; left:80px; margin-top:20px;"></input>
                        <input type="button" onclick="closeDeleteForm()" form="delete_form"  value="No" style="width: 20%; position:absolute; right:80px; margin-top:20px;"></input>
                      
                        <?php 

                            if (isset($_POST['yes'])) {
                                $username = $_POST['deleteid'];
                                $sql = "DELETE FROM users WHERE username = '$username'";
                                $result = mysqli_query($conn,$sql);                                
                            }
                        
                        ?>

                        </form>
                    </div>
                    
                      <!-- END Delete Section -->

                    <!-- Search Section -->
                    <div style="text-align: center; padding: 15px;">
                        <form id='search_form' enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                            <input style="margin-right: 20px; font-size: 18px;" type="text" name="user-search" id="user-search" placeholder="Enter Name">
                            <input form = 'search_form' name = 'search_user' type="submit" id="search-past-reservation-btn" value = "Search"></a>
                        </form>
                    </div>

                    <!-- END Search Section -->

                    <div id="scrollable-myReservation" class="scrollable">
                        <table id="carTable">


                        <?php 
                            
                            if (isset($_POST['search_user'])) {
                                $name = $_POST['user-search'];
                                $sql = "SELECT name,username,email,password,active FROM users WHERE name = '$name'";
                                $result = mysqli_query($conn,$sql);
                                if ($name == "") {
                                    $sql = "SELECT name,username,email,password,active FROM users";
                                    $result = mysqli_query($conn,$sql);
                                    if ($result->num_rows > 0) {
                                            echo "<tr>
                                                <th scope='col'>Name</th>
                                                <th scope='col'>Username</th>
                                                <th scope='col'>Email</th>
                                                <th scope='col'>Password</th>
                                                <th scope='col'>Options</th>
                                            </tr>";
                                            $counter = 0;
                                            while ($row = $result->fetch_assoc()) {
                                                $tempN = $row['name'];
                                                $tempU = $row['username'];
                                                $tempE = $row['email'];
                                                $tempP = MD5($row['password']);
                                            
                                                if ($row['active'] == 1) {$tempAc = 'active';} else {$tempAc = 'deactive';};
                                            
                                                $u = "active_username_".$counter;
                                                $s = "active_statu_".$counter;

                                                echo "<tr>
                                                <td class = 'user-name' data-label = 'Name'>".$tempN."</td>
                                                <td class = 'user-username' data-label = 'Username'>".$tempU."</td>
                                                <td class = 'user-email' data-label = 'Email'>".$tempE."</td>
                                                <td class = 'user-password' data-label = 'Password'>".$tempP."</td>
                                                <td data-label = 'Options'>";
                                            
                                            echo "<form id = '$counter' method = 'post' action = 'Manager_UserList.php'>
                                            <input type = 'hidden' name = '$u' value = '".$tempU."'>
                                            <input type = 'hidden' name = '$s' value = '".$tempAc."'>
                                            <input style = 'border: none;' type = 'submit' form = '$counter' name = '$counter' id = '".$tempAc."' class = 'active-btn' value = '".$tempAc."'>";
        
                                            echo "</form>";
        
                                            echo "<br><br>
                                                <a class = 'delete-btn'>Delete</a>
                                                </td>
                                            </tr>";
                                            $counter++;
                                            }
                                    }
                                }
                                else { 
                                    if ($result->num_rows > 0) {
                                        echo "<tr>
                                        <th scope='col'>Name</th>
                                        <th scope='col'>Username</th>
                                        <th scope='col'>Email</th>
                                        <th scope='col'>Password</th>
                                        <th scope='col'>Options</th></tr>";
                                        $counter = 0;
                                        while ($row = $result->fetch_assoc()) {
                                            $tempN = $row['name'];
                                            $tempU = $row['username'];
                                            $tempE = $row['email'];
                                            $tempP = MD5($row['password']);
                                            
                                            if ($row['active'] == 1) {$tempAc = 'active';} else {$tempAc = 'deactive';};
                                        
                                            $u = "active_username_".$counter;
                                            $s = "active_statu_".$counter;

                                            echo "<tr>
                                            <td class = 'user-name' data-label = 'Name'>".$tempN."</td>
                                            <td class = 'user-username' data-label = 'Username'>".$tempU."</td>
                                            <td class = 'user-email' data-label = 'Email'>".$tempE."</td>
                                            <td class = 'user-password' data-label = 'Password'>".$tempP."</td>
                                            <td data-label = 'Options'>";
                                        
                                        echo "<form id = '$counter' method = 'post' action = 'Manager_UserList.php'>
                                        <input type = 'hidden' name = '$u' value = '".$tempU."'>
                                        <input type = 'hidden' name = '$s' value = '".$tempAc."'>
                                        <input style = 'border: none;' type = 'submit' form = '$counter' name = '$counter' id = '".$tempAc."' class = 'active-btn' value = '".$tempAc."'>";
    
                                        echo "</form>";
    
                                        echo "<br><br>
                                            <a class = 'delete-btn'>Delete</a>
                                            </td>
                                        </tr>";
                                        $counter++;
                                        }
                                    }
                                    else {
                                        echo "<h3 id = 'errorTag'>No Users Found</h3>";
                                    }
                                }
                            }
                            else {
                                $sql = "SELECT name,username,email,password,active FROM users";
                                $result = mysqli_query($conn,$sql);
                                if ($result->num_rows > 0) {
                                    echo "<tr>
                                        <th scope='col'>Name</th>
                                        <th scope='col'>Username</th>
                                        <th scope='col'>Email</th>
                                        <th scope='col'>Password</th>
                                        <th scope='col'>Options</th>

                                    </tr>";
                                    $counter = 0;
                                    while ($row = $result->fetch_assoc()) {
                                        $tempN = $row['name'];
                                        $tempU = $row['username'];
                                        $tempE = $row['email'];
                                        $tempP = MD5($row['password']);
                                       
                                        if ($row['active'] == 1) {$tempAc = 'active';} else {$tempAc = 'deactive';};
                                    
                                        $u = "active_username_".$counter;
                                        $s = "active_statu_".$counter;

                                        echo "<tr>
                                        <td class = 'user-name' data-label = 'Name'>".$tempN."</td>
                                        <td class = 'user-username' data-label = 'Username'>".$tempU."</td>
                                        <td class = 'user-email' data-label = 'Email'>".$tempE."</td>
                                        <td class = 'user-password' data-label = 'Password'>".$tempP."</td>
                                        <td data-label = 'Options'>";
                                    
                                    echo "<form id = '$counter' method = 'post' action = 'Manager_UserList.php'>
                                    <input type = 'hidden' name = '$u' value = '".$tempU."'>
                                    <input type = 'hidden' name = '$s' value = '".$tempAc."'>
                                    <input style = 'border: none;' type = 'submit' form = '$counter' name = '$counter' id = '".$tempAc."' class = 'active-btn' value = '".$tempAc."'>";

                                    echo "</form>";

                                    echo "<br><br>
                                        <a class = 'delete-btn'>Delete</a>
                                        </td>
                                    </tr>";
                                    $counter = $counter + 1;
                                    }

                            for ($i = 0; $i < $counter; $i++) {
                                if (isset($_POST[strval($i)])) {
                                    $u = "active_username_".$i;
                                    $s = "active_statu_".$i;
                                    $user = $_POST[$u];
                                if ($_POST[$s] == "active") {
                                    $sql_active = "UPDATE users SET active = 0 WHERE username = '$user'";
                                    $sql_deactive = "DELETE FROM reservation WHERE username = '$user' AND start > NOW()";
                                    mysqli_query($conn,$sql_deactive);
                                }
                                else {
                                    $sql_active = "UPDATE users SET active = 1 WHERE username = '$user'";
                                }
                                mysqli_query($conn,$sql_active);
                                
                                }
                            }
                                    
                                }
                                else {
                                    echo "There are no cars at Database";
                                }
                            }
                            
            
                            $conn->close();
                        ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</body>
</html>