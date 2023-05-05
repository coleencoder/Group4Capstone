<?php
    include 'startsession.php';
    //Import PHPMailer classes into the global namespace
    //These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    //Load Composer's autoloader
    require '../vendor/autoload.php';

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
    // Include file which makes the
    // Database Connection.
    include 'db_pharmacy_connect.php'; 
        $phar_name =    $_POST["phar_name"];       
        $address =      $_POST["address"];
        $email =        $_POST["email"];
        $userName =     $_POST["userName"];
        $pass =         $_POST["pass"];
        $repeatPass =   $_POST["repeatPass"];
        $verification_token = md5(rand()); 
        
        $sql = "Select * from pharmacy_table where email='$email'";
    
        $result = mysqli_query($conn, $sql);
        
        $num = mysqli_num_rows($result); 
        
        // This sql query is use to check if
        // the username is already present 
        // or not in our Database
        if($num == 0) {
            if(($pass == $repeatPass)) {

                //START SEND EMAIL
                try {
                    //Server settings
                    $mail->isSMTP();                                            //Send using SMTP
                    $mail->Host       = 'almedmarikina.online';                 //Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                    $mail->Username   = 'support@almedmarikina.online';                     //SMTP username
                    $mail->Password   = 'q[u-F;Ij9$IN';                               //SMTP password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
            
                    //Recipients
                    $mail->setFrom('support@almedmarikina.online');
                                                                        //Add a recipient
                    $mail->addAddress($email);                          //Name is optional

                    //Content
                    $mail->isHTML(true);                                  //Set email format to HTML
                    $mail->Subject = "AlMed Marikina Pharmacy Sign-Up Verification";
                    $mail->Body = "
                        <h2>You have signed up an account for AlMed Marikina as our partnered Pharmacy.</h2>
                        <h5>Click the <a href='almedmarikina.online/pharmacy/pharmacy_email_verification.php?token=$verification_token'>link</a> to verify your account.</h5>
                    ";
                    $mail->send();
                    //END SEND EMAIL
                    $hash = password_hash($pass,PASSWORD_DEFAULT); 
                    $sql2 = "INSERT INTO `pharmacy_table` ( `name`, `address`, 
                    `email`,`username`,`password`,`verification_level`,
                    `verification_token`) VALUES ('$phar_name', 
                        '$address', '$email','$userName','$hash','0',
                        '$verification_token')";
                    $result2 = mysqli_query($conn, $sql2);
                    if ($result2) {
                        header("location:pop_up_email_pharmacy.php");
                        exit();
                    }
                } catch (Exception $e) {
                    echo '<script>alert("Message could not be sent. Mailer Error: {$mail->ErrorInfo}")</script>';
                }
            } 
            else { 
             echo '<script>alert("Passwords do not match")</script>'; 
            }       
        }else{
        echo '<script>alert("Email not available")</script>'; 
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Sign Up</title>
        <link rel="stylesheet" href="css/stylespharmacysignup.css">
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
                    <img src="..\images\blank.png" alt="Blank-Avatar.png">
                </div>
                <form action = "pharmacy_signup.php" method = "POST"><div class="sign-up">
                    <label for="firstName"><b>Pharmacy Name</b></label>
                    <input type="text" name="phar_name" placeholder="Enter your name..." required>

                    <label for="surName"><b>Address</b></label>
                    <input type="text" name="address" placeholder="Enter your surname..." required>

                    <label for="email"><b>Email address</b></label>
                    <input type="email" name="email" placeholder="Enter email address..." required>

                    <label for="userName"><b>Username</b></label>
                    <input type="text" name="userName" placeholder="Enter username..." required>

                    <label for="pass"><b>Password</b></label>
                    <input type="password" name="pass" placeholder="Enter a strong password..." required>

                    <label for="repeatPass"><b>Repeat Password</b></label>
                    <input type="password" name="repeatPass" placeholder="Repeat password..." required>

                    <p>By creating an account, you agree with the <a href="../terms.php">Terms of Use</a></p>
                    <label for="termsOfUse">
                        <input type="checkbox" id = "checkbox" name="termsOfUse"> I agree
                    </label>
                </div>
                <div class="center-signup">
                    <button type="submit" name ="submit" id="continue" disabled>Sign Up</button>
                    <button type="submit" id="cancel"><a id = "cancel" href = "pharmacy_login.php">Cancel</a></button>
                </div>
            </form>
            </div>
        </div>
        <script>
            const myCheckbox = document.querySelector('#checkbox');
            const myButton = document.querySelector('#continue');

            myCheckbox.addEventListener('change', function() {
            console.log('Checkbox state changed.');
            if (myCheckbox.checked) {
                myButton.disabled = false;
            } else {
                myButton.disabled = true;
            }
            });
        </script>
    </body>
</html>
