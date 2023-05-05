<?php 
    include 'startsession.php';
    require 'db_product_connect.php';
    $prod_id;
    if(isset($_GET['prod_id'])){
        $prod_id = $_GET['prod_id'];
    }
    //PRODUCT QUERY
    $query = "  SELECT *
                FROM product_table
                WHERE product_id = '$prod_id'";
    $row = mysqli_fetch_assoc(mysqli_query($conn, $query));
    $category = $row['category'];
    $phar_id = $row['phar_id'];
    $is_prescripted = $row['is-prescripted'];
    //PHARMACY QUERY
    $pharmacy_db_conn =  mysqli_connect("","almedmar_frank", '5$v#W?Q+HLn#', "almedmar_Pharmacy");
    $phar_query = " SELECT `pharmacy_image`, `name` , `pharmacy_pk`
                    FROM pharmacy_table
                    WHERE pharmacy_pk = '$phar_id'";
    $phar_row = mysqli_query($pharmacy_db_conn, $phar_query);
    $phar = mysqli_fetch_assoc($phar_row);
    $pharmacy_db_conn->close();
    //SEE ALSO QUERY
    $see_also_query = " SELECT *
                        FROM product_table
                        WHERE category = (SELECT category FROM product_table WHERE product_id = $prod_id)
                        AND product_id != $prod_id
                        LIMIT 8";
    $see_also_row = mysqli_query($conn, $see_also_query);
    //ADD TO CART
    $cus_id;
    $prod_id_to_cart = $prod_id;
    $quantity;
    $price = $row['price'];
    $subtotal;
    $image = $row['image'];
    $name = $row['prod_name'];
    $prod_phar_name = $phar['name'];
    if(isset($_SESSION['session_account'])){
        $cus_id = $_SESSION['session_account'];
    }
    $order_db_conn = mysqli_connect("", "almedmar_frank", '5$v#W?Q+HLn#', "almedmar_Order");
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if(!isset($_SESSION['session_account'])){
            echo '<script>alert("You need to sign-up or login first.")</script>';
        }else{
            $quantity = $_POST['quantity'];
            $subtotal = $price * $quantity;
            // Escape the image data to prevent SQL injection attacks
            $escaped_image = mysqli_real_escape_string($order_db_conn, $image);
            
            $id_exists_query = "SELECT * FROM `cart_table` WHERE `cus_prod_id` = '$cus_id-$prod_id_to_cart'";
            $id_exists_result = mysqli_query($order_db_conn, $id_exists_query);
    
            if (mysqli_num_rows($id_exists_result) > 0) {
                // The ID already exists in the database
                echo '<script>alert("Product is already in your cart.")</script>';
            } else {
            $add_to_cart_query = "INSERT INTO `cart_table` (`customer_id`,`product_id`,`prod_name`,`prod_image`,`cart_quantity`,`cart_price`,`cart_item_subtotal`,`prod_phar_name`,`phar_id`,`is-prescripted`) 
            VALUES ('$cus_id','$prod_id_to_cart','$name','$escaped_image','$quantity','$price','$subtotal','$prod_phar_name', '$phar_id','$is_prescripted')";
    
            $add_to_cart = mysqli_query($order_db_conn, $add_to_cart_query);
            if (!$add_to_cart) {
                echo "Error adding to cart: " . mysqli_error($order_db_conn);
            } else {
                echo '<script>alert("Added to cart.")</script>';
            }
            }
        }
    }
    $conn->close();
    $order_db_conn->close();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Product Card | Customer</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="../css/styles_productcard.css">
        <link rel="stylesheet" href="../css/styles_loginnavie.css">
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;500;800&display=swap" rel="stylesheet">
    </head>
    <body>
        <?php include 'navbar.php'?>
        <div id="head"></div>
        <div id="main-box">
            <div id="product-side">
                <?php 
                echo '<img id="med-pic" src="data:image/jpeg;base64,'.base64_encode( $row['image'] ).'"
                 alt="'.$row['prod_name'].'">';?>
                 <?php if($row['is-prescripted'] == 1){
                ?><p id="prescription-required">Prescription Required</p><?php }?>
            </div>

            <div id="description-side">
                <h2 id="product-name"><?php echo $row['prod_name'];?></h2> 
                <p id="price" class="textile">PHP<?php echo $row['price'];?></p>
                
                <form action="<?php echo 'Productcard.php?prod_id='.$row['product_id'];?>" method = "post">
                    <label for="quantity" class="label-for">Quantity:</label>
                    <input type="number" id="quantity" name="quantity" min="1" max="20" required>
                    <div id="button-function">
                        <?php 
                        if($row['out_of_stock'] == 0){
                            echo '<button type = "submit" name = "add_to_cart" 
                            id="outofstock" class="buttondapat" disabled>Add to Cart</button>';
                        }else{
                            echo '<button type = "submit" name = "add_to_cart" 
                        id="outofstock" class="buttondapat">Add to Cart</button>';
                        }
                        ?>
                    </div>
                </form>
            </div>
        </div>
        <div id="seller-portion">
            <img src="<?php echo 'data:image/jpeg;base64,'.base64_encode( $phar['pharmacy_image'] );?>" id="seller-pic" alt="Phararmacy Profile Pic">
            <div id="seller-links">
                <h4 id="seller-avail"><?php echo $phar['name'];?></h4>
                <a id="seller-linktoprof" href="<?php echo "pharmacy_viewprofile.php?phar_id=$phar_id";?>" target="_blank">View Profile</a>
            </div>
        </div>
        <div id="product-desc">
            <p id="info" class="textile">Information</p> 
            <p class="info-med"><?php echo $row['description'];?></p>
        </div>
        <h3 id="similar-products">Similar Products</h3>
        <div id="product-holder">
            <?php 
                while($see_row = mysqli_fetch_assoc($see_also_row)){
                    $is_stock = ($see_row['out_of_stock'] == 0)? "Out of Stock":" In Stock" ;
                    echo '
                    <div class="item">
                        <div class="seller-tab">
                            <p class="seller-name">'.$see_row['phar_name'].'</p>
                        </div>
                        <a href="Productcard.php?prod_id='.$see_row['product_id'].'" class="link-image">
                            <img class="med-pic"  src="data:image/jpeg;base64,'.base64_encode( $see_row['image'] ).'" 
                            alt="'.$see_row['prod_name'].'">
                        </a>
                        <div class="med-desc">
                            <p class="med-name">'.$see_row['prod_name'].'</p>
                        <p class="med-price">PHP'.$see_row['price'].'</p>
                            <p class="med-name">'.$is_stock.'</p>
                        </div>
                    </div>
                    ';
                }
            ?>
        </div>
     
             <div id="go-back">
                 <a href = "<?php echo 'products_medpage.php?category_id='.$row['category'];?>" id="go-back-button">Back to Products</a>
             </div>
    </body>    
</html> 