<?php
    include 'startsession.php';
    include 'redirect_index_if_not_loggedin.php';
    include "pharmacy_error.php";
    include 'db_products_connect.php'; 
    $prod_id=null;
    if(isset( $_GET['prod_id'])){
        $prod_id = $_GET['prod_id'];
    }
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $edit_row= null;
        $name = $_POST['item_name'];
        $category = $_POST['med-category'];
        $g_or_b = $_POST['generic-branded']; 
        $prescription = $_POST['prescript-need'];
        $price = $_POST['item-price'];
        $description = $_POST['description'];
        $is_out_of_stock;
        if(isset($_POST['quantity'])){
            $quantity = $_POST['quantity'];
        }
        if($quantity == 0){
            $is_out_of_stock = '';
        }else{$is_out_of_stock = ",`out_of_stock`='1'";}
        if(isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK && !empty($_FILES['image']['tmp_name'])){
            $image =addslashes(file_get_contents($_FILES['image']['tmp_name']));
            $query = "  UPDATE `product_table`
            SET `prod_name` = '$name',`category` = '$category',
            `image` = '$image',`price` = '$price',`description` = '$description',`quantity` = '$quantity' ,`gen_or_brand`='$g_or_b' , `is-prescripted`='$prescription'  $is_out_of_stock
            WHERE `product_id` = '$prod_id'";
        $edit_row = mysqli_query($conn,$query);
        }else{
            $query = "  UPDATE `product_table`
            SET `prod_name` = '$name',`category` = '$category',
            `price` = '$price',`description` = '$description',`quantity` = '$quantity' ,`gen_or_brand`='$g_or_b' , `is-prescripted`='$prescription'  $is_out_of_stock
            WHERE `product_id` = '$prod_id'";
            $edit_row = mysqli_query($conn,$query);
        }
        if($edit_row){
            echo '<script>alert("PRODUCT UPLOAD SUCCESS")</script>';
        }
    }
    $edit_query = " SELECT *
                    FROM product_table
                    WHERE `product_id`='$prod_id' ";
    $edit_product = mysqli_query($conn, $edit_query);
    $edit_row = mysqli_fetch_assoc($edit_product);
    $conn->close();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Edit Item | Pharmacy</title>
        <link rel="stylesheet" href="css/styles_edititem.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;500;800&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>

    <body>
        <div id="title-head">
            <h2>Edit Item</h2>
        </div>
            <div id="add-item-portion">
                <form action="<?php echo 'pharmacy_edititem.php?prod_id='.$prod_id.'';?>" enctype="multipart/form-data" method="POST">
                    <div id="add-photo" style="max-width: 45vw;">
                        <label for="input-photo" id="input-label">
                            Select a photo <br>
                            <i class="fa fa-camera"></i>
                            <input id="input-photo" name = "image" type="file" accept="image/jpg, image/jpeg, image/png">
                            <br>
                            <!--<span id="filename"></span>-->
                            <?php echo '<img src="data:image/jpeg;base64,'.base64_encode($edit_row['image']).'" id="preview-image" style="max-width: 100%;">';?>
                        </label>
                    </div>

                    <script>
                    function previewImage() {
                        var preview = document.querySelector('#preview-image');
                        var file    = document.querySelector('#input-photo').files[0];
                        var reader  = new FileReader();
                        
                        reader.onloadend = function () {
                        preview.src = reader.result;
                        }
                        
                        if (file) {
                        reader.readAsDataURL(file);
                        } else {
                        preview.src = "";
                        }
                    }
                    document.querySelector('#input-photo').addEventListener('change', previewImage);
                    </script>

                    <div id="item-details">
                        <h3 class="portion-title">About the Item</h3>
                        <select name="med-category" class="item-detail" required>
                            <option value="">Select a Category</option>
                            <option value="1"  <?php if ($edit_row['category'] == '1' ) echo 'selected = "selected"'; ?>>Analgesic</option>
                            <option value="2"  <?php if ($edit_row['category'] == '2' ) echo 'selected = "selected"'; ?>>Antibiotic</option>
                            <option value="3"  <?php if ($edit_row['category'] == '3' ) echo 'selected = "selected"'; ?>>Antihistamine</option>
                            <option value="4"  <?php if ($edit_row['category'] == '4' ) echo 'selected = "selected"'; ?>>Decongestant</option>
                            <option value="5"  <?php if ($edit_row['category'] == '5' ) echo 'selected = "selected"'; ?>>Herbal Products</option>
                            <option value="6"  <?php if ($edit_row['category'] == '6' ) echo 'selected = "selected"'; ?>>Maintenance</option>
                            <option value="7"  <?php if ($edit_row['category'] == '7' ) echo 'selected = "selected"'; ?>>Supplements</option>
                            <option value="8"  <?php if ($edit_row['category'] == '8' ) echo 'selected = "selected"'; ?>>Vitamins</option>
                            <option value="9"  <?php if ($edit_row['category'] == '9' ) echo 'selected = "selected"'; ?>>Antiseptic</option>
                            <option value="10" <?php if ($edit_row['category'] == '10' ) echo 'selected = "selected"'; ?>>Hygiene</option>
                            <option value="11" <?php if ($edit_row['category'] == '11' ) echo 'selected = "selected"'; ?>>Others</option>
                        </select>
                        <select name="generic-branded" class="item-detail" required>
                            <option value="" disabled selected>Is it Generic or Branded?</option>
                            <option value="0"<?php if ($edit_row['gen_or_brand'] == '0' ) echo 'selected = "selected"'; ?>>Generic</option>
                            <option value="1"<?php if ($edit_row['gen_or_brand'] == '1' ) echo 'selected = "selected"'; ?>>Branded</option>
                        </select>
						<select name="prescript-need" class="item-detail" required>
                            <option value="" disabled selected>Prescription Needed?</option>
                            <option value="1"<?php if ($edit_row['is-prescripted'] == '1' ) echo 'selected = "selected"'; ?>>Yes</option>
                            <option value="0"<?php if ($edit_row['is-prescripted'] == '0' ) echo 'selected = "selected"'; ?>>No</option>
                        </select>
                        <?php echo '<input type="text" name = "item_name" class="item-detail" placeholder="Name of Item" value = "'.$edit_row['prod_name'].'" required>';?>
                        <div class="item-pricing-q">
                            <label for="item-price" class="for-description">Price</label>
                            <div id="item-pricing-breakdown">
                                <span id="pesos">PHP</span>
                                <?php echo '<input id="item-price" name="item-price" type="text" inputmode="numeric" placeholder="Price of the item" value = "'.$edit_row['price'].'" required>';?>
                            </div>
                        </div>
                        <div class="item-pricing-q">
                            <label for="quantity" id="howmany">Quantity</label>
                            <input id="item-quan" name="quantity" type="number" value = "<?php echo $edit_row['quantity'];?>" inputmode="numeric" required>
                        </div>
                        <div id="item-desc">
                            <label for="description" class="for-description">Description</label>
                            <textarea id="description" name="description" placeholder="Describe the item and include any details that the buyer may find interesting!"><?php echo htmlspecialchars($edit_row['description']); ?></textarea>
                        </div>
                        <div id="center-button">
                            <button type="submit" id="post">Save Changes</button>
                        </div>
                        <style>
#go-back {
    text-align: center;
    margin: 30px 0;
}
#go-back-button {
    text-decoration: none;
    background-color: var(--coolor2);
    color: var(--coolor3);
    font-family: 'Rubik', sans-serif;
    font-size: 1.5em;
    padding: 20px;
}
</style>
 <div id="go-back">
            <a href="https://almedmarikina.online/pharmacy/pharmacy_manage.php" id="go-back-button">Go Back</a>
            </div>
                    </div>
                </form>
            </div>
    </body>
</html>