<?php
      error_reporting(E_ALL);
      ini_set('display_errors', 1);
    include 'pharmacy_error.php';
    include_once("startsession.php");
    include 'dbconnect.php';
    // Redirects to homepage if there's no active account
    include 'redirect_index_if_not_loggedin.php'; 
    $session_account = $_SESSION['session_account'];
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $newPassword = $_POST['newPassword'];
        $renewPassword = $_POST['renewPassword'];
        // Connect to the database
        // Check for errors
        if ($conn->connect_error()) {
            die("Connection failed: " . $conn->connect_error());
        }
        $checknewpass = strlen($newPassword);
        // Check if passwords match
        if($newPassword == $renewPassword){
            // Check if new passwords string length is equal or more than 8 characters
            if($checknewpass >= 8){
                $new_password_hash = password_hash($newPassword,PASSWORD_DEFAULT); 
                $update_password_hash = "UPDATE customer_table 
                                        SET `password` = '$new_password_hash'
                                        WHERE customer_pk = '$session_account'";
                if ($conn->query($update_password_hash) === TRUE) {
                    if(isset($_SESSION['password'])){
                        $_SESSION['password'] = $newPassword;
                        session_write_close();
                    }
                    echo '<script>alert("Record updated successfully")</script>';
                } else {
                    echo "Error updating record: " . $conn->error();
                }
            }else{
                echo '<script>alert("Passwords must be 8 characters or more.")</script>';
            }
        }else{
            echo '<script>alert("Passwords must match.")</script>';
        }
        $conn->close();
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Edit Profile | User</title>
        <link rel="stylesheet" href="../css/stylesuser.css">
        <link rel="stylesheet" href="../css/styles_loginnavie.css" />
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;500;800&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
    <body>
        <?php include 'navbar.php'?>
        <h2 id="headerpage">My Account</h2>
        <div id="main-box">
        <?php include 'user_navbox.php'?>
            <div class="body-box">
                <h3 class="body-title">Change Password</h3>
                <!--<p class="body-detail">Personal Information</p>-->
                <hr>
                <div class="personal-forms">
                <form action="user_changepass.php" method = "POST">
                    <div id="float-left">
                        <label for="newPassword">New Passaword</label>
                        <input type="password" name="newPassword" onfocus="this.value=''" value="">
                    </div>

                    <label for="renewPassword">Re-enter New Password</label>
                    <input type="password" name="renewPassword" onfocus="this.value=''" value="">

                    <button type="submit" id="save">Save</button>
                </form>
                </div>
            </div>
        </div>
    </body>
</html>