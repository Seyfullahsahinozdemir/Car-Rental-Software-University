<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Help</title>
    <link rel="stylesheet" href="css/Navbar.css">
    <link rel="stylesheet" href="css/Table.css">
    <link rel="stylesheet" href="css/Reservation.css">
    <script src="js/Customer.js"></script>
    <script src="js/Navbar.js"></script>
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script>
        /*
        $(document).ready(function() {
            let update_btn = document.getElementsByClassName('open_message');
            
            for (var i=0; i < update_btn.length; i++) {

                update_btn[i].onclick = function () {
                    document.getElementById("replyForm").style.display = "block";
                    document.getElementById("updateForm").style.display = "none";
                };
            }
            });
            */

      </script>
</head>
<body>
<?php
    session_start();
    $serverName = 'localhost';
    $username = 'root';
    $password = '';
    $db = 'car_rental';
    $conn = new mysqli($serverName, $username, $password, $db);
    $username = $_SESSION['username'];
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
                <div class="search1">
                <h3 style="left: 10%; position: absolute;">Your Messages</h3>
                <div class="message-list">
                    
                    <table>
                        <tr>
                            <th style="width: 60%;">Title</th>
                            <th>Date</th>
                            <th style="width: 15%"></th>
                        </tr>
                        <?php
                        if ($_SESSION['statu'] == 1) {
                            //$sql = "SELECT m.title,m.groupID,MAX(date) AS date FROM message m WHERE m.groupID IN (SELECT m.groupID FROM message m WHERE m.customerUsername = '$username') GROUP BY groupID;";
                            $sql = "SELECT mg.title,m.groupID,MAX(date) AS date FROM message m, message_group mg WHERE m.groupID IN (SELECT m.groupID FROM message m WHERE m.customerUsername = '$username' OR m.receiver = '$username') AND m.groupID = mg.groupID GROUP BY groupID;";
                       
                        }
                        else {
                            //$sql = "SELECT m.title,m.groupID,MAX(date) AS date FROM message m GROUP BY groupID;";
                            $sql = "SELECT mg.title,m.groupID,MAX(date) AS date FROM message m, message_group mg WHERE m.groupID = mg.groupID GROUP BY groupID;";

                        }
                            $result = mysqli_query($conn,$sql);
                            $counter = 0;
                            while ($row = $result->fetch_assoc()) {
                                $g = $row['groupID'];
                                $str = "Help.php";
                                $new_sql = "SELECT messageID,statu,receiver FROM message WHERE groupID = '".$row['groupID']."' AND date = '".$row['date']."'";
                                $new_result = mysqli_query($conn,$new_sql);
                                $new_row = $new_result->fetch_assoc();
                                if ($new_row['statu'] == 0) {
                                    if ($new_row['receiver'] == $_SESSION['username']) {
                                        $style_str = "#bdbdeb";
                                    }
                                    else {
                                        $style_str = "#f8f8f8";
                                    }
                                }
                                else {
                                    $style_str = "#f8f8f8";
                                }
                                echo "<tr class = 'reply_row' style = 'background-color: $style_str'>
                                    <td class = 'reply_title'>".$row['title']."</td>
                                    <td class = 'reply_date'>".$row['date']."</td> 
                                    <td class = 'options'>
                                    <form id=".$counter." action = '".$str."' method = 'post'>
                                    <input name = 'group' type = 'hidden' value = '".$g."'>
                                    <input name = 'new_message' type = 'hidden' value = '".$new_row['messageID']."'>
                                    <input class = 'open_message' type = 'submit' value = 'Open' name = '".$counter."' form = '".$counter."'>
                                    </form>
                                    </td>
                                    ";
                                echo "</tr>";
                                $counter++;
                            }                        
                        ?>
                    </table>
                </div>
                </div>
            
                <div id = 'search2'>
                <div class="form-popup" id="updateForm" style="overflow-y:hidden; margin-top:40px; height: 500px; left:45%;right: 15%; <?php
                    if ($_SESSION['statu'] == 0) {
                        echo "display: none";
                    }
                    else {
                        echo "display: block";
                    }
                ?>">
                      <form id='message_form' action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="form-container">
                      <h3>Send Message to Office</h3>

                      <input id="messageID" name = 'messageID' type="hidden" readonly>
                      <input id="groupID" name = 'groupID' type="hidden" readonly>

                      <label for="topic"><b>Title:</b></label><br>
                      <input id="topic" type="text" name="topic" placeholder="Enter Title" maxlength="50" required><br>

                      <label for="options"><b>Options:</b></label>
                      <input list = 'options' id='sub-topic' type="text" name="sub-topic" maxlength="30" placeholder="Choose Sub-topic" required>
                      <datalist id="options">
                      <option value="General"></option>
                      <?php
                      /*
                      $username = $_SESSION['username'];
                        $sql = "SELECT DISTINCT carname FROM reservation WHERE username = '$username'";
                        $result = mysqli_query($conn,$sql);
                        if ($result->num_rows > 0) {
                            while ($row= $result->fetch_assoc()) {
                                echo "<option value = '".$row['carname']."'></option>";
                            }
                        }*/
                      ?>
                        <option value="Payment"></option>
                        <option value="System"></option>
                      <option value="Cars"></option>
                      </datalist>

                      <label for="comment"><b>Comment:</b></label><br>
                      <textarea name="comment" id="comment" form="message_form" rows="10" style="width: 100%;" required></textarea>

                      <input type="submit" name = 'edit_form' form="message_form" class="btn" value="Create New Message"></input>
                        <?php
                            if (isset($_POST['edit_form'])) {
                                $title = $_POST['topic'];
                                $subtopic = $_POST['sub-topic'];
                                $comment = $_POST['comment'];

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

                                if (!empty($title) && !empty($subtopic) && !empty($comment) && !empty($username)) {
                                    //$sql = "INSERT INTO message (customerUsername,groupID,comment,date,statu,receiver) VALUES ('$username','$groupID','$comment',NOW(),0,'admin')";
                                    $stmt = $conn->prepare("INSERT INTO message (customerUsername,groupID,comment,date,statu,receiver) VALUES (?, ?, ?,NOW(),0,?)");
                                    $admin = 'admin';
                                    $zero = 0;
                                    $stmt->bind_param( "ssss",$username, $groupID, $comment,$admin);
                                    $stmt->execute();
                                    
                                    //$result = mysqli_query($conn,$sql);
                                    //$sql = "INSERT INTO message_group (groupID,title,subtopic) VALUES ('$groupID','$title','$subtopic')";


                                    $stmt = $conn->prepare("INSERT INTO message_group (groupID,title,subtopic) VALUES (?, ?, ?)");
                                    
                                    $stmt->bind_param( "sss",$groupID, $title, $subtopic);
                                    $stmt->execute();
                                    //$result = mysqli_query($conn,$sql);
                                }
                            }
                        ?>
                      </form>                       
                  </div>
                  <!-- Reply A Message -->
                  <div class="form-popup" id="replyForm" style=" margin-top:40px; height: 500px; left:45%;right: 15%; background-color:white; <?php 
                    for ($i = 0; $i < $counter; $i++) {
                        if (isset($_POST[strval($i)])) {
                            echo "display: block";
                            $flag = 1;
                            if (isset($_POST['new_message'])) {
                                $messageID = $_POST['new_message'];
                                $username = $_SESSION['username'];
                                $sql_message_statu = "UPDATE message SET statu = '1' WHERE messageID = '$messageID' AND receiver = '$username'";
                                mysqli_query($conn,$sql_message_statu);
                            }
                        }
                    }
                  ?>">

                    <?php

                        $group = $_POST['group'];
                        $sql = "SELECT m.customerUsername,m.comment,mg.title,mg.subtopic FROM message m, message_group mg WHERE m.groupID = '$group' AND m.groupID = mg.groupID";
                        $result = mysqli_query($conn,$sql);
                        
                        while ($row = $result->fetch_assoc()) {
                            $_SESSION['title'] = $row['title'];
                            $_SESSION['subtopic'] = $row['subtopic'];
                            $_SESSION['user'] = $row['customerUsername'];
                            $_SESSION['group'] = $group;
                            $user = $row['customerUsername'];
                            $sql = "SELECT statu FROM users WHERE username = '$user'";
                            $result2 = mysqli_query($conn,$sql);
                            $row2 = $result2->fetch_assoc();
                            $str;
                            if ($row2['statu'] == 0) {
                                $str = "#ddd";
                            }
                            else {
                                $str =  "#b0dff1";
                            }
                            
                            echo "<div style = ' background-color:".$str."'><label for='username'>Username: <span>".$row['customerUsername']."</span></label><br>
                            <label for='comment'>Comment: </label>
                            <textarea name='reply_comment' id='reply_comment' style='width: 90%;' rows='10' readonly>".$row['comment']."</textarea></div><br>";
                        }

                        
                      
           
                        
                    ?>


                    <form id='test_form' action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="form-container">
                    <label for="user_to">Write Your Answer</label>
                    <textarea name="user_mes" id="user_mes" form="test_form" rows="10" style="width: 100%;" required></textarea>
                    <input type="submit" id = 'reply-btn' name = 'reply-btn' form="test_form" value="Reply"></input>
                    </form>
                      <?php
                       
                       $title = $_SESSION['title'];
                       $subtopic = $_SESSION['subtopic'];
                       $group = $_SESSION['group'];
                       $username = $_SESSION['username'];
                        /*
                       echo $username;
                       echo $title;
                       echo $subtopic;
                       echo $group;*/
                        if (isset($_POST['reply-btn'])) {
                            if ($_SESSION['statu'] == 1) {
                                $comment = $_POST['user_mes'];
                                //$sql = "INSERT INTO message (customerUsername,groupID,comment,date,statu,receiver) VALUES ('$username','$group','$comment',NOW(),0,'admin')";
                                $stmt = $conn->prepare("INSERT INTO message (customerUsername,groupID,comment,date,statu,receiver) VALUES (?, ?, ?,NOW(),0,'admin')");
                                $stmt->bind_param("sss",$username,$group,$comment);
                                $stmt->execute();
                                //$result = mysqli_query($conn,$sql);
                                //$sql = "INSERT INTO message_group (groupID,title,subtopic) VALUES ('$group','$title','$subtopic')";
                                $stmt = $conn->prepare("INSERT INTO message_group (groupID,title,subtopic) VALUES (?, ?, ?)");
                                $stmt->bind_param("sss",$group,$title,$subtopic);
                                $stmt->execute();

                                //$result = mysqli_query($conn,$sql);
                                

                            
                            }
                            else {
                                $sql = "SELECT customerUsername FROM message WHERE groupID = '$group' AND customerUsername != 'admin'";
                                $result = mysqli_query($conn,$sql);
                                if ($result->num_rows > 0) {
                                    $row = $result->fetch_assoc();
                                    $receiver = $row['customerUsername'];
                                }
                                $comment = $_POST['user_mes'];
                                //$sql = "INSERT INTO message (customerUsername,groupID,comment,date,statu,receiver) VALUES ('$username','$group','$comment',NOW(),0,'$receiver')";
                                //$result = mysqli_query($conn,$sql);
                                $stmt = $conn->prepare("INSERT INTO message (customerUsername,groupID,comment,date,statu,receiver) VALUES (?, ?, ?,NOW(),0,'admin')");
                                $stmt->bind_param("sss",$username,$group,$comment);
                                $stmt->execute();
                                //$result = mysqli_query($conn,$sql);
                                //$sql = "INSERT INTO message_group (groupID,title,subtopic) VALUES ('$group','$title','$subtopic')";
                                $stmt = $conn->prepare("INSERT INTO message_group (groupID,title,subtopic) VALUES (?, ?, ?)");
                                $stmt->bind_param("sss",$group,$title,$subtopic);
                                $stmt->execute();
                                $stmt->close();
                                //$sql = "INSERT INTO message_group (groupID,title,subtopic) VALUES ('$group','$title','$subtopic')";
                                //$result = mysqli_query($conn,$sql);
                            }
                            

                        }
                        
                        $conn->close();
                      ?>
                    
                    
                  </div>
                </div>
                
        </div>
    </div>
</body>
</html>