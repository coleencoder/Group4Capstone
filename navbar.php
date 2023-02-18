<?php
    include 'startsession.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nav Bar</title>
    <link rel="stylesheet" href="css/stylesnavie.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;500;800&display=swap" rel="stylesheet">
</head>
<body>
        <div class="nav-actual">
            <div class="logo-holder">
                <h2>ALMED</h2>
            </div>
                <a href="index.php">HOME</a>
                <a href="products.php">SHOP</a>
                <a href="contact.php">CONTACT US</a>
                <a href="about.html">ABOUT US</a>
                <div class="dropdown">
                <?php 
                if(!isset($_SESSION['session_name'])){
                    echo '<button class="log-in">LOGIN</button>
                    <div id="login-option">
                        <a href="login.php">Customer</a>
                        <a href="pharmacy/pharmacy_login.php">Pharmacy</a>
                    </div>';  
                }else { 
                    echo '<button class="log-in">'.$_SESSION['session_name'].'</button>
                    <div id="login-option">
                        <a href="userprofile.php">My Profile</a>
                        <a href="logout.php">Logout</a>
                    </div>';
                }?>
                </div>
            </div>
    </body>
</html>
