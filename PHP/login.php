<?php
    include 'startsession.php';
    require 'dbconnect.php';
    if($_SESSION['verification_level'] == 0 && $_SESSION['from_signup'] == true){
        echo "Please check email to verify.";
    }
    if(isset($_POST['submit'])){
        $un=$_POST['uname'];
        $pw=$_POST['pass'];
        $sql=mysqli_query($conn,"select password from user_account where username='$un'");
        if($row=mysqli_fetch_array($sql)){
            $hash = $row['password']; 
            if(password_verify($pw, $hash)){
                $session_verification = mysqli_query($conn,"select verification_level from user_account where username='$un' LIMIT 1");
                $session_verification_level = mysqli_fetch_array($session_verification);   
                if($session_verification_level['verification_level'] != 0){
                    $session_userindex = mysqli_query($conn,"select firstname from user_account where username='$un'");
                    $session_name=mysqli_fetch_array($session_userindex);
                    $session_account_query = mysqli_query($conn,"select primarykey from user_account where username='$un' LIMIT 1");
                    $session_account=mysqli_fetch_array($session_account_query);
                    $_SESSION['session_account'] = $session_account['primarykey'];
                    $_SESSION['session_name'] = $session_name['firstname'];
                    header("location:index.php");
                    exit();
                }else{
                    echo "Account not yet verified.";
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
        <link rel="stylesheet" href="css/styleslogin.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;500;800&display=swap" rel="stylesheet">
    </head>
    <body>
        <form action = "login.php" method="post">
        <div id="main-container">
            <div class="first-container">
                <div class="icon-container">
                    <h2 id="login-tag">Login to your Account</h2>
                    <img src="images\avatar-f.jpg" alt="avatar">
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
                    <p><a href="signup.php">Sign up</a> for an account now!</p>
                </div>
            </div>
        </div>
        </form>
    </body>
</html>
