<?php 
include 'startsession.php';
use PHPMailer\PHPMailer\PHPMailer;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';
$_SESSION['from_signup'] = false;
    
if($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Include file which makes the
    // Database Connection.
    include 'dbconnect.php';   
    $firstname = $_POST["fullName"];
    $lastname = $_POST["surName"];
    $email = $_POST["email"];
    $username = $_POST["userName"]; 
    $password = $_POST["pass"]; 
    $cpassword = $_POST["repeatPass"];
    $verification_token = md5(rand()); 
    
    $sql = "Select * from user_account where email='$email'";
    
    $result = mysqli_query($conn, $sql);
    
    $num = mysqli_num_rows($result); 
    
    // This sql query is use to check if
    // the username is already present 
    // or not in our Database
    if($num == 0) {
        if(($password == $cpassword)) {
            
            $hash = password_hash($password,PASSWORD_DEFAULT); 
            $sql = "INSERT INTO `user_account` ( `username`, 
                `password`, `email`,`firstname`,`lastname`,`verification_level`,`verification_token`) VALUES ('$username', 
                '$hash', '$email','$firstname','$lastname','0','$verification_token')";
    
            //START SEND EMAIL
            $mail = new PHPMailer(true);

            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; 
            $mail->SMTPAuth = true;
            $mail->Username = 'almedmarikina@gmail.com';
            $mail->Password = 'rsrpyyylxynidyvm';
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;
    
            $mail->setFrom('almedmarikina@gmail.com');
    
            $mail->addAddress($email);
    
            $mail->isHTML(true);
    
            $mail->Subject = "AlMed Marikina Sign-Up Verification";
            $mail->Body = "
                <h2>You have signed up an account for AlMed Marikina.</h2>
                <h5>Click the <a href='almedmarikina.infinityfreeapp.com/email_verification.php?token=$verification_token'>link</a> to verify your account.</h5>
            ";
    
            $mail->send();
            //END SEND EMAIL
            
            $result = mysqli_query($conn, $sql);
            if ($result) {
                $_SESSION['verification_level'] = 0;
                $_SESSION['from_signup'] = true;
                header("location:login.php");
                exit();
            }
        } 
        else { 
         echo "Passwords do not match"; 
        }      
    }else{
        echo "Email not available"; 
    }
}//end if   
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Sign Up</title>
        <link rel="stylesheet" href="css/stylessignup.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;500;800&display=swap" rel="stylesheet">
    </head>
    <body>
        <div id="sign-up-box">
            <div class="design-portion">
            </div>
            <div class="sign-up-portion">
                <div id="header">
                    <h2>Sign Up</h2>
                    <img src="images\blank.png" alt="Blank-Avatar.png">
                </div>
                <form method = "POST"><div class="sign-up">
                    <label for="firstName"><b>Given Name</b></label>
                    <input type="text" name="fullName" placeholder="Enter your name..." required>

                    <label for="surName"><b>Surname</b></label>
                    <input type="text" name="surName" placeholder="Enter your surname..." required>

                    <label for="email"><b>Email address</b></label>
                    <input type="email" name="email" placeholder="Enter email address..." required>

                    <label for="userName"><b>Username</b></label>
                    <input type="text" name="userName" placeholder="Enter username..." required>

                    <label for="pass"><b>Password</b></label>
                    <input type="password" name="pass" placeholder="Enter a strong password..." required>

                    <label for="repeatPass"><b>Repeat Password</b></label>
                    <input type="password" name="repeatPass" placeholder="Repeat password..." required>

                    <p>By creating an account, you agree with the <a href="termsofuse.php">Terms of Use</a></p>
                    <label for="termsOfUse">
                        <input type="checkbox" checked="checked" name="termsOfUse"> I agree
                    </label>
                </div>
                <div class="center-signup">
                    <button type="submit" name ="submit" id="continue">Sign Up</button>
                    <button type="submit" id="cancel"><a href = "login.php">Cancel</a></button>
                </div></form>
            </div>
            <div class="photo-portion">

            </div>
        </div>
    </body>
</html>