<?php 
    include 'startsession.php';
    include 'pharmacy_error.php';
    include 'db_products_connect.php';
    $prod_id;
    if(isset($_GET['prod_id'])){
        $prod_id = $_GET['prod_id'];
    }
    $prod_query = "SELECT product_id, prod_name, price, quantity, `image`, `is-prescripted`, out_of_stock, `description`
                    FROM product_table
                    WHERE product_id = '$prod_id'";
    $prod_run = mysqli_query($conn, $prod_query);
    $prod = mysqli_fetch_assoc($prod_run);
?>
<!DOCTYPE html>
<html>
	<head>
        <title>Product Card | Pharmacy</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="css/Productcard_V2.css">
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;500;800&display=swap" rel="stylesheet">
        <script>
            function out_of_stock(product_id){
                var link = 'pharmacy_out_of_stock.php?prod_id=' + encodeURIComponent(product_id);
                window.location.href = link;
            }
        </script>
    </head>
	
	<body>
        <div id="header"></div>
        <div id="main-box">
            <div id="product-side">
                <img id="med-pic" src="<?php echo 'data:image/jpeg;base64,'.base64_encode($prod['image']);?>" alt="Bioderm">
                <?php if($prod['is-prescripted'] == 1){
                ?><p id="prescription-required">Prescription Required</p><?php }?>
            </div>

            <div id="description-side">
                <h2 id="product-name"><?php echo $prod['prod_name'];?></h2> 
                <p id="price" class="textile">PHP<?php echo $prod['price'];?></p>
                <form action="/action.php">
                    <label for="quantity" class="label-for">Quantity:</label>
                    <input type="number" id="quantity" name="quantity" value="<?php echo $prod['quantity'];?>" min="1" max="20">
                </form>
                <div id="button-function">
                    <a href="pharmacy_edititem.php?prod_id=<?php echo $prod_id;?>" id="edititem" class="buttondapat">Edit Item</a>
                    <?php
                       $is_stock_btn = ($prod['out_of_stock'] == 0)? 
                       '<button onclick="out_of_stock('.$prod['product_id'].')" id="outofstock" class="buttondapat" disabled style="background-color: gray; color: white; cursor: not-allowed;">Mark as Out of Stock</button>'
                       :'<button onclick="out_of_stock('.$prod['product_id'].')"id="outofstock" class="buttondapat">Mark as Out of Stock</button>' ;
                       echo $is_stock_btn;
                    ?>
                </div>
            </div>
        </div>
	<div id="product-desc">
            <p id="info" class="textile">Information</p> 
            <p class="info-med"><?php echo $prod['description'];?></p>
        </div>
        <div id="go-back">
            <a href = "pharmacy_manage.php" id="go-back-button">Go Back</a>
        </div>
	</body>
</html>