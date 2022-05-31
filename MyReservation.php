<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Reservation</title>
    <link rel="stylesheet" href="css/Navbar.css">
    <link rel="stylesheet" href="css/Reservation.css">
    <link rel="stylesheet" href="css/Table.css">
    <script src="js/Customer.js"></script>
    <script src="js/Navbar.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script>
        
        $(document).ready(function() {
            let car_names = document.getElementsByClassName('car-name');
            let reservation_start = document.getElementsByClassName('reservation-start');
            let reservation_finish = document.getElementsByClassName('reservation-finish');
            let update_btn = document.getElementsByClassName('update-btn');
            let delete_btn = document.getElementsByClassName('delete-btn');

            
            for (var i=0; i < update_btn.length; i++) {
                update_btn[i].id = car_names[i].textContent;
                let name = car_names[i].textContent;
                let start = reservation_start[i].textContent;
                let finish = reservation_finish[i].textContent;

                console.log(name);
                console.log(start);
                console.log(finish);

                update_btn[i].onclick = function () {
                    editReservation(name,start,finish)
                };
                delete_btn[i].onclick = function () {
                    deleteForm(name,start,finish);
                }
            }
            });
            

      </script>
    <style>
        img {
            width: 180px;
        }
    </style>
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
    $flag = 0;
    if (!isset($_SESSION['statu'])) {
        header("Location: /web/Car Rental Software/Login.php");
    }

?>
    <div class="box">
    <div class="navbar">
            <?php 
            if ($_SESSION['statu'] == 1) {
                include "Navbar.php";
            }
            else {
                include "Manager_Navbar.php";
            }
            ?>
    </div>

        <div class="content">
            <div id="login">
                <div id="car-list-div">
                    <div style="text-align: center; padding: 15px;">
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" id="search-form" method="post">
                        <input style="margin-right: 20px; font-size: 18px;" type="date" name="date" id="date" required>
                        <input style="width: 135px;" name="search_reservation" form = 'search-form' type = 'submit' id="search-past-reservation-btn" value="Search"></input>
                    </form>
                    </div>
                    <!-- Edit Section -->
                    <div class="form-popup div2" id="updateForm" style="height: 370px; <?php if (isset($_POST['edit_form'])) {
                        $sdate = new DateTime($_POST['car_start']);
                        $fdate = new DateTime($_POST['car_finish']);
                        $difference=$sdate->diff($fdate);
                        $name = $_POST['car_name'];
                        $sql = "SELECT day FROM cars WHERE name = '$name'";
                        $result = mysqli_query($conn,$sql);
                        $row = $result->fetch_assoc();
                        $date1=date("Y-m-d",strtotime($_POST['car_start']));
                        $date2=date("Y-m-d",strtotime($_POST['car_finish']));
                        $default_start = date("Y-m-d",strtotime($_POST['last_start']));
                        $default_finish = date("Y-m-d",strtotime($_POST['last_finish']));
                        //$sql2 = "SELECT carname FROM reservation WHERE (start > '$date1' AND ('$date2' BETWEEN start AND finish)) AND (('$date1' BETWEEN start AND finish) AND finish < '$date2') AND ('$date1' < start AND '$date2' > finish) AND (('$date1' BETWEEN start AND finish) AND ('$date2' BETWEEN start AND finish)) AND carname = '$name'";
                        $sql2 = "SELECT carname FROM reservation WHERE (('$date1' > start AND '$date1' < finish) OR ('$date2' > start AND '$date2' < finish) OR ('$date1' < start AND '$date2' > finish)) AND carname = '$name' AND start != '$default_start' AND finish != '$default_finish'";
                        
                        $result2 = mysqli_query($conn,$sql2);                   
                        if (checkReservationDate($_POST['car_start'],0) == 1 || checkReservationDate($_POST['car_finish'],0) == 1 || $_POST['car_start'] > $_POST['car_finish'] || $row['day'] < $difference->d || $result2->num_rows > 0) {
                            $flag = 1;
                            echo "display: block";
                            }
                        } ?>">
                      <form id='edit_form' action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="form-container">
                      <h3>Update Reservation</h3>
                      <input name = 'last_start' type="hidden" id = 'last_start' readonly>
                      <input name = 'last_finish' type="hidden" id = 'last_finish' readonly>
                      <label for="car_name"><b>Car Name:</b></label>
                      <input id="car_name" type="text" value="<?php
                          if (isset($_POST['edit_form'])) {
                            echo $_POST['car_name'];
                          }
                      ?>" name="car_name" readonly required>

                    <label for="car_start"><b>Start Date:</b></label><span style = 'color:red;'>*<?php
                     if (isset($_POST['edit_form'])) { $sdate = new DateTime($_POST['car_start']);
                         if (checkReservationDate($_POST['car_start'],0) == 1) {checkReservationDate($_POST['car_start'],1); $flag  =1; }else if ($_POST['car_start'] > $_POST['car_finish']) {echo "Start greater than Finish";  $flag  =1;}else if ($row['day'] < $difference->d) {echo "Not available range";  $flag  =1;} else if ($result2->num_rows > 0) {echo "Car is busy";  $flag  =1;}} ?></span><br>
                      <input style="line-height: 1.25rem; width: 100%;" id="car_start" type="date" value="<?php
                          if (isset($_POST['edit_form'])) {
                            if (checkReservationDate($_POST['car_start'],0) != 1) {
                                echo $_POST['car_start'];
                            }
                          }

                        

                      ?>" name="car_start" required><br><br>

                    <label for="car_finish"><b>Finish Date:</b></label><span style = 'color:red;'>*<?php if (isset($_POST['edit_form'])) { if (checkReservationDate($_POST['car_finish'],0) == 1) {checkReservationDate($_POST['car_finish'],1); }} ?></span><br>
                      <input style="line-height: 1.25rem; width: 100%;" id="car_finish" type="date" value="<?php
                          if (isset($_POST['edit_form'])) {
                            if (checkReservationDate($_POST['car_finish'],0) != 1) {
                                echo $_POST['car_finish'];
                            }
                          }
                      ?>" name="car_finish" required><br><br>

                      <input type="submit" name = 'edit_form' form="edit_form" class="btn" value="Update"></input>
                      <a href="<?php
                      if ($_SESSION['statu'] == 1) {
                        echo "MyReservation.php";
                    }
                    else {
                        echo "MyReservation.php";

                    }
                      ?>" onclick="closeUpdate()" class="close"></a>

                      <?php

                        function checkReservationDate($date,$val) {
                            $date_now = date('Y-m-d');
                            if ($date < $date_now) {
                                if ($val == 1) {
                                    echo "Invalid date entered";
                                    return 1;
                                }
                                else {
                                    return 1;
                                }
                            }
                            return 0;
                        }
                        
                        if (isset($_POST['edit_form'])) { 
                            if ($flag == 0) {                               
                                $last_start=date("Y-m-d",strtotime($_POST['last_start']));
                                $last_finish=date("Y-m-d",strtotime($_POST['last_finish']));
                                $sql3 = "SELECT price FROM cars WHERE name = '$name'";
                                $result = mysqli_query($conn,$sql3);
                                $row = $result->fetch_assoc();
                                $total = ($difference->d + 1) * $row['price'];
                                $sql = "UPDATE reservation SET start = '$date1',finish = '$date2',totalPrice = '$total' WHERE carname = '$name' AND start = '$last_start' AND finish = '$last_finish'";
                                $conn->query($sql);
                            }
                        }
                      ?>

                      </form>                       
                  </div>
                          <!-- END EDIT -->

                          <!-- Delete Section -->
                    <div style="height: 250px; overflow-y:hidden" class="form-popup" id="deleteForm">
                      
                      <form style="height: 100%;" id='delete_form' enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="form-container">
                        <h4>Delete Reservation</h4>
                        <label for="">Do you really want to delete the reservation?</label><br>
                        <input name="delete_carname" type = "hidden" id="delete_carname" readonly>
                        <input name = 'delete_start' type="hidden" id = 'delete_start' readonly>
                        <input name = 'delete_finish' type="hidden" id = 'delete_finish' readonly>
                        <input type="submit" name='yes' form="delete_form" value="Yes" style="width: 20%; position:absolute; left:10%; margin-top:20px;"></input>
                        <input type="button" onclick="closeDeleteForm()" form="delete_form"  value="No" style="width: 20%; position:absolute; right:10%; margin-top:20px;"></input>
                      
                        <?php 

                            if (isset($_POST['yes'])) {
                                $carname = $_POST['delete_carname'];
                                $del_start = $_POST['delete_start'];
                                $del_finish = $_POST['delete_finish'];

                                $sql = "DELETE FROM reservation WHERE carname = '$carname' AND start = '$del_start' AND finish = '$del_finish'";
                                $result = mysqli_query($conn,$sql);                                
                            }
                        
                        ?>

                        </form>
                    </div>
                    
                      <!-- END Delete Section -->


                      <!-- Rate Form -->
                      <div class="form-popup" id="rateForm" style="overflow-y:hidden; margin-top:40px; height: 500px; left:35%;right: 35%; <?php
                        if (isset($_POST['rate-car-btn'])) {
                            echo "display: block";
                        }
                      ?>">
                      <form id='rate_form' action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="form-container">
                      <h3>Rate Your Experience</h3>

                      <input id="carID" name = 'carID' type="hidden" value = '<?php if (isset($_POST['rate-car-btn'])) {echo $_POST['rate-carid'];} ?>' readonly>
                      <input id = 'startd' name = 'startd' type = 'hidden' value = '<?php if (isset($_POST['rate-car-btn'])) {echo $_POST['rate-carstart'];} ?>' readonly>
                      <label for="rating">Stars: </label>
                        <div class="rating">
                            
                            <input type="radio" name="rating" value="5" id="5"><label for="5">☆</label>
                            <input type="radio" name="rating" value="4" id="4"><label for="4">☆</label>
                            <input type="radio" name="rating" value="3" id="3"><label for="3">☆</label>
                            <input type="radio" name="rating" value="2" id="2"><label for="2">☆</label>
                            <input type="radio" name="rating" value="1" id="1" checked><label for="1">☆</label>

                        </div>

                      <label for="comment"><b>Comment:</b></label><br>
                      <textarea name="comment" id="comment" form="rate_form" rows="10" style="width: 80%;" required></textarea>

                      <input type="submit" id = 'rate_comment_form' name = 'rate_comment_form' form="rate_form" class="btn" value="Rate Reservation"></input>
                      <a onclick="closeRate()" class="close"></a>

                      <?php
                        if (isset($_POST['rate_comment_form'])) {
                            $stars = $_POST['rating'];
                            $comment = $_POST['comment'];
                            $username = $_SESSION['username'];
                            $carID = $_POST['carID'];
                            $startd = $_POST['startd'];

                            $sql = "SELECT * FROM rate WHERE carID = '$carID' AND start = '$startd'";
                            $result = mysqli_query($conn,$sql);
                            if ($result->num_rows == 0) {
                                $sql = "INSERT INTO rate (carID,username,stars,comment,start) VALUES ('$carID','$username','$stars','$comment','$startd')";
                                mysqli_query($conn,$sql);
                            }

                            
                        }
                      ?>

                      </form>                       
                  </div>                      
                      <!-- END Rate Form -->

                    <div id="scrollable-myReservation" class="scrollable">
                        <table id="carTable">
                        <?php 
                            $session_username = $_SESSION['username'];

                            if (isset($_POST['search_reservation'])) {
                                $date = $_POST['date'];
                                if (!empty($date)) {
                                    $search_date=date("Y-m-d",strtotime($date));
                                    if ($_SESSION['statu'] == 1) {
                                        $sql = "SELECT c.ID,c.name,c.image,c.model,r.start,r.finish,r.totalPrice FROM cars c,reservation r WHERE c.name = r.carname AND r.username = '$session_username' AND ('$search_date' BETWEEN r.start AND r.finish) ORDER BY r.finish DESC";
                                    }
                                    else {
                                        $sql = "SELECT c.ID,u.username,c.name,c.image,c.model,r.start,r.finish,r.totalPrice FROM cars c, reservation r, users u WHERE c.name = r.carname AND r.username = u.username AND ('$search_date' BETWEEN r.start AND r.finish) ORDER BY r.finish DESC";
                                    }
                                    $result = mysqli_query($conn,$sql);
                                    if ($result->num_rows > 0) {
                                        echo "<tr>";
                                        if ($_SESSION['statu'] == 0) {
                                            echo "<th scope='col'>Username</th>";
                                        }
                                        echo "<th scope='col'>Car Name</th>
                                            <th scope='col'>Car Image</th>
                                            <th scope='col'>Car Model</th>
                                            <th scope='col'>Start Date</th>
                                            <th scope='col'>Finish Date</th>
                                            <th scope='col'>Total Price</th>
                                            <th scope='col'>Options</th>
                                        </tr>";

                                        while ($row = $result->fetch_assoc()) {
                                            if ($_SESSION['statu'] == 0) {
                                                $cu = $row['username'];
                                            }
                                            $cn = $row['name'];
                                            $cID = $row['ID'];
                                            $ci = $row['image'];
                                            $cm = $row['model'];
                                            $rs = $row['start'];
                                            $rf = $row['finish'];
                                            $rtp = $row['totalPrice'];
                                            

                                        
                                            echo "<tr>";
                                            if ($_SESSION['statu'] == 0) {
                                                echo "<td class = 'car-username' data-label = 'Username'>".$cu."</td>";
                                            }
                                            echo "<td class = 'car-name' data-label = 'Car Name'>".$cn."</td>
                                                        <td class = 'car-img' data-label = 'Car Image'><img src = 'uploads/".$ci."'></td>
                                                        <td class = 'car-model' data-label = 'Car Model'>".$cm."</td>
                                                        <td class = 'reservation-start' data-label = 'Start Date'>".$rs."</td>
                                                        <td class = 'reservation-finish' data-label = 'Finish Date'>".$rf."</td>
                                                        <td class = 'reservation-price' data-label = 'Total Price'>".$rtp."</td>";
                                                
                                            $today = date("Y-m-d");
                                            if ($rs >= $today) {
                                                echo "<td data-label = 'Options'>
                                                <a class = 'update-btn'>Update</a><br><br>
                                                <a class = 'delete-btn'>Delete</a>
                                                    </td>";
                                            } 
                                            else {
                                                if ($_SESSION['statu'] == 1) {
                                                    $cu = $_SESSION['username'];
                                                    $sql4 = "SELECT * FROM rate WHERE carID = '$cID' AND start = '$rs'";
                                                $result4 = mysqli_query($conn,$sql4);
                                                if ($result4->num_rows == 0) {
                                                    echo "<td data-label = 'Options'>
                                                    <form method = 'post' id = 'rate-car-form' action = 'MyReservation.php'>
                                                    <input name = 'rate-carid' value = '".$cID."' type = 'hidden' readonly'>
                                                    <input name = 'rate-carstart' value = '".$rs."' type = 'hidden' readonly'>
                                                    <input type = 'submit' name = 'rate-car-btn' form = 'rate-car-form' value = 'Rate Your Experience'>
                                                    </form>
                                                    </td>";
                                                } 
                                                }
                                            }                           
                                            echo "</tr>";
                                        }

                                    }
                                    else {
                                        echo "<h3 style = 'color: white; padding-left: 25px;' id = 'errorTag'>You don't have any reservation</h3>";
                                    }
                                }
                            }
                            else {
                                if ($_SESSION['statu'] == 1) {
                                    $sql = "SELECT c.ID,c.name,c.image,c.model,r.start,r.finish,r.totalPrice FROM cars c,reservation r WHERE c.name = r.carname AND r.username = '$session_username' ORDER BY r.finish DESC";
                                }
                                else {
                                    $sql = "SELECT c.ID,u.username,c.name,c.image,c.model,r.start,r.finish,r.totalPrice FROM cars c, reservation r, users u WHERE c.name = r.carname AND r.username = u.username ORDER BY r.finish DESC";
                                }                                
                                $result = mysqli_query($conn,$sql);
                                if ($result->num_rows > 0) {
                                    echo "<tr>";
                                    if ($_SESSION['statu'] == 0) {
                                        echo "<th scope='col'>Username</th>";
                                    }
                                    echo "<th scope='col'>Car Name</th>
                                        <th scope='col'>Car Image</th>
                                        <th scope='col'>Car Model</th>
                                        <th scope='col'>Start Date</th>
                                        <th scope='col'>Finish Date</th>
                                        <th scope='col'>Total Price</th>
                                        <th scope='col'>Options</th>
                                    </tr>";
    
                                    while ($row = $result->fetch_assoc()) {
                                        if ($_SESSION['statu'] == 0) {
                                            $cu = $row['username'];
                                        }
                                        $cn = $row['name'];
                                        $cID = $row['ID'];

                                        $ci = $row['image'];
                                        $cm = $row['model'];
                                        $rs = $row['start'];
                                        $rf = $row['finish'];
                                        $rtp = $row['totalPrice'];
                                        
    
                                    
                                        echo "<tr>";
                                            if ($_SESSION['statu'] == 0) {
                                                echo "<td class = 'car-username' data-label = 'Username'>".$cu."</td>";
                                            }
                                            echo "<td class = 'car-name' data-label = 'Car Name'>".$cn."</td>
                                                        <td class = 'car-img' data-label = 'Car Image'><img src = 'uploads/".$ci."'></td>
                                                        <td class = 'car-model' data-label = 'Car Model'>".$cm."</td>
                                                        <td class = 'reservation-start' data-label = 'Start Date'>".$rs."</td>
                                                        <td class = 'reservation-finish' data-label = 'Finish Date'>".$rf."</td>
                                                        <td class = 'reservation-price' data-label = 'Total Price'>".$rtp."</td>";
                                                
                                                        $today = date("Y-m-d");
                                                        if ($rs >= $today) {
                                                            echo "<td data-label = 'Options'>
                                                            <a class = 'update-btn'>Update</a><br><br>
                                                            <a class = 'delete-btn'>Delete</a>
                                                                </td>";
                                                        } 
                                                        else {
                                                            if ($_SESSION['statu'] == 1) {
                                                                $cu = $_SESSION['username'];
                                                                $sql4 = "SELECT * FROM rate WHERE carID = '$cID' AND start = '$rs'";
                                                            $result4 = mysqli_query($conn,$sql4);
                                                            if ($result4->num_rows == 0) {
                                                                echo "<td data-label = 'Options'>
                                                                <form method = 'post' id = 'rate-car-form' action = 'MyReservation.php'>
                                                                <input name = 'rate-carid' value = '".$cID."' type = 'hidden' readonly'>
                                                                <input name = 'rate-carstart' value = '".$rs."' type = 'hidden' readonly'>
                                                                <input type = 'submit' name = 'rate-car-btn' form = 'rate-car-form' value = 'Rate Your Experience'>
                                                                </form>
                                                                </td>";
                                                            } 
                                                            }
                                                        }                           
                                                        echo "</tr>";
                                    }
    
                                }
                                else {
                                    echo "<h3 style = 'color: white; padding-left: 25px;' id = 'errorTag'>You don't have any reservation</h3>";
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