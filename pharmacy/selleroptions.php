<?php 
    include 'db_pharmacy_connect.php';
    $phar_id;
    if(isset($_SESSION['phar_account'])){
        $phar_id = $_SESSION['phar_account'];
    }
    $query = "SELECT pharmacy_image FROM pharmacy_table WHERE pharmacy_pk = '$phar_id'";
    $phar_img = mysqli_fetch_assoc( mysqli_query($conn, $query));
    $session_name = "null";
    if(isset($_SESSION['phar_name'])){
        $session_name = $_SESSION['phar_name'];
    }
?>
<nav id="seller-options">
    <div id="icon">
        <?php 
            if(isset($_SESSION['phar_account']) && !is_null($phar_img['pharmacy_image'])){
                echo '<img src="data:image/png;base64,'.base64_encode( $phar_img['pharmacy_image'] ).'">';
            }else{
                echo '<img src="images\pharmacist.png">';
            }
        ?>
        <?php echo '<h3>'.$_SESSION['phar_name'].'</h3>'; ?>
    </div>
    <i></i> <a href="pharmacyprofile_fresh.php" class="link-page">Dashboard</a>
    <i></i> <a href="pharmacy_manage.php" class="link-page">Products</a>
    <i></i> <a href="pharmacy_shipment.php" class="link-page">Shipment</a>
    <i></i> <a href="pharmacy_review.php" class="link-page">Reviews</a>
    <i></i> <a href="pharmacy_setting.php" class="link-page">Settings</a>
</nav>