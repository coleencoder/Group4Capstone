<?php
    include("startsession.php");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/styles.css">
    <title> Almed Marikina </title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;500;800&display=swap" rel="stylesheet">
</head>
<body>
    <!--<div class="banner">-->
        <?php include 'navbar.php';?>
        <div id="titlecard">
            <h1>Welcome to ALMed Marikina</h1>
            <p>Accessible local medicine from local pharmacies of Marikina</p>
        </div>
        <div id="maincard">
            <div class="entries">
                <h2 class="title">An Online Portal for Viewing Medicines</h2>
                <p class="description">The website allows you to check the availability of medicines from pharmacies
                in Marikina City</p>
                <img src="images\sampleimg.jpg">
            </div>
        </div>
            <div class="category-card">
                <div class="entries">
                    <h2 class="title">What Medicine are you Looking For?</h2>
                    <p class="description">Browse from the different categories of medicine to check their
                        availability</p>
                </div>
                <div class="category-flex">
                    <div class="category-unit">
                        <h3>Analgesics</h3>
                    </div>
                    <div class="category-unit">
                        <h3>Colds, cough, and flu</h3>
                    </div>
                    <div class="category-unit">
                        <h3>First Aid</h3>
                    </div>
                    <div class="category-unit">
                        <h3>Vitamins</h3>
                    </div>
                </div>
                <div class="button">
                    <a href="products.php" class="view-all">View all categories</a>
                </div>
            </div>
            <div class="card-diff-color">
                <div class="entries">
                    <h2 class="title">Our Featured Pharmacies</h2>
                    <p class="description">Medicines from this website are provided by
                        local, family-owned pharmacies from Marikina City. This ensures
                        that your medicine comes from real pharmacies, from Marikina too!
                    </p>
                    <img src="images\samplephoto.jpg" id="own-photo">
                </div>
                <div class="button">
                    <a href="products.php" class="view-all">View all pharmacies</a>
                </div>
            </div>
        <div id="footercard">
            <div class="footer-sub">
                <h4>ALMed Marikina</h4>
                <a href="#">Terms and Condition</a>
                <a href="#">Privacy Policy</a>
            </div>
            <div class="footer-sub">
                <h5>About Us</h5>
                <a href="index2.html">About the Website</a>
                <a href="#">Contact Us</a>
            </div>
            <div class="footer-sub">
                <h5>Shop</h5>
                <a href="products.php">Available Medicine</a>
                <a href="products.php">Partner Pharmacies</a>
            </div>
        </div>
        <!--<div class="content">
            <h1>Welcome to Almed Marikina</h1>
                <p></p>
                <button type="button"><span></span> Click here</button>
                <button type="button"><span></span> Click here</button>
        </div>-->
    <!--</div>-->
</body>
</html>



