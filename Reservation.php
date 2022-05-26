<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Reservation</title>
    <link rel="stylesheet" href="css/Navbar.css">
    <link rel="stylesheet" href="css/Reservation.css">
    <link rel="stylesheet" href="css/Table.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="js/Customer.js"></script>
    <script src="js/Navbar.js"></script>
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <script>
        
        $(document).ready(function() {
            let car_names = document.getElementsByClassName('car-name');
            let car_model = document.getElementsByClassName('car-model');
            let car_price = document.getElementsByClassName('car-price');
            let car_seat = document.getElementsByClassName('car-numberSeat');
            let car_image = document.getElementsByClassName('car-image');
            
            let rent_btn = document.getElementsByClassName('car-rent-btn');
            let rate_btn = document.getElementsByClassName('rate-btn');
            let close_btn = document.getElementsByClassName('temp_close');
            
            for (var i=0; i < rent_btn.length; i++) {
                let name = car_names[i].value;
                let model = car_model[i].value;
                let price = car_price[i].value;
                let image = car_image[i].value;
                let seat = car_seat[i].value;

                rent_btn[i].onclick = function () {
                    openPopup(name,model,price,seat,image)
                };
                
                let id = rate_btn[i].id;
                console.log(id);
                rate_btn[i].onclick = function () {
                    console.log(id);
                    openTempRate(id)
                };
                close_btn[i].onclick = function () {
                    closeTempRate()
                }

            }

            let disable_rate = document.getElementsByClassName('disable_rate');
            console.log(disable_rate.length);
            for (let i = 0; i < disable_rate.length; i++) {
                disable_rate[i].disabled = true;
            }
            let disable_rate2 = document.getElementsByClassName('disable_rate2');
            for (let i = 0; i < disable_rate2.length; i++) {
                disable_rate2[i].disabled = true;
            }


            });
            

      </script>
      <style>
           /*RATE */
            .rating_test {
            display: flex;
            flex-direction: row-reverse;
            justify-content: center;
            }
            
            .rating_test > input{
            display:none;
            }
            
            .rating_test > label {
            position: relative;
            width: 50px;
            font-size: 20px;
            color: #FFD700;
            cursor: pointer;
            right: 25px;
            }
            
            .rating_test > label::before{
            content: "\2605";
            position: absolute;
            opacity: 0;
            }
 
            .rating_test > input:checked ~ label:before{
            opacity:1;
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
    $flag = 0;
    if ($conn->connect_error) {
        die("error: " . $conn->connect_error);
    }
    if (!isset($_SESSION['statu'])) {
        header("Location: /web/Car Rental Software/Login.php");
    }
    else {
        if ($_SESSION['statu'] == 0) {
        header("Location: /web/Car Rental Software/Login.php");

        }
    }
?>

    <div class="box">
        <?php include "Navbar.php";?>
        <div class="content">
            
                <div id="login">
                    <!-- Popup Section -->
                    <div class="form-popup div2" id="myForm">
                        <form id='confirm_form' enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="form-container">
                          <input id = 'popup-car-name' type="hidden" readonly>
                          <input id = 'popup-car-model' type="hidden" readonly>
                          <input id = 'popup-car-price' type="hidden" readonly>
                          <input id = 'popup-car-seat' type="hidden" readonly>
                          <input id = 'popup-car-image' type="hidden" readonly>
                          <h3>Car Info</h3><br>
                          <label style="text-align: center;" for="image"></label><img id="span-img"><br><br>
                          <label for="name">Car Name:</label><input class="span" name = 'span-name' id="span-name" readonly></input><br><br>
                          <label for="model">Car Model:</label><input class="span" id="span-model" readonly></input><br><br>
                          <label for="price">Car Price:</label><input class="span" id="span-price" readonly></input><br><br>
                          <label for="state">Car Seat Num:</label><input class="span" id="span-seat" readonly></input><br><br>



                          <input type="submit" name = 'confirm_form' class="btn" form="confirm_form" value="Confirm"></input>
                          <a onclick="closeForm()" class="close"></a>
                        </form>
                    </div>
                    <!-- End Popup -->
                    <!-- Comment List Section -->
                    <?php
                        if (isset($_POST['res-search'])) {
                            $sdate = new DateTime($_POST['sdate']);
                            $fdate = new DateTime($_POST['fdate']);
                            $_SESSION['sdate'] = $_POST['sdate'];
                            $_SESSION['fdate'] = $_POST['fdate'];
                            $date1=date("Y-m-d",strtotime($_SESSION['sdate']));
                            $date2=date("Y-m-d",strtotime($_SESSION['fdate']));
                            if ((!empty($_POST['type']) && !empty($_POST['price']) && !empty($_POST['sdate']) && !empty($_POST['fdate']) && checkReservationDate($_POST['sdate'],0) != 1 && checkReservationDate($_POST['fdate'],0) != 1 && $_POST['sdate'] != 0 && $_POST['fdate'] != 0 && $_POST['fdate'] > $_POST['sdate'])) {
                                $types = $_POST['type'];
                                $prices = $_POST['price'];
                                $difference = $sdate->diff($fdate);
                                /*
                                for ($i = 0; $i < count($types);$i++) {
                                    echo $types[$i]."<br>";
                                }
                                for ($i = 0; $i < count($prices);$i++) {
                                    echo $prices[$i]."<br>";
                                }*/
                                
                                $tempTypes = array();
                                if (in_array("small",$types)) {
                                    array_push($tempTypes,2);
                                }
                                if (in_array("mid",$types)) {
                                    array_push($tempTypes,3,4,5);
                                }
                                if (in_array("large",$types)) {
                                    array_push($tempTypes,6,7,8,9,10);
                                }

                                
                                if (in_array("price1",$prices) && in_array("price2",$prices) && in_array("price3",$prices)) {
                                    $sql = "SELECT * FROM cars WHERE numberSeat IN (" . implode(',', $tempTypes) . ") AND state = 'empty' && day > ".$difference->d." AND name NOT IN (SELECT carname FROM reservation WHERE (start > '$date1' AND ('$date2' BETWEEN start AND finish)) OR (('$date1' BETWEEN start AND finish) AND finish < '$date2') OR ('$date1' < start AND '$date2' > finish) OR (('$date1' BETWEEN start AND finish) AND ('$date2' BETWEEN start AND finish)))";
                                }
                                else if (in_array("price1",$prices) && in_array("price2",$prices)) {
                                    $sql = "SELECT * FROM cars WHERE numberSeat IN (" . implode(',', $tempTypes) . ") AND price < 300 AND state = 'empty' && day > ".$difference->d." AND name NOT IN (SELECT carname FROM reservation WHERE (start > '$date1' AND ('$date2' BETWEEN start AND finish)) OR (('$date1' BETWEEN start AND finish) AND finish < '$date2') OR ('$date1' < start AND '$date2' > finish) OR (('$date1' BETWEEN start AND finish) AND ('$date2' BETWEEN start AND finish)))";       

                                }
                                else if (in_array("price1",$prices) && in_array("price3",$prices)) {
                                    $sql = "SELECT * FROM cars WHERE numberSeat IN (" . implode(',', $tempTypes) . ") AND price < 150 AND price > 300 AND state = 'empty' && day > ".$difference->d." AND name NOT IN (SELECT carname FROM reservation WHERE (start > '$date1' AND ('$date2' BETWEEN start AND finish)) OR (('$date1' BETWEEN start AND finish) AND finish < '$date2') OR ('$date1' < start AND '$date2' > finish) OR (('$date1' BETWEEN start AND finish) AND ('$date2' BETWEEN start AND finish)))";

                                }
                                else if (in_array("price2",$prices) && in_array("price3",$prices)) {
                                    $sql = "SELECT * FROM cars WHERE numberSeat IN (" . implode(',', $tempTypes) . ") AND price > 300 AND state = 'empty' && day > ".$difference->d." AND name NOT IN (SELECT carname FROM reservation WHERE (start > '$date1' AND ('$date2' BETWEEN start AND finish)) OR (('$date1' BETWEEN start AND finish) AND finish < '$date2') OR ('$date1' < start AND '$date2' > finish) OR (('$date1' BETWEEN start AND finish) AND ('$date2' BETWEEN start AND finish)))";

                                }
                                else if (in_array("price1",$prices)) {
                                    $sql = "SELECT * FROM cars WHERE numberSeat IN (" . implode(',', $tempTypes) . ") AND price < 150 AND state = 'empty' && day > ".$difference->d." AND name NOT IN (SELECT carname FROM reservation WHERE (start > '$date1' AND ('$date2' BETWEEN start AND finish)) OR (('$date1' BETWEEN start AND finish) AND finish < '$date2') OR ('$date1' < start AND '$date2' > finish) OR (('$date1' BETWEEN start AND finish) AND ('$date2' BETWEEN start AND finish)))";

                                }
                                else if (in_array("price2",$prices)) {
                                    $sql = "SELECT * FROM cars WHERE numberSeat IN (" . implode(',', $tempTypes) . ") AND price BETWEEN 150 AND 300 AND state = 'empty' && day > ".$difference->d." AND name NOT IN (SELECT carname FROM reservation WHERE (start > '$date1' AND ('$date2' BETWEEN start AND finish)) OR (('$date1' BETWEEN start AND finish) AND finish < '$date2') OR ('$date1' < start AND '$date2' > finish) OR (('$date1' BETWEEN start AND finish) AND ('$date2' BETWEEN start AND finish)))";

                                }
                                else if (in_array("price3",$prices)) {
                                    $sql = "SELECT * FROM cars WHERE numberSeat IN (" . implode(',', $tempTypes) . ") AND price > 300 AND state = 'empty' && day > ".$difference->d." AND name NOT IN (SELECT carname FROM reservation WHERE (start > '$date1' AND ('$date2' BETWEEN start AND finish)) OR (('$date1' BETWEEN start AND finish) AND finish < '$date2') OR ('$date1' < start AND '$date2' > finish) OR (('$date1' BETWEEN start AND finish) AND ('$date2' BETWEEN start AND finish)))";

                                }

                                $result = mysqli_query($conn,$sql);
                                if ($result->num_rows > 0) {    
                                    while ($row=$result->fetch_assoc()) {

                                        $carID = $row['ID'];
                                        $divID = $row['ID']."_car";
                                        echo "<div id='".$divID."' class='form-popup div1' style = 'overflow-y:hidden; margin-top:40px;background-color: white; height: 500px;  display: none;'>
                                        <h3>Comments</h3>";
                                        
                                        $getComment = "SELECT * FROM rate WHERE carID = '$carID'";
                                        $result_getComment = mysqli_query($conn,$getComment);

                                        if ($result_getComment->num_rows > 0) {
                                            while ($row_getComment = $result_getComment->fetch_assoc()) {
                                                // get the all comments that has carID = '$carID'
                                                // remove span tag and add div 'rating_test' with rating
                                                echo "<div style = 'background-color:#ddd; border: 1px solid grey;'><label for = 'username'>Username: ".$row_getComment['username']."</label>";
                                                $five = "";
                                                $four = "";
                                                $three = "";
                                                $two = "";
                                                $one = "";

                                                if ($row_getComment['stars'] == 5.0) {
                                                    $five = "checked";
                                                } if ($row_getComment['stars'] >= 4) {
                                                    $four = "checked";
                                                } if ($row_getComment['stars'] >= 3) {
                                                    $three = "checked";
                                                } if ($row_getComment['stars'] >= 2) {
                                                    $two = "checked";
                                                } if ($row_getComment['stars'] >= 1) {
                                                    $one = "checked";
                                                }
                                                //<span style = 'float: right;'>".$row_getComment['stars']."</span>
                                                echo "<br><div class = 'rating_test rating_temp' style = 'width:80%'>
                                                <input class = 'disable_rate2' type = 'radio' $five><label for = '5'>☆</label>
                                                <input class = 'disable_rate2' type = 'radio' $four><label for = '4'>☆</label>
                                                <input class = 'disable_rate2' type = 'radio' $three><label for = '3'>☆</label>
                                                <input class = 'disable_rate2' type = 'radio' $two><label for = '2'>☆</label>
                                                <input class = 'disable_rate2' type = 'radio' $one><label for = '1'>☆</label>
                                                </div><hr>
                                                <p style = 'color: black'>".$row_getComment['comment']."</p><br></div>";
                                            }
                                        }
                                        else {
                                            echo "<h4 id = 'errorTag' style = 'color: white;'>No rate found</h4>";
                                        }
                                        echo "<a id = '".$carID."' class='close temp_close'></a>";
                                        echo "</div>";
                                        
                                    }
                                }               
                            }
                        }
                        ?>
                        <!-- END Comment List Section -->
                    <div id="search1">
                        
                        <h3>Add New Reservation</h3>
                        <form id = 'search-reservation' action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                            <div class="item-group">
                                <label for="type">Type: </label><span style=" color: red;" id="type-check">* <?php 
                                    if (isset($_POST['res-search'])) {if (empty($_POST['type'])) {echo "Required Type";} else{$types = $_POST['type'];echo "";}}
                                ?></span><br>
                                <input class="check-box" type="checkbox" id="small" name="type[]" value="small" <?php
                                    if (isset($_POST['res-search'])) {if (!empty($_POST['type'])) {foreach($types as $i) {if ($i == "small") {echo "checked";}}}}
                                ?>>
                                <label class="check-label" for="small">Small-size (2 people)</label><br>
                                <input class="check-box" type="checkbox" id="mid" name="type[]" value="mid" <?php
                                    if (isset($_POST['res-search'])) {if (!empty($_POST['type'])) {foreach($types as $i) {if ($i == "mid") {echo "checked";}}}}

                                ?>>
                                <label class="check-label" for="mid">Mid-size (3-5 people)</label><br>
                                <input class="check-box" type="checkbox" id="large" name="type[]" value="large" <?php
                                    if (isset($_POST['res-search'])) {if (!empty($_POST['type'])) {foreach($types as $i) {if ($i == "large") {echo "checked";}}}}                               
                                ?>>
                                <label class="check-label" for="large">Large-size (6+ people)</label><br><br><br>    
                            </div>
  
                            <div class="item-group">
                                <label for="price">Price: </label><span style="color: red;" id="price-check">* <?php
                                    if (isset($_POST['res-search'])) {if (empty($_POST['price'])) {echo "Required Price";} else{$prices = $_POST['price'];echo "";}}
                                ?></span><br>
                                <input class="check-box" type="checkbox" id="price1" name="price[]" value="price1" <?php
                                    if (isset($_POST['res-search'])) {if (!empty($_POST['price'])) {foreach($prices as $i) {if ($i == "price1") {echo "checked";}}}}
                                ?>>
                                <label class="check-label" for="price1">0 - 150$</label><br>
                                <input class="check-box" type="checkbox" id="price2" name="price[]" value="price2" <?php
                                    if (isset($_POST['res-search'])) {if (!empty($_POST['price'])) {foreach($prices as $i) {if ($i == "price2") {echo "checked";}}}}
                                ?>>
                                <label class="check-label" for="price2">150$ - 300$</label><br>
                                <input class="check-box" type="checkbox" id="price3" name="price[]" value="price3" <?php
                                    if (isset($_POST['res-search'])) {if (!empty($_POST['price'])) {foreach($prices as $i) {if ($i == "price3") {echo "checked";}}}}                                   
                                ?>>
                                <label class="check-label" for="price3">300$+</label><br><br><br>
                            </div>
                            
        
                            <div class="item-group">
                                <label class="check-label" for="sdate">Start Date: </label><span style="color: red;" id="date-check">* <?php
                                    if (isset($_POST['res-search'])) {
                                        if (empty($_POST['sdate'])) {
                                            echo "Required Date";
                                        } 
                                        else{
                                            $sdate = $_POST['sdate'];
                                            if (checkReservationDate($sdate,0) == 1) {
                                                checkReservationDate($sdate,1);
                                            }
                                            else {
                                                $ss = new DateTime($_POST['sdate']);
                                                $ff = new DateTime($_POST['fdate']);
                                                $difference = $ss->diff($ff);
                                                if ($difference->m > 0) {
                                                    echo "Less than 30 day";
                                                    $flag = 1;
                                                }
                                                else {
                                                    if ($_POST['sdate'] < $_POST['fdate']) {
                                                        echo "";
                                                    }
                                                    else {
                                                        echo "Invalid day entered";
                                                    }
                                                }
                                            }
                                        }
                                    }
                                ?></span><br>
                                <input type="date" name="sdate" id="sdate" value = "<?php
                                    if (isset($_POST['res-search'])) {
                                        if (!empty($_POST['sdate'])) { 
                                            echo $_POST['sdate'];
                                        }
                                    }                                   
                                ?>"><br><br>
                                <label class="check-label" for="fdate">Finish Date: </label><span style="color: red;" id="date-check">* <?php
                                    if (isset($_POST['res-search'])) {
                                        if (empty($_POST['fdate'])) {
                                            echo "Required Date";
                                        } 
                                        else{
                                            $fdate = $_POST['fdate'];
                                            if (checkReservationDate($fdate,0) == 1) {
                                                checkReservationDate($fdate,1);
                                            }
                                            else {
                                                $ss = new DateTime($_POST['sdate']);
                                                $ff = new DateTime($_POST['fdate']);
                                                $difference = $ss->diff($ff);
                                                if ($difference->m > 0) {
                                                    echo "Less than 30 day";
                                                    $flag = 1;
                                                }
                                                else {
                                                    if ($_POST['sdate'] < $_POST['fdate']) {
                                                        echo "";
                                                    }
                                                    else {
                                                        echo "Invalid day entered";
                                                    }
                                                }
                                                
                                                
                                            }
                                        }
                                    }
                                ?></span><br>
                                <input type="date" name="fdate" id="fdate" value = "<?php
                                    if (isset($_POST['res-search'])) {if (!empty($_POST['fdate'])) {echo $_POST['fdate'];}}                                   
                                ?>">
                                <br><br>
                            </div>
                            <br>
                            <input name = 'res-search' form="search-reservation" type="submit" id="search-btn" value="Search">                     
                        </form>                       
                    </div>
   

                    <div id="search2">
                        

                        <div id="car-list-div">

                            <h3>Choose a Car From List</h3>
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

                                        if (isset($_POST['res-search'])) {
                                            $sdate = new DateTime($_POST['sdate']);
                                            $fdate = new DateTime($_POST['fdate']);
                                            $_SESSION['sdate'] = $_POST['sdate'];
                                            $_SESSION['fdate'] = $_POST['fdate'];
                                            $date1=date("Y-m-d",strtotime($_SESSION['sdate']));
                                            $date2=date("Y-m-d",strtotime($_SESSION['fdate']));
                                            if ((!empty($_POST['type']) && $flag != 1 && !empty($_POST['price']) && !empty($_POST['sdate']) && !empty($_POST['fdate']) && checkReservationDate($_POST['sdate'],0) != 1 && checkReservationDate($_POST['fdate'],0) != 1 && $_POST['sdate'] != 0 && $_POST['fdate'] != 0 && $_POST['fdate'] > $_POST['sdate'])) {
                                                $types = $_POST['type'];
                                                $prices = $_POST['price'];
                                                $difference = $sdate->diff($fdate);
                                                /*
                                                for ($i = 0; $i < count($types);$i++) {
                                                    echo $types[$i]."<br>";
                                                }
                                                for ($i = 0; $i < count($prices);$i++) {
                                                    echo $prices[$i]."<br>";
                                                }*/
                                                
                                                $tempTypes = array();
                                                if (in_array("small",$types)) {
                                                    array_push($tempTypes,2);
                                                }
                                                if (in_array("mid",$types)) {
                                                    array_push($tempTypes,3,4,5);
                                                }
                                                if (in_array("large",$types)) {
                                                    array_push($tempTypes,6,7,8,9,10);
                                                }

                                                
                                                if (in_array("price1",$prices) && in_array("price2",$prices) && in_array("price3",$prices)) {
                                                    $sql = "SELECT * FROM cars WHERE numberSeat IN (" . implode(',', $tempTypes) . ") AND state = 'empty' && day > ".$difference->d." AND name NOT IN (SELECT carname FROM reservation WHERE (start > '$date1' AND ('$date2' BETWEEN start AND finish)) OR (('$date1' BETWEEN start AND finish) AND finish < '$date2') OR ('$date1' < start AND '$date2' > finish) OR (('$date1' BETWEEN start AND finish) AND ('$date2' BETWEEN start AND finish)))";
                                                }
                                                else if (in_array("price1",$prices) && in_array("price2",$prices)) {
                                                    $sql = "SELECT * FROM cars WHERE numberSeat IN (" . implode(',', $tempTypes) . ") AND price < 300 AND state = 'empty' && day > ".$difference->d." AND name NOT IN (SELECT carname FROM reservation WHERE (start > '$date1' AND ('$date2' BETWEEN start AND finish)) OR (('$date1' BETWEEN start AND finish) AND finish < '$date2') OR ('$date1' < start AND '$date2' > finish) OR (('$date1' BETWEEN start AND finish) AND ('$date2' BETWEEN start AND finish)))";       

                                                }
                                                else if (in_array("price1",$prices) && in_array("price3",$prices)) {
                                                    $sql = "SELECT * FROM cars WHERE numberSeat IN (" . implode(',', $tempTypes) . ") AND price < 150 AND price > 300 AND state = 'empty' && day > ".$difference->d." AND name NOT IN (SELECT carname FROM reservation WHERE (start > '$date1' AND ('$date2' BETWEEN start AND finish)) OR (('$date1' BETWEEN start AND finish) AND finish < '$date2') OR ('$date1' < start AND '$date2' > finish) OR (('$date1' BETWEEN start AND finish) AND ('$date2' BETWEEN start AND finish)))";

                                                }
                                                else if (in_array("price2",$prices) && in_array("price3",$prices)) {
                                                    $sql = "SELECT * FROM cars WHERE numberSeat IN (" . implode(',', $tempTypes) . ") AND price > 300 AND state = 'empty' && day > ".$difference->d." AND name NOT IN (SELECT carname FROM reservation WHERE (start > '$date1' AND ('$date2' BETWEEN start AND finish)) OR (('$date1' BETWEEN start AND finish) AND finish < '$date2') OR ('$date1' < start AND '$date2' > finish) OR (('$date1' BETWEEN start AND finish) AND ('$date2' BETWEEN start AND finish)))";

                                                }
                                                else if (in_array("price1",$prices)) {
                                                    $sql = "SELECT * FROM cars WHERE numberSeat IN (" . implode(',', $tempTypes) . ") AND price < 150 AND state = 'empty' && day > ".$difference->d." AND name NOT IN (SELECT carname FROM reservation WHERE (start > '$date1' AND ('$date2' BETWEEN start AND finish)) OR (('$date1' BETWEEN start AND finish) AND finish < '$date2') OR ('$date1' < start AND '$date2' > finish) OR (('$date1' BETWEEN start AND finish) AND ('$date2' BETWEEN start AND finish)))";

                                                }
                                                else if (in_array("price2",$prices)) {
                                                    $sql = "SELECT * FROM cars WHERE numberSeat IN (" . implode(',', $tempTypes) . ") AND price BETWEEN 150 AND 300 AND state = 'empty' && day > ".$difference->d." AND name NOT IN (SELECT carname FROM reservation WHERE (start > '$date1' AND ('$date2' BETWEEN start AND finish)) OR (('$date1' BETWEEN start AND finish) AND finish < '$date2') OR ('$date1' < start AND '$date2' > finish) OR (('$date1' BETWEEN start AND finish) AND ('$date2' BETWEEN start AND finish)))";

                                                }
                                                else if (in_array("price3",$prices)) {
                                                    $sql = "SELECT * FROM cars WHERE numberSeat IN (" . implode(',', $tempTypes) . ") AND price > 300 AND state = 'empty' && day > ".$difference->d." AND name NOT IN (SELECT carname FROM reservation WHERE (start > '$date1' AND ('$date2' BETWEEN start AND finish)) OR (('$date1' BETWEEN start AND finish) AND finish < '$date2') OR ('$date1' < start AND '$date2' > finish) OR (('$date1' BETWEEN start AND finish) AND ('$date2' BETWEEN start AND finish)))";

                                                }

                                                $result = mysqli_query($conn,$sql);
                                                if ($result->num_rows > 0) {
                                                    echo "<div id='scrollable' class='scrollable'>
                                                            <table id='carTable'>";    
                                                    while ($row=$result->fetch_assoc()) {
                                                        echo "<div class='car-style' id='cars'>
                                                                <form id = 'rate-form' action = 'Reservation.php' method = 'post' >
                                                                    <input class = 'car-name' id = 'list-car-name' value = '".$row['name']."' type='hidden' readonly>
                                                                    <input class = 'car-model' id = 'list-car-model' value = '".$row['model']."' type='hidden' readonly>
                                                                    <input class = 'car-price' id = 'list-car-price' value = '".$row['price']."' type='hidden' readonly>
                                                                    <input class = 'car-image' id = 'list-car-image' value = '".$row['image']."' type='hidden' readonly>
                                                                    <input class = 'car-numberSeat' id = 'list-car-numberSeat' value = '".$row['numberSeat']."' type='hidden' readonly>
                                                                    <div style = 'float:right; width:50px;' id = '".$row['ID']."' class = 'rate-btn rating_test'>";
                                                                    // <input style = 'float:right;' type='button' id = '".$row['ID']."' class = 'rate-btn' name='rate-btn' value='Point: ";
  
                                                                    $sql_rate = "SELECT AVG(stars) AS stars FROM rate WHERE carID = '".$row['ID']."'";
                                                                    $result_rate = mysqli_query($conn,$sql_rate);
                                                                    if ($result_rate->num_rows > 0) {
                                                                        $row_rate = $result_rate->fetch_assoc();
                                                                        //echo sprintf("%0.1f",$row_rate['stars']);
                                                                        $five = "";
                                                                        $four = "";
                                                                        $three = "";
                                                                        $two = "";
                                                                        $one = "";

                                                                        if ($row_rate['stars'] == 5.0) {
                                                                            $five = "checked";
                                                                        } else if ($row_rate['stars'] >= 4) {
                                                                            $four = "checked";
                                                                        }else if ($row_rate['stars'] >= 3) {
                                                                            $three = "checked";
                                                                        }else if ($row_rate['stars'] >= 2) {
                                                                            $two = "checked";
                                                                        }else if ($row_rate['stars'] >= 1) {
                                                                            $one = "checked";
                                                                        }
                                                                        echo "<input class = 'disable_rate' type = 'radio' name = 'rating' value = '5' id = '5' $five><label for = '5'>☆</label>
                                                                        <input class = 'disable_rate' type = 'radio' name = 'rating' value = '4' id = '4' $four><label for = '4'>☆</label>
                                                                        <input class = 'disable_rate' type = 'radio' name = 'rating' value = '3' id = '3' $three><label for = '3'>☆</label>
                                                                        <input class = 'disable_rate' type = 'radio' name = 'rating' value = '2' id = '2' $two><label for = '2'>☆</label>
                                                                        <input class = 'disable_rate' type = 'radio' name = 'rating' value = '1' id = '1' $one><label for = '1'>☆</label></div>";
                                                                    }
                                                                    else {
                                                                        echo "0";
                                                                    }                                                                    echo "
                                                                    <h3 class='car-names' style='margin-top: 5px;'>".$row['name']."</h3>
                                                                    <img src='img/".$row['image']."'>
                                                                    <p>Lorem ipsum dolor sit amet consectetur.</p>
                                                                    <p>Price: ".$row['price']."$/day</p>
                                                                    <input type = 'button' value = 'Rent' id='rent-btn' class='car-style car-rent-btn' onclick = 'openForm()'></input>
                                                                    
                                                                </form>
                                                            </div>";
                                                    }
                                                    echo "</table>
                                                        </div>";
                                                }
                                                else {
                                                    echo "<h3 style='width: 300px; padding-left: 10px;border-radius: 6px; color:white;' id='errorTag'>* There is no available car !!!</h3>";
                                                }
                                                
                                            }
                                        }
                                        if (isset($_POST['confirm_form'])) {
                                            $car_name = $_POST['span-name'];
                                            $username = $_SESSION['username'];
                                            $sdate = new DateTime($_SESSION['sdate']);
                                            $fdate = new DateTime($_SESSION['fdate']);
                                            $date1=date("Y-m-d",strtotime($_SESSION['sdate']));
                                            $date2=date("Y-m-d",strtotime($_SESSION['fdate']));
                                            $difference = $sdate->diff($fdate);
                                            
                                            $sql = "SELECT price FROM cars WHERE name = '$car_name'";
                                            $result = mysqli_query($conn,$sql);
                                            $row = $result->fetch_assoc();
                                            $price = $row['price'];

                                            $total_price = $price * ($difference->d + 1);
                                            
                                            $sql = "INSERT INTO reservation (carname,username,start,finish,totalPrice) VALUES ('$car_name','$username','$date1','$date2','$total_price')"; 
                                            $result = mysqli_query($conn,$sql);

                                        }
                                        $conn->close();
                                    ?>
                        </div>
                    </div>
                    </div>
                </div>
        </div>
    </div>
</body>
</html>