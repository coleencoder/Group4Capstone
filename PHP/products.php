<?php 
    include 'startsession.php';
    $pharmacy_db_conn =  mysqli_connect("","almedmar_frank", '5$v#W?Q+HLn#', "almedmar_Pharmacy");
    $category_db_conn =  mysqli_connect("","almedmar_frank", '5$v#W?Q+HLn#', "almedmar_Product");
    $pharmacy_name_find = "SELECT pharmacy_pk, `name`
                        FROM pharmacy_table";
    $pharmacy_name_query = mysqli_query($pharmacy_db_conn,$pharmacy_name_find);
    $pharmacy_db_conn->close();
    $category_name_find = "SELECT category, `image`,`category-name`
    FROM product_category 
    ORDER BY CASE WHEN `category-name` = 'Others' THEN 1 ELSE 0 END, `category-name` ASC";
    $category_name_query = mysqli_query($category_db_conn,$category_name_find);
    $category_db_conn->close();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Buy Products | ALMed Marikina</title>
        <link rel="stylesheet" href="../css/stylesproduct.css">
        <link rel="stylesheet" href="../css/styles_loginnavie.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;500;800&display=swap" rel="stylesheet">
    </head>
    <body>
    <?php include 'navbar.php'?>
        <section id="product-section">
            <h2>Buy Products</h2>
        </section>
        <main>
            <section class="shop-intro" id="shop_category">
                <h3>Shop by Category</h3>
            </section>
            <div id="categories">
            <?php 
                while ($row = mysqli_fetch_assoc($category_name_query)) {
                    echo '
                    <div class="options">
                    <a href="../PHP/products_medpage.php?category_id='.$row['category'].'"
                    > <img class="image" src="data:image/jpeg;base64,'.base64_encode($row['image']).'" 
                    ></a>
                    <h3>'.$row['category-name'].'</h3>
                    </div>
                        ';
                }
            ?>
            </div>
            <section class="shop-intro" id ="shop_pharmacy">
                <h3>Shop by our Partner Pharmacies</h3>
            </section>
            <div id="pharmacies">
            <?php 
                    while ($row = mysqli_fetch_assoc($pharmacy_name_query)) {
                        echo '
                        <div class="pharma-name">
                            <a href="../PHP/pharmacy_viewprofile.php?phar_id='.$row['pharmacy_pk'].'"><h3>'.$row['name'].'</h3></a>
                        </div>
                        ';
                    }
            ?>
            </div>
            <div id="go-back">
            <a href = "../index.php" id="go-back-button">Back to Home</a>
            </div>
        </main>
    </body>
</html>