<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager Overview</title>
    <link rel="stylesheet" href="css/Navbar.css">
    <link rel="stylesheet" href="css/Table.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/Reservation.css">
    <link rel="stylesheet" href="css/Manager.css">
    <script src="js/Navbar.js"></script>
    <script src="js/Manager.js"></script>


</head>
<body>
    <div class="box">
        <?php include "Manager_Navbar.php"; 
        session_start();
        if (!isset($_SESSION['statu'])) {
            header("Location: /web/Car Rental Software/Login.php");
        }
        else {
            if ($_SESSION['statu'] == 1) {
            header("Location: /web/Car Rental Software/Login.php");

            }
        }?>
        <div class="content">
                <div id="login">                        
                        <h3>Revenue</h3>
                        <div style="text-align: center; padding: 15px;">
                            <input style="width: 150px; font-size: 18px;" type="text" name="text" id="text">
                            <a id="search-past-reservation-btn">Search</a>
                        </div>
                        <div id="scrollable">
                            <table>
                                <tr id="header-revenue">
                                    <th scope="col">Car Name</th>
                                    <th scope="col">Image</th>
                                    <th scope="col">Revenue</th>
                                </tr>
                                <tr>
                                    <td data-label = "Car ID">CR1</td>
                                    <td data-label="Image"><img src='img/sedan.png' alt='jeep'></td>
                                    <td data-label="Revenue">800$</td>
                                    
                                </tr>
                                <tr>
                                    <td scope = "row" data-label = "Car ID">CR2</td>
                                    <td data-label="Image"><img src='img/sport-car.png' alt='jeep'></td>
                                    <td data-label="Revenue">1100$</td>
                                    
                                </tr>
                                <tr>
                                    <td scope = "row" data-label = "Car ID">CR3</td>
                                    <td data-label="Image"><img src='img/jeep.png' alt='jeep'></td>
                                    <td data-label="Revenue">650$</td>
                                    
                                </tr>
                                <tr>
                                    <td scope = "row" data-label = "Car ID">CR3</td>
                                    <td data-label="Image"><img src='img/jeep.png' alt='jeep'></td>
                                    <td data-label="Revenue">650$</td>
                                    
                                </tr>
                                <tr>
                                    <td scope = "row" data-label = "Car ID">CR3</td>
                                    <td data-label="Image"><img src='img/jeep.png' alt='jeep'></td>
                                    <td data-label="Revenue">650$</td>
                                    
                                </tr>
                            </table>
                        </div>
                        
                    </div>
        </div>
    </div>
</body>
</html>