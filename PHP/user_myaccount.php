<?php
      error_reporting(E_ALL);
      ini_set('display_errors', 1);
    include 'dbconnect.php';
    include 'startsession.php';
    // Redirects to homepage if there's no active account
    include 'redirect_index_if_not_loggedin.php'; 
    require 'dbconnect.php';
    $session_account = $_SESSION['session_account'];
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $username = $_POST['hold-value'];
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $email = $_POST['email'];
        $phoneNumber = $_POST['phoneNumber']; 
        $gender =  $_POST['gender'];
        $birthDay = $_POST['birthDay'];
        // Connect to the database

        // Check for errors
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Update the data in the database
        $sql = "UPDATE customer_table 
        SET username = '$username',
        first_name = '$firstName',last_name = '$lastName',email = '$email',
        phone_number = '$phoneNumber',gender = '$gender', birth_date = '$birthDay'
        WHERE customer_pk = '$session_account'";
        if ($conn->query($sql) === TRUE) {
            echo '<script>alert("Record updated successfully")</script>';
        } else {
            echo "Error updating record: " . $conn->error;
        }
        // Close the database connection
        $conn->close();
    }
    $account_query= mysqli_query($conn,"select * from customer_table where customer_pk='$session_account' LIMIT 1");
    $account = mysqli_fetch_array($account_query);  
    $conn->close();
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
                <h3 class="body-title">Edit My Account</h3>
                <!--<p class="body-detail">Personal Information</p>-->
                <hr>
                <div class="personal-forms">
                <form action="../PHP/user_myaccount.php" method="POST">
                    <label for="hold-value">Username</label>
                    <?php echo '<input type="text" name="hold-value" onfocus="this.value='.'" value="'.$account["username"].'">';?>                

                    <div id="float-left">
                        <label for="firstName">Given Name</label>
                        <?php echo '<input type="text" name="firstName" onfocus="this.value='.'" value="'.$account["first_name"].'">';?>
                    </div>
                    <div id="float-left">
                        <label for="lastName">Last Name</label>
                        <?php echo '<input type="text" name="lastName" onfocus="this.value='.'" value="'.$account["last_name"].'">';?>
                    </div>

                    <label for="email">Email address</label>
                    <?php echo '<input type="email" name="email" onfocus="this.value='.'" value='.$account["email"].'>';?>

                    <div id="phone-number">
                        <label for="phoneNumber">Phone Number</label>
                        <?php echo '<input type="tel" name="phoneNumber" pattern="^(09|\+639)\d{9}$" onfocus="this.value='.'" value='.$account["phone_number"].'>';?>
                    </div>

                    <label for="gender">Gender </label>
                    <select name="gender" id="gender-select">
                        <option value="Prefer not to say"<?php if ($account['gender'] == 'Prefer not to say' ) echo 'selected = "selected"'; ?>>Prefer not to say</option>
                        <option value="Male"<?php if ($account['gender'] == 'Male' ) echo 'selected = "selected"'; ?>>Male</option>
                        <option value="Female"<?php if ($account['gender'] == 'Female' ) echo 'selected = "selected"'; ?>>Female</option>
                    </select>

                    <label for="birthDay">Birth date </label>
                    <?php echo '<input type="date" name="birthDay" id="birthdate" value='.$account["birth_date"].'>';?>

                    <button type="submit" name="save" id="save">Save</button>
                </form>
                </div>
            </div>

        </div>
    </body>
</html>