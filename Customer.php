<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer</title>
    <link rel="stylesheet" href="css/Navbar.css">
    <link rel="stylesheet" href="css/Reservation.css">
    <link rel="stylesheet" href="css/Customer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="js/Customer.js"></script>
    <script src="js/Navbar.js"></script>
</head>
<body>
    
    <div class="box">
        <?php include "Navbar.php"; 
        session_start();
        if (!isset($_SESSION['statu'])) {
            header("Location: /web/Car Rental Software/Login.php");
        }
        else {
            if ($_SESSION['statu'] == 0) {
            header("Location: /web/Car Rental Software/Login.php");

            }
        }
        ?>
    </div>
    <div class="content">
        <div id="center">
            <div id="login">
                <h3 style="text-align: center; padding-top: 10px; color: white;">Lorem ipsum dolor sit amet consectetur.</h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Numquam ipsum deserunt facere ipsam? Itaque praesentium obcaecati beatae ex nesciunt optio, tenetur alias consectetur, odio porro sapiente, doloribus id doloremque dolorem assumenda ipsa minima autem blanditiis eos dolore ipsum quidem numquam aliquid! Rerum architecto enim, maxime eos recusandae totam exercitationem impedit.</p>
                <br><br>
                <h3 style = "color: #8486A0;">Lets take <a style="color: white; text-decoration: none;" href="Reservation.php">a Reservation.</a></h3>
            </div>
        </div>
    </div>
    

</body>
</html>