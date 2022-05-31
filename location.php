<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Location</title>
    <link rel="stylesheet" href="css/Navbar.css">
    <link rel="stylesheet" href="css/Table.css">
    <link rel="stylesheet" href="css/Manager.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="../Car Rental Software/js/Manager.js"></script>
    <script src="js/Navbar.js"></script>
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
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
        if ($_SESSION['statu'] == 1) {
        header("Location: /web/Car Rental Software/Login.php");

        }
    }
?>
</body>
<div class="box">
        <?php include "Manager_Navbar.php";?>
        <div class="content">
            
            <div id="login">
                <div id="car-list-div">
                    <div style="text-align: center; padding: 15px;">
                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" id="search-form" method="post">
                            <input style="margin-right: 20px; font-size: 18px;" type="text" name="location" id="location" required>
                            <input style="width: 135px;" name="search" form = 'search-form' type = 'submit' id="search-past-reservation-btn" value="Search">
                        </form>
                    </div>
                </div>
            </div>
            <div style="<?php if (isset($_POST['search'])) {
                echo "display: block;";
            }else {
                echo "display: none;";
            } ?>">
                <table>
                    <tr>
                        <th>Car Name</th>
                        <th>Username</th>
                        <th>Start</th>
                        <th>Finish</th>
                    </tr>
                    
                    <?php
                        if (isset($_POST['search'])) {
                            $location = $_POST['location'];

                            $sql = "SELECT c.name,r.username,r.start,r.finish FROM cars c, reservation r WHERE c.location = '$location' AND c.name = r.carname";
                            $result = mysqli_query($conn,$sql);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr><td>".$row['name']."</td>
                                    <td>".$row['username']."</td>
                                    <td>".$row['start']."</td>
                                    <td>".$row['finish']."</td></tr>
                                    ";
                                }
                            }
                            else {
                                echo "<h3 id = 'errorTag'>No Car Found</h3>";
                            }
                            

                        }
                    ?>
                </table>
            </div>
            
        </div>
</html>