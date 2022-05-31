<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car List</title>
    
    <link rel="stylesheet" href="css/Navbar.css">
    <link rel="stylesheet" href="css/Table.css">
    <link rel="stylesheet" href="css/Manager.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="../Car Rental Software/js/Manager.js"></script>
    <script src="js/Navbar.js"></script>
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script>
        
        $(document).ready(function() {
            let car_id = document.getElementsByClassName('car-id');
            let car_names = document.getElementsByClassName('car-name');
            let car_model = document.getElementsByClassName('car-model');
            let car_price = document.getElementsByClassName('car-price');
            let car_state = document.getElementsByClassName('car-state');
            let car_seat = document.getElementsByClassName('car-seat');
            let car_day = document.getElementsByClassName('car-day');
            let update_btn = document.getElementsByClassName('update-btn');
            let delete_btn = document.getElementsByClassName('delete-btn');
            
            for (var i=0; i < update_btn.length; i++) {
                update_btn[i].id = car_names[i].textContent;
                let id = car_id[i].textContent;
                let name = car_names[i].textContent;
                let model = car_model[i].textContent;
                let price = car_price[i].textContent;
                let state = car_state[i].textContent;
                let seat = car_seat[i].textContent;
                let day = car_day[i].textContent;

                console.log(name);
                console.log(model);
                update_btn[i].onclick = function () {
                    editCarForm(id,name,model,price,state,seat,day)
                };
                console.log(car_id[i].textContent);
                delete_btn[i].onclick = function () {
                    deleteForm(id);
                }
            }
            });
            
            function tempClose() {
            document.getElementById("temp-reservation").style.display = "none";
        }
      </script>
   </head>
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
    $flag = 0;
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

            <div id = 'temp-reservation' class="form-popup" style="background-color:#ddd;<?php if (isset($_POST['list-car-reservation-btn'])) {
                    echo "display: block;";
                }else {
                    echo "display:none;";
                } ?>">
                <h3>Reservation List</h3>
                    <?php
                        if (isset($_POST['list-car-reservation-btn'])) {
                            $carnn = $_POST['car-reservation-name'];
                            $sql = "SELECT * FROM reservation WHERE carname = '$carnn'";
                            $result= mysqli_query($conn,$sql);
                            if ($result->num_rows > 0) {
                                echo "<table><tr>
                                <th>UserName</th>
                                <th>Start</th>
                                <th>Finish</th>
                                <th>Price</th></tr>
                                ";
                                while ($row=$result->fetch_assoc()) {
                                    /*$un = $row['username'];
                                    $s = $row['start'];
                                    $f = $row['finish'];
                                    $tp = $row['totalPrice'];*/

                                    echo "<tr><td>".$row['username']."</td>
                                    <td>".$row['start']."</td>
                                    <td>".$row['finish']."</td>
                                    <td>".$row['totalPrice']."</td></tr>
                                    ";
                                }
                                echo "</table>";
                            }
                            else {

                                echo "<h3 id = 'errorTag'>No reservation found</h3>";

                            }
                        }
                    ?>
                    <a id = 'close-reservation-list' class='close' onclick="tempClose()"></a>
                </div>

                <div id="car-list-div">
                    <a onclick="openForm()" id="manager-add-btn">Add New Car</a>
                    <div class="form-popup" id="myForm" style="<?php if (isset($_POST['add_form'])) { checkAll($conn,1); } ?>">
                        <form id='add_form' enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="form-container">
                          <h3>Add New Car</h3>
                      
                          <label for="name"><b>Name:</b></label><span style = 'color:red;'>*<?php if (isset($_POST['add_form'])) { checkName($conn,1); } ?></span>
                          <input id="name" type="text" placeholder="Enter Name" value="<?php
                            if (isset($_POST['add_form'])) {
                                if (checkName($conn,0) != 1) {
                                   echo $_POST['name'];
                                }
                            }
                          ?>" name="name" maxlength="30" required>
                      
                          <label for="model"><b>Model:</b></label>
                          <input id="model" type="text" placeholder="Enter Model" value="<?php
                            if (isset($_POST['add_form'])) {
                                echo $_POST['model'];
                            }
                          ?>" name="model" maxlength="30" required>

                          <label for="price"><b>Price:</b></label><span style = 'color:red;'>*<?php if (isset($_POST['add_form'])) { checkPrice(1); } ?></span>
                          <input id="price" type="text" placeholder="Enter Price" value="<?php
                            if (isset($_POST['add_form'])) {
                                if (checkPrice(0) != 1) {
                                   echo $_POST['price'];
                                }
                            }
                          ?>" name="price" required>  
                          
                          <label for="img"><b>Image:</b></label><span style = 'color:red;'>*<?php if (isset($_POST['add_form'])) { checkImage(1); } ?></span><br>
                          <input style="height: 50px; padding-top: 15px;" type="file" placeholder="Choose Image" name="img" required>   
                          <br>
                          
                          <label for="numberSeat"><b>Number Seat:</b></label><span style = 'color:red;'>*<?php if (isset($_POST['add_form'])) { checkSeatNum(1); } ?></span>
                          <input id="numSeat" type="text" placeholder="Enter Number" value="<?php
                            if (isset($_POST['add_form'])) {
                                if (checkSeatNum(0) != 1) {
                                   echo $_POST['numberSeat'];
                                }
                            }
                          ?>" name="numberSeat" required>  

                        <label for="numberDay"><b>Max Day:</b></label><span style = 'color:red;'>*<?php if (isset($_POST['add_form'])) { checkDayNum(1); } ?></span>
                          <input id="numDay" type="text" placeholder="Enter Number" value="<?php
                            if (isset($_POST['add_form'])) {
                                if (checkDayNum(0) != 1) {
                                   echo $_POST['numberDay'];
                                }
                            }
                          ?>" name="numberDay" required>  

                          <input type="submit" name = 'add_form' class="btn" form="add_form" value="Add Car"></input>
                          <a href="Manager_CarList.php" onclick="closeForm()" class="close"></a>
                        
                          <?php  

                            function checkImage($val) {
                                $imageType = strtolower(pathinfo($_FILES['img']['name'],PATHINFO_EXTENSION));
                                if ($imageType != " jpg " && $imageType != "png" && $imageType != " jpeg ") {
                                    if ($val == 1) {echo "<span style = 'color:red;'>only JPG, JPEG, PNG</span>";}
                                    
                                    return 1;
                                }
                                return 0;
                            }

                            function checkName($conn,$val) {
                                $name = $_POST['name'];

                                $sql = "SELECT name FROM cars WHERE name ='$name'";
                                $result = mysqli_query($conn,$sql);
                                if ($result->num_rows > 0) {
                                    if ($val == 1) {echo "name already used";}                                       

                                    return 1;
                                }
                                return 0;
                            }
                            
                            function checkPrice($val) {
                                $price = $_POST['price'];
                                if (!preg_match("/^[0-9]+$/", $price)) {
                                    if ($val == 1) {
                                        echo "Invalid Price entered"; 
                                        return 1;
                                    }
                                    else {
                                        return 1;
                                    }
                                }
                                return 0;
                            }

                            function checkDayNum($val) {   
                                $numDay = $_POST['numberDay'];
                                if (!preg_match("/^[0-9]+$/", $numDay) || $numDay > 31) {             
                                    if ($val == 1) {
                                        echo "Invalid Number entered";
                                        return 1;
                                    }
                                    else {
                                        return 1;
                                    } 
                                 }
                                return 0;
                            }

                            function checkSeatNum($val) {   
                                $numSeat = $_POST['numberSeat'];
                                if (!preg_match("/^[0-9]+$/", $numSeat) || $numSeat > 10) {             
                                    if ($val == 1) {
                                        echo "Invalid Number entered";
                                        return 1;
                                    }
                                    else {
                                        return 1;
                                    } 
                                 }
                                return 0;
                            }

                            function checkAll($conn,$val) {
                                if ((checkImage(0) == 1 || checkName($conn,0) == 1 || checkPrice(0) == 1 || checkSeatNum(0) == 1 || checkDayNum(0) == 1)) {
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
                                $model = $_POST['model'];
                                $price = (int) $_POST['price'];
                                $numberSeat = (int) $_POST['numberSeat'];
                                $numberDay = (int) $_POST['numberDay'];
                                $temp_img = $_FILES['img']['tmp_name'];
                                $actual_img = $name."_".$_FILES['img']['name'];
                                $upload_folder = "uploads/";
                                if (!empty($name) && !empty($model) && !empty($price) && !empty($numberSeat) && !empty($numberDay) && !empty($_FILES['img']['name']) && !checkAll($conn,0)) {
                                    //$sql = "INSERT INTO cars (name,model,price,image,numberSeat,state,day) VALUES ('$name','$model','$price','".$_FILES['img']['name']."','$numberSeat','empty','$numberDay')";
                                    
                                    $sql = "INSERT INTO cars (name,model,price,image,numberSeat,state,day) VALUES ('$name','$model','$price','".$actual_img."','$numberSeat','empty','$numberDay')";
                                    
                                    move_uploaded_file($temp_img,$upload_folder.$actual_img);
                                    $conn->query($sql);
                                }
                            }
                                
                          ?>
                        </form>
                      </div>
                      <!-- Edit Section -->

                    <div class="form-popup" id="updateForm" style="<?php if (isset($_POST['edit_form'])) { editcheckAll($conn,1); } ?>">
                      
                      <form id='edit_form' enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="form-container">
                      <h3>Edit Car</h3>
                      <label for="editID"><b>ID:</b></label>
                      <input id="editID" type="text" value="<?php
                          if (isset($_POST['edit_form'])) {
                            echo $_POST['editID'];
                          }
                      ?>" name="editID" readonly required>

                      <label for="editname"><b>Name:</b></label><span style = 'color:red;'>*<?php if (isset($_POST['edit_form'])) { editcheckName($conn,1); } ?></span>
                      <input id="editname" type="text" placeholder="Enter Name" value="<?php
                          if (isset($_POST['edit_form'])) {
                              if (editcheckName($conn,0) != 1) {
                              echo $_POST['editname'];
                              }
                          }
                      ?>" name="editname" maxlength="30" required>
                  
                      <label for="editmodel"><b>Model:</b></label>
                      <input id="editmodel" type="text" placeholder="Enter Model" value="<?php
                          if (isset($_POST['edit_form'])) {
                              echo $_POST['editmodel'];
                          }
                      ?>" name="editmodel" maxlength="30" required>

                      <label for="editprice"><b>Price:</b></label><span style = 'color:red;'>*<?php if (isset($_POST['edit_form'])) { editcheckPrice(1); } ?></span>
                      <input id="editprice" type="text" placeholder="Enter Price" value="<?php
                          if (isset($_POST['edit_form'])) {
                              if (editcheckPrice(0) != 1) {
                              echo $_POST['editprice'];
                              }
                          }
                      ?>" name="editprice" required>  
                      
                      <label for="editimg"><b>Image:</b></label><span style = 'color:red;'>*<?php if (isset($_POST['edit_form'])) { editcheckImage(1); } ?></span><br>
                      <input style="height: 50px; padding-top: 15px;" type="file" placeholder="Choose Image" name="editimg" required>   
                      <br>

                      <label for="editnumberSeat"><b>Number Seat:</b></label><span style = 'color:red;'>*<?php if (isset($_POST['edit_form'])) { editcheckSeatNum(1); } ?></span>
                      <input id="editnumSeat" type="text" placeholder="Enter Number" value="<?php
                          if (isset($_POST['edit_form'])) {
                              if (editcheckSeatNum(0) != 1) {
                              echo $_POST['editnumberSeat'];
                              }
                          }

                      ?>" name="editnumberSeat" required>  

                    <label for="editnumberDay"><b>Max Day:</b></label><span style = 'color:red;'>*<?php if (isset($_POST['edit_form'])) { editcheckDayNum(1); } ?></span>
                      <input id="editnumDay" type="text" placeholder="Enter Number" value="<?php
                          if (isset($_POST['edit_form'])) {
                              if (editcheckDayNum(0) != 1) {
                              echo $_POST['editnumberDay'];
                              }
                          }

                      ?>" name="editnumberDay" required>

                    <label for="editstate"><b>State:</b></label><span style = 'color:red;'>*<?php if (isset($_POST['edit_form'])) { editcheckState(1); } ?></span>
                      <input list = 'options' id="editstate" type="text" value="<?php
                          if (isset($_POST['edit_form'])) {
                              echo $_POST['editstate'];
                          }
                      ?>" name="editstate" maxlength="30" required>
                      <datalist id="options">
                        <option value="empty">
                        <option value="faulty">
                      </datalist>

                      <input type="submit" name = 'edit_form' form="edit_form" class="btn" value="Edit Car"></input>
                      <a href="Manager_CarList.php" onclick="closeEditForm()" class="close"></a>

                      <?php
                        function editcheckImage($val) {
                            $imageType = strtolower(pathinfo($_FILES['editimg']['name'],PATHINFO_EXTENSION));
                            if ($imageType != " jpg " && $imageType != "png" && $imageType != " jpeg ") {
                                if ($val == 1) {echo "<span style = 'color:red;'>only JPG, JPEG, PNG</span>";}
                                
                                return 1;
                            }
                            return 0;
                        }

                        function editcheckState($val) {
                            $state = strtolower($_POST['editstate']);
                            if ($state != 'empty' && $state != 'faulty') {
                                if ($val == 1) {
                                    echo "Empty or Faulty";
                                }
                                else {
                                    return 1;
                                }
                            }
                            return 0;
                        }

                        function editcheckName($conn,$val) {
                            $name = $_POST['editname'];
                            $id = $_POST['editID'];
                            $sql = "SELECT name FROM cars WHERE ID ='$id'";
                            $result = mysqli_query($conn,$sql);
                            $row = $result -> fetch_assoc();

                            if ($row['name'] != $name) {
                                $sql = "SELECT name FROM cars";
                                $result = mysqli_query($conn,$sql);
                                while($row = $result -> fetch_assoc()) {
                                    if ($row['name'] == $name) {
                                        if ($val == 1) {
                                            echo "name already used";
                                            return 1;
                                        }
                                        else {
                                            return 1;
                                        }
                                    }
                                }
                            }
                            return 0;
                        }
                        
                        function editcheckPrice($val) {
                            $price = $_POST['editprice'];
                            if (!preg_match("/^[0-9]+$/", $price)) {
                                if ($val == 1) {
                                    echo "Invalid Price entered"; 
                                }
                                else {
                                    return 1;
                                }
                            }
                            return 0;
                        }

                        function editcheckSeatNum($val) {   
                            $numSeat = $_POST['editnumberSeat'];
                            if (!preg_match("/^[0-9]+$/", $numSeat) || $numSeat > 10) {             
                                if ($val == 1) {
                                    echo "Invalid Number entered";
                                }
                                else {
                                    return 1;
                                } 
                             }
                            return 0;
                        }

                        function editcheckDayNum($val) {   
                            $numDay = $_POST['editnumberDay'];
                            if (!preg_match("/^[0-9]+$/", $numDay) || $numDay > 31) {             
                                if ($val == 1) {
                                    echo "Invalid Number entered";
                                }
                                else {
                                    return 1;
                                } 
                             }
                            return 0;
                        }

                        function editcheckAll($conn,$val) {
                            if ((editcheckImage(0) == 1 || editcheckName($conn,0) == 1 || editcheckPrice(0) == 1 || editcheckSeatNum(0) == 1 || editcheckDayNum(0) == 1 ||  editcheckState(0) == 1)) {
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
                        if (isset($_POST['edit_form'])) {
                            $id = $_POST['editID'];
                            $name = $_POST['editname'];
                            $model = $_POST['editmodel'];
                            $price = (int) $_POST['editprice'];
                            $numberSeat = (int) $_POST['editnumberSeat'];
                            $numberDay = (int) $_POST['editnumberDay'];
                            $state = $_POST['editstate'];
                            $temp_img = $_FILES['editimg']['tmp_name'];
                            $actual_img = $name."_".$_FILES['editimg']['name'];
                            $upload_folder = "uploads/";
                            
                            
                            

                            if (!empty($name) && !empty($id) && !empty($state) && !empty($model) && !empty($price) && !empty($numberSeat) && !empty($_FILES['editimg']['name']) && !editcheckAll($conn,0)) {                               
                                
                                $sql = "UPDATE cars SET image = '".$actual_img."', name = '$name', model = '$model', price = '$price', numberSeat = '$numberSeat', day = '$numberDay', state = '$state' WHERE ID = '$id'";
                                move_uploaded_file($temp_img,$upload_folder.$actual_img);
                                $conn->query($sql);

                                if ($state == 'faulty') {
                                    $userlist = "SELECT DISTINCT r.username, r.start, r.finish FROM reservation r WHERE carname = '$name' AND start > NOW()";
                                    $result_userlist = mysqli_query($conn,$userlist);
                                    while ($row_userlist = $result_userlist->fetch_assoc()) {
                                        $username = $row_userlist['username'];
                                        $start = $row_userlist['start'];
                                        $finish = $row_userlist['finish'];

                                        $groupID = rand();
                                        while (true) {
                                            $sql2 = "SELECT groupID FROM message WHERE groupID = '$groupID'";
                                            $result = mysqli_query($conn,$sql2);
                                            if ($result->num_rows == 0) {
                                                break;
                                            }
                                            else {
                                                $groupID = rand();
                                            }
                                        }
                                        $comment = "Hi $username, Some of the reasons, we need to delete your reservation that start at $start and finish at $finish";
                                        
                                        $admin_username = $_SESSION['username'];
                                        $sql = "INSERT INTO message (customerUsername,groupID,comment,date,statu,receiver) VALUES ('$admin_username','$groupID','$comment',NOW(),0,'$username')";
                                        $result = mysqli_query($conn,$sql);
                                        $sql = "INSERT INTO message_group (groupID,title,subtopic) VALUES ('$groupID','Reservation','$name')";
                                        $result = mysqli_query($conn,$sql);
 
                                        $sql_delete = "DELETE FROM reservation WHERE start > NOW() AND carname = '$name'";
                                        mysqli_query($conn,$sql_delete);
                                    }
                                }

                            }
                        }
                      ?>

                      </form>                       
                  </div>
                      
                          <!-- END EDIT -->
                    <!-- Delete Section -->
                   

                    <div style="height: 175px; overflow-y:hidden" class="form-popup" id="deleteForm">
                      
                      <form style="height: 100%;" id='delete_form' enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="form-container">
                        <h4>Delete Car</h4>
                        <label for=""><b>Do you really want to delete the car?</b></label><br>
                        <input name="deleteid" type = "hidden" id="deleteid" readonly>
                        <input type="submit" name='yes' form="delete_form" value="Yes" style="width: 20%; position:absolute; left:80px; margin-top:20px;"></input>
                        <input type="button" onclick="closeDeleteForm()" form="delete_form"  value="No" style="width: 20%; position:absolute; right:80px; margin-top:20px;"></input>
                      
                        <?php 

                            if (isset($_POST['yes'])) {
                                $id = $_POST['deleteid'];
                                echo $id;
                                $sql = "DELETE FROM cars WHERE ID = '$id'";
                                $result = mysqli_query($conn,$sql);                                
                            }
                        
                        ?>

                        </form>
                    </div>
                    
                      <!-- END Delete Section -->

                      <!-- Search Section -->
                    <div style="text-align: center; padding: 15px;">
                        <form id='search_form' enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                            <input style="margin-right: 20px; font-size: 18px;" type="text" name="car-search" id="car-search" placeholder="Enter Name">
                            <input form = 'search_form' name = 'search_car' type="submit" id="search-past-reservation-btn" value = "Search"></a>
                        </form>
                    </div>
                    <!-- END Search Section -->
                    <div id="scrollable-myReservation" class="scrollable">
                        <table id="carTable">
                            

                        <?php 
                            
                            if (isset($_POST['search_car'])) {
                                $name = $_POST['car-search'];
                                $sql = "SELECT ID,name,image,model,price,state,numberSeat,day FROM cars WHERE name = '$name'";
                                $result = mysqli_query($conn,$sql);
                                if ($name == "") {
                                    $sql = "SELECT ID,name,image,model,price,state,numberSeat,day FROM cars";
                                    $result = mysqli_query($conn,$sql);
                                    if ($result->num_rows > 0) {
                                            echo "<tr>
                                                <th scope='col'>ID</th>
                                                <th scope='col'>Name</th>
                                                <th scope='col'>Image</th>
                                                <th scope='col'>Model</th>
                                                <th scope='col'>Price</th>
                                                <th scope='col'>State</th>
                                                <th scope='col'>Seat</th>
                                                <th scope='col'>Day</th>
                                                <th scope='col'>Options</th>
                                            </tr>";

                                            $counter = 0;
                                            while ($row = $result->fetch_assoc()) {
                                                $tempID = $row['ID'];
                                                $tempN = $row['name'];
                                                $tempI = $row['image'];
                                                $tempM = $row['model'];
                                                $tempP = $row['price'];
                                                $tempSt = $row['state'];
                                                $tempSe = $row['numberSeat'];
                                                $tempD = $row['day'];
                                            
                                                echo "<tr>
                                                    <td class = 'car-id' data-label = 'ID'>".$tempID."</td>
                                                    <td class = 'car-name' data-label = 'Name'>".$tempN."</td>
                                                    <td data-label = 'Image'><img src='uploads/".$tempI."'></td>
                                                    <td class = 'car-model' data-label = 'Model'>".$tempM."</td>
                                                    <td class = 'car-price' data-label = 'Price'>".$tempP."</td>
                                                    <td class = 'car-state' data-label = 'State'>".$tempSt."</td>
                                                    <td class = 'car-seat' data-label = 'Seat'>".$tempSe."</td>
                                                    <td class = 'car-day' data-label = 'Day'>".$tempD."</td>
                                                    <td data-label = 'Options'>
                                                    <a class = 'update-btn'>Update</a><br><br><br>
                                                    <a class = 'delete-btn'>Delete</a><br><br>
                                                    <form id = '$counter' name = 'list-car-reservation' action = 'Manager_CarList.php' method = 'post'>
                                                        <input type = 'hidden' value = '$tempN' name = 'car-reservation-name'>
                                                        <input type = 'submit' value = 'Reservation' name = 'list-car-reservation-btn'>
                                                    </form>
                                                    </td>
                                                </tr>";
                                                $counter++;
                                            }
                                    }
                                }
                                else { 
                                    if ($result->num_rows == 1) {
                                        echo "<tr>
                                        <th scope='col'>ID</th>
                                        <th scope='col'>Name</th>
                                        <th scope='col'>Image</th>
                                        <th scope='col'>Model</th>
                                        <th scope='col'>Price</th>
                                        <th scope='col'>State</th>
                                        <th scope='col'>Seat</th>
                                        <th scope='col'>Day</th>
                                        <th scope='col'>Options</th>
                                    </tr>";

                                    while ($row = $result->fetch_assoc()) {
                                        $tempID = $row['ID'];
                                        $tempN = $row['name'];
                                        $tempI = $row['image'];
                                        $tempM = $row['model'];
                                        $tempP = $row['price'];
                                        $tempSt = $row['state'];
                                        $tempSe = $row['numberSeat'];
                                        $tempD = $row['day'];
    
                                    $counter = 0;
                                        echo "<tr>
                                            <td class = 'car-id' data-label = 'ID'>".$tempID."</td>
                                            <td class = 'car-name' data-label = 'Name'>".$tempN."</td>
                                            <td data-label = 'Image'><img src='uploads/".$tempI."'></td>
                                            <td class = 'car-model' data-label = 'Model'>".$tempM."</td>
                                            <td class = 'car-price' data-label = 'Price'>".$tempP."</td>
                                            <td class = 'car-state' data-label = 'State'>".$tempSt."</td>
                                            <td class = 'car-seat' data-label = 'Seat'>".$tempSe."</td>
                                            <td class = 'car-day' data-label = 'Day'>".$tempD."</td>
                                            <td data-label = 'Options'>
                                             <a class = 'update-btn'>Update</a><br><br><br>
                                             <a class = 'delete-btn'>Delete</a><br><br>
                                             <form id = '$counter' name = 'list-car-reservation' action = 'Manager_CarList.php' method = 'post'>
                                                        <input type = 'hidden' value = '$tempN' name = 'car-reservation-name'>
                                                        <input type = 'submit' value = 'Reservation' name = 'list-car-reservation-btn'>
                                                    </form>
                                            </td>
                                        </tr>";
                                        $counter++;
                                    }
                                }
                                else {
                                    echo "<h3 id = 'errorTag'>No Cars Found</h3>";
                                }
                            }
                            }
                            else {
                                $sql = "SELECT ID,name,image,model,price,state,numberSeat,day FROM cars";
                                $result = mysqli_query($conn,$sql);
                                if ($result->num_rows > 0) {
                                    echo "<tr>
                                        <th scope='col'>ID</th>
                                        <th scope='col'>Name</th>
                                        <th scope='col'>Image</th>
                                        <th scope='col'>Model</th>
                                        <th scope='col'>Price</th>
                                        <th scope='col'>State</th>
                                        <th scope='col'>Seat</th>
                                        <th scope='col'>Day</th>
                                        <th scope='col'>Options</th>
                                    </tr>";
    
                                    while ($row = $result->fetch_assoc()) {
                                        $tempID = $row['ID'];
                                        $tempN = $row['name'];
                                        $tempI = $row['image'];
                                        $tempM = $row['model'];
                                        $tempP = $row['price'];
                                        $tempSt = $row['state'];
                                        $tempSe = $row['numberSeat'];
                                        $tempD = $row['day'];
    
                                    $counter = 0;
                                        echo "<tr>
                                            <td class = 'car-id' data-label = 'ID'>".$tempID."</td>
                                            <td class = 'car-name' data-label = 'Name'>".$tempN."</td>
                                            <td data-label = 'Image'><img src='uploads/".$tempI."'></td>
                                            <td class = 'car-model' data-label = 'Model'>".$tempM."</td>
                                            <td class = 'car-price' data-label = 'Price'>".$tempP."</td>
                                            <td class = 'car-state' data-label = 'State'>".$tempSt."</td>
                                            <td class = 'car-seat' data-label = 'Seat'>".$tempSe."</td>
                                            <td class = 'car-day' data-label = 'Day'>".$tempD."</td>
                                            <td data-label = 'Options'>
                                             <a class = 'update-btn'>Update</a><br><br><br>
                                             <a class = 'delete-btn'>Delete</a><br><br>
                                             <form id = '$counter' name = 'list-car-reservation' action = 'Manager_CarList.php' method = 'post'>
                                                        <input type = 'hidden' value = '$tempN' name = 'car-reservation-name'>
                                                        <input type = 'submit' value = 'Reservation' name = 'list-car-reservation-btn'>
                                                    </form>
                                            </td>
                                        </tr>";
                                        $counter++;
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