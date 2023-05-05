<?php
    include 'startsession.php';
    include 'redirect_index_if_not_loggedin.php';
    require 'db_pharmacy_connect.php';
    $session_account = $_SESSION['phar_account'];
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $username  = $_POST['username'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        // Update the data in the database
        $sql = "UPDATE pharmacy_table 
        SET username = '$username',
        `name` = '$name',email = '$email'
        WHERE pharmacy_pk = '$session_account'";
        if ($conn->query($sql) === TRUE) {
            $_SESSION['phar_name'] = $name;
            echo '<script>alert("Record updated successfully")</script>';
        } else {
            echo "Error updating record: " . $conn->error();
        }
        // Close the database connection
    }
    $account_query= mysqli_query($conn,"select * from pharmacy_table where pharmacy_pk='$session_account' LIMIT 1");
    $account = mysqli_fetch_array($account_query);  
    $conn->close();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Your Profile | Pharmacy</title>
        <link rel="stylesheet" href="css/stylespharmacysetting.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;500;800&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
    <body>
        <div id="main-box">
        <?php include 'selleroptions.php'?>
            <div id="seller-profile">
                <div class="greet">
                    <h2>Account Settings</h2>
                </div>
                <div class="motivation">
                    <div class="item">
                        <h3>Pharmacy Information</h3>
                        <div class="hr"></div>
                        <div class="personal-forms">
                            <form action="pharmacy_setting_edit.php" method = "POST">
                                <label for="username">Username</label>
                                <?php echo'<input type="text" name="username" onfocus="this.value='.'" value="'.$account["username"].'">';?>
                                            
                                <div id="float-left">
                                    <label for="firstName">Pharmacy Name</label>
                                    <?php echo'<input type="text" name="name" onfocus="this.value='.'" value="'.$account["name"].'">';?>
                                </div>
            
                                <label for="email">Email address</label>
                                <?php echo'<input type="email" name="email" onfocus="this.value='.'" value="'.$account["email"].'">';?>

                                <button type="submit" id="save">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>