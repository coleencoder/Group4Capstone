<?php
    include 'startsession.php';
    require 'db_pharmacy_connect.php';
    if(isset($_SESSION['phar_account'])){
        header("location:pharmacyprofile_fresh.php");
        exit();
    }
    if(isset($_POST['submit'])){
        $un=$_POST['uname'];
        $pw=$_POST['pass'];
        $sql=mysqli_query($conn,"select password from pharmacy_table where username='$un'");
        if($row=mysqli_fetch_array($sql)){
            $hash = $row['password']; 
            if(password_verify($pw, $hash)){
                $session_verification = mysqli_query($conn,"select verification_level from pharmacy_table where username='$un' LIMIT 1");
                $session_verification_level = mysqli_fetch_array($session_verification);   
                if($session_verification_level['verification_level'] != 0){
                    $session_userindex = mysqli_query($conn,"select name from pharmacy_table where username='$un'");
                    $session_name=mysqli_fetch_array($session_userindex);
                    $session_account_query = mysqli_query($conn,"select pharmacy_pk from pharmacy_table where username='$un' LIMIT 1");
                    $session_account=mysqli_fetch_array($session_account_query);
                    $_SESSION['pharmacy_password'] = $pw;
                    $_SESSION['phar_account'] = $session_account['pharmacy_pk'];
                    $_SESSION['phar_name'] = $session_name['name'];
                    header("location:pharmacyprofile_fresh.php");
                    exit();
                }else{
                    header("location: pop_up_email_pharmacy.php");
                }
            }else echo "INVALID PASSWORD";
        }else echo "INVALID USERNAME";
    }
?>
<!DOCTYPE hml>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Log In</title>
        <link rel="stylesheet" type = "text/css" href="css/stylespharmacylogin.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;500;800&display=swap" rel="stylesheet">
    </head>
    <body>
        <form action = "index.php" method="POST">
        <div id="main-container">
        <div class="first-container">
                <div class="icon-container">
                    <h2 id="login-tag">Login the Pharmacy Account</h2>
                    <img src="../images/pharmacyicon.jpg" alt="avatar">
                </div>
                <div class="login-proper">
                    <label for="uname"><b>Username</b></label>
                    <input type="text" placeholder="Enter username..." name="uname" class="text" required>

                    <label for="pass"><b>Password</b></label>
                    <input type="password" placeholder="Enter a strong password..." name="pass" class="text" required>
                </div>
                <div class="center-button">
                    <button type="Submit" name="submit">Login</button>
                </div>
                <div class="option">
                    <a href="#" id="forgotpass">Forgot password?</a>
                    <!--<p id="signup">Don't have an account? <a href="#">Sign up</a></p>-->
                </div>
            </div>
            <div class="second-container">
            <div class="signup-blurb">
                    <h2>New Here?</h2>
                    <p><a href="pharmacy_signup.php" id = "sign-up-link">Sign up</a> for an account now!</p>
                </div>
            </div>
        </div>
        </form>
    </body>
</html>