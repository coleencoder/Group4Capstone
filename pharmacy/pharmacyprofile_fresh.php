<?php 
    include 'startsession.php';
    include 'db_pharmacy_connect.php';
    include 'pharmacy_error.php';
    include 'redirect_index_if_not_loggedin.php';

    $phar_account;
    if(isset($_SESSION['phar_account'])){
        $phar_account = $_SESSION['phar_account'];
    }
    //NAME AND ADDRESS QUERY
    $query = "SELECT `name`, `address`,`pharmacy_image`, is_completed FROM pharmacy_table WHERE pharmacy_pk = '$phar_account'";
    $query_run = mysqli_fetch_assoc(mysqli_query($conn,$query));
    //PHAR REVIEW QUERY
    $phar_stars = 0;
    $phar_reviews = 0;
    $review_query = mysqli_query($conn, "SELECT COALESCE(ROUND(AVG(phar_star), 1), 0) AS phar_stars,
                                        COUNT(*) AS phar_reviews 
                                        FROM pharmacy_review
                                        WHERE phar_id = '$phar_account'");
    $rows = mysqli_fetch_assoc($review_query);
    if(is_null($rows['phar_stars'])){
        $phar_stars = $rows['phar_stars'];
    }
    if(is_null($rows['phar_reviews'])){
        $phar_reviews = $rows['phar_reviews'];
    }
    $is_completed = $query_run['is_completed'];

    $conn->close();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Welcome | Pharmacy</title>
        <link rel="stylesheet" href="css/styles_pharmacyproffresh.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;500;800&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
        <script>
            $(document).ready(function(){
                $("#remindlater").click(function(){
                    $("#reminder").hide();
                });
            });
        </script>
    </head>
    <body>
        <div id="main-box">
        <?php include 'selleroptions.php';?>
         <div id="seller-profile">
                <div class="greet">
                    <h2>Welcome!</h2>
                    <p>See your profile in a glance...</p>
                </div>
                <?php if($is_completed == null || $is_completed == 0){
                 echo '   <!--For Completing Profile portion-->';
                 echo '   <div id="reminder">';
                 echo '       <h3>You just created an account!</h3>';
                 echo '      <p>We\'re glad to feature your pharmacy in our system! As assurance to our customers';
                 echo '           kindly submit requirements that prove the legitimacy of your pharmacy\'s operation.</p>';
                 echo '           <div id="remind-button">';
                 echo '               <a href="pharma_completeprofile2.php" class="to-complete">Complete Now</a>';
                 echo '               <button type="button" class="to-complete" id = "remindlater">Remind Me Later</button>';
                 echo '           </div>';
                 echo '   </div>';
                }
                ?>
               
                <!--End of Completing Profile portion-->
                <div id="profile-intro">
                    <div id="intro-icon">
                    <?php 
                        if(isset($_SESSION['phar_account']) && !is_null($query_run['pharmacy_image'])){
                            echo '<img src="data:image/png;base64,'.base64_encode( $query_run['pharmacy_image'] ).'">';
                        }else{
                            echo '<img src="images\pharmacist.png">';
                        }
                    ?>
                    </div>
                    <div id="intro-details">
                        <h4 id="pharmacy-name"><?php echo $query_run['name'];?></h4>
                        <p id="pharmacy-address"><?php echo $query_run['address'];?></p>
                        <i class="fa fa-star"></i><p id="no-of-rating"><?php echo "$phar_stars ($phar_reviews)";?></p>

                        <div id="intro-see">
                            <a href="pharmacy_viewprofile.php?phar_id=<?php echo $phar_account;?>" id="view" class="button-profile">View Profile</a>
                            <a href="pharmacy_editprofile.php" id="edit" class="button-profile">Edit Profile</a>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </body>
</html>