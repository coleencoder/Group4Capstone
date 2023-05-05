<?php 
    include 'PHP/startsession.php';
    if(isset($_POST['submit'])){
        header('location: PHP/products_medpage.php');
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/styles_loginnavie.css">
    <title> Almed Marikina </title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;500;800&display=swap" rel="stylesheet">
</head>
<body>
    <!--<div class="banner">-->
        <?php include 'PHP/navbar.php';?>
        <div id="titlecard">
            <img src="images/logurr_effec2.png" id="logo-site">
            <p>Accessible local medicine from local pharmacies of Marikina</p>
        </div>
        <div id="maincard">
            <div class="entries">
                <h2 class="title">An Online Portal for Viewing Medicines</h2>
                <p class="description">The website allows you to check the availability of medicines from pharmacies
                in Marikina City</p>
                <img src="images/Online%20Pharmacy%20set1.jpg">
            </div>
        </div>
            <div class="category-card">
                <div class="entries">
                    <h2 class="title">What Medicine are you Looking For?</h2>
                    <p class="description">Browse from the different categories of medicine to check their
                        availability</p>
                </div>
                <div class="category-flex">
                    <a href = "../PHP/products_medpage.php?category_id=1" class="category-unit">
                        <h3>Analgesics</h3>
                    </a>
                    <a href = "../PHP/products_medpage.php?category_id=2" class="category-unit">
                        <h3>Antibiotics</h3>
                    </a>
                    <a href = "../PHP/products_medpage.php?category_id=3" class="category-unit">
                        <h3>Antihistamine</h3>
                    </a>
                    <a href = "../PHP/products_medpage.php?category_id=4" class="category-unit">
                        <h3>Decongestants</h3>
                    </a>
                </div>
                <div class="button">
                    <a href="PHP/products.php#shop_category" class="view-all">View all categories</a>
                </div>
            </div>
            <div class="card-diff-color">
                <div class="entries">
                    <h2 class="title">Our Featured Pharmacies</h2>
                    <p class="description">Medicines from this website are provided by
                        local, family-owned pharmacies from Marikina City. This ensures
                        that your medicine comes from real pharmacies, from Marikina too!
                    </p>
                    <img src="images/Online%20Pharmacy%20set2.jpg" id="own-photo">
                </div>
                <div class="button">
                    <a href="PHP/products.php#shop_pharmacy" class="view-all">View all pharmacies</a>
                </div>
            </div>
        <div id="footercard">
            <div class="footer-sub">
                <h4>ALMed Marikina</h4>
                <a href="Terms.html">Terms and Condition</a>
                <a href="Privacy.html">Privacy Policy</a>
            </div>
            <div class="footer-sub">
                <h5>About Us</h5>
                <a href="PHP/about.php">About the Website</a>
                <a href="PHP/contact.php#contact">Contact Us</a>
            </div>
            <div class="footer-sub">
                <h5>Shop</h5>
                <a href="PHP/products.php#shop_category">Available Medicine</a>
                <a href="PHP/products.php#shop_pharmacy">Partner Pharmacies</a>
            </div>
        </div>
</body>
</html>



