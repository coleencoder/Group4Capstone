<?php
    include 'pharmacy_error.php';
    include 'startsession.php';
    include 'redirect_index_if_not_loggedin.php';
    include 'db_products_connect.php';
    $phar_pk;
    if(isset($_SESSION['phar_account'])){
        $phar_pk = $_SESSION['phar_account'];
    }
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $name = $_POST['item_name'];
        $category = $_POST['med-category'];
        $g_or_b = $_POST['generic-branded']; 
        $prescription = $_POST['prescript-need'];
        $price = $_POST['item-price'];
        $description = htmlspecialchars($_POST['description']);
        $phar_conn = mysqli_connect("","almedmar_frank", '5$v#W?Q+HLn#', "almedmar_Pharmacy");
        $phar_query = mysqli_query($phar_conn, "SELECT `name` FROM pharmacy_table WHERE pharmacy_pk = '$phar_pk'");
        $phar_row = mysqli_fetch_assoc($phar_query); 
        $phar_name = $phar_row['name'];
        $phar_conn->close();
        if(isset($_POST['quantity'])){
            $quantity = $_POST['quantity'];
        }
        $image =addslashes(file_get_contents($_FILES['image']['tmp_name']));
        $query = "INSERT INTO `product_table` (`phar_name`,`phar_id`,`prod_name`,`category`,`image`,`price`,`description`,`out_of_stock`,`quantity`,`gen_or_brand`,`is-prescripted`) 
                                        VALUES ('$phar_name','$phar_pk','$name','$category','$image','$price', '$description','1','$quantity','$g_or_b','$prescription')";
        $result = mysqli_query($conn,$query);
        if($result){
            echo '<script>alert("PRODUCT UPLOAD SUCCESS")</script>';
        }
    }
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
            <h2>Add Item</h2>
        </div>
            <div id="add-item-portion">
                <form action="pharmacy_additem.php" enctype="multipart/form-data" method="POST">
                    <div id="add-photo" style="max-width: 45vw;">
                        <label for="input-photo" id="input-label">
                            Select a photo <br>
                            <i class="fa fa-camera"></i>
                            <input id="input-photo" name = "image" type="file" accept="image/jpg, image/jpeg, image/png" required>
                            <br>
                            <!--<span id="filename"></span>-->
                            <img id="preview-image" style="max-width: 100%;">
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
                            <option value="1">Analgesic</option>
                            <option value="2">Antibiotic</option>
                            <option value="3">Antihistamine</option>
                            <option value="4">Decongestant</option>
                            <option value="5">Herbal Products</option>
                            <option value="6">Maintenance</option>
                            <option value="7">Supplements</option>
                            <option value="8">Vitamins</option>
                            <option value="9">Antiseptic</option>
                            <option value="10">Hygiene</option>
                            <option value="11">Others</option>
                        </select>
                        <select name="generic-branded" class="item-detail" required>
                            <option value="" disabled selected>Is it Generic or Branded?</option>
                            <option value="0">Generic</option>
                            <option value="1">Branded</option>
                        </select>
						<select name="prescript-need" class="item-detail" required>
                            <option value="" disabled selected>Prescription Needed?</option>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                        <input type="text" name = "item_name" class="item-detail" placeholder="Name of Item" required>
                        <div class="item-pricing-q">
                            <label for="item-price" class="for-description">Price</label>
                            <div id="item-pricing-breakdown">
                                <span id="pesos">PHP</span>
                                <input id="item-price" name="item-price" type="text" inputmode="numeric" placeholder="Price of the item" required>
                            </div>
                        </div>
                        <div class="item-pricing-q">
                            <label for="quantity" id="howmany">Quantity</label>
                            <input id="item-quan" name="quantity" type="number" inputmode="numeric" required>
                        </div>
                        <div id="item-desc">
                            <label for="description" class="for-description">Description</label>
                            <textarea id="description" name="description" placeholder="Describe the item and include any details that the buyer may find interesting!"></textarea>
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