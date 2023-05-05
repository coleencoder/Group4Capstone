<?php
    include 'startsession.php';
    require 'dbconnect.php';
    if(isset($_POST['submit'])){
        $un=$_POST['uname'];
        $pw=$_POST['pass'];
        $sql=mysqli_query($conn,"select password from customer_table where username='$un'");
        if($row=mysqli_fetch_array($sql)){
            $hash = $row['password']; 
            if(password_verify($pw, $hash)){
                $session_verification = mysqli_query($conn,"select verification_level from customer_table where username='$un' LIMIT 1");
                $session_verification_level = mysqli_fetch_array($session_verification);   
                if($session_verification_level['verification_level'] != 0){
                    $session_userindex = mysqli_query($conn,"select first_name from customer_table where username='$un'");
                    $session_name=mysqli_fetch_array($session_userindex);
                    $session_account_query = mysqli_query($conn,"select customer_pk from customer_table where username='$un' LIMIT 1");
                    $session_account=mysqli_fetch_array($session_account_query);
                    $_SESSION['password'] = $pw;
                    $_SESSION['session_account'] = $session_account['customer_pk'];
                    $_SESSION['session_name'] = $session_name['first_name'];
                    header("location:../index.php");
                    exit();
                }else{
                    header("location: pop_up_email.php");
                }
            }else echo '<script>alert("INVALID PASSWORD")</script>';
        }else echo '<script>alert("INVALID USERNAME")</script>';
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Log In</title>
        <link rel="stylesheet" href="../css/styleslogin.css">
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
                    <img src="..\images\blank.png" alt="avatar">
                </div>
                <div class="login-proper">
                    <label for="uname"><b>Username</b></label>
                    <input type="text" placeholder="Enter your username..." name="uname" class="text" oninput="enableSubmit()" required>

                    <label for="pass"><b>Password</b></label>
                    <input type="password" placeholder="Enter your password..." name="pass" class="text" oninput="enableSubmit()" required>
                </div>
                <div class="center-button">
                    <button type="Submit" name="submit">Login</button>
                </div>
                <!--<div class="option">
                    <a href="#" id="forgotpass">Forgot password?</a>
                    <p id="signup">Don't have an account? <a href="#">Sign up</a></p>
                </div>-->
            </div>
            <div class="second-container">
                <div class="signup-blurb">
                    <h2>New Here?</h2>
                    <p><a href="signup.php" id="sign-up-link">Sign up</a> for an account now!</p>
                </div>
            </div>
        </div>
        </form>
        <script type="text/javascript">
            function enableSubmit(){
                let inputs = document.getElementsByClassName('fields');
                let submit = document.querySelector('button[type="submit"]');
                let isValid = true;
                for (var i = 0; i < inputs.length; i++){
                    let changedInput = inputs[i];
                    if (changedInput.value.trim() === "" || changedInput.value === null){
                        isValid = false;
                    break;
                    }
                    }
                submit.disabled = !isValid;
            }
        </script>
    </body>
</html>
