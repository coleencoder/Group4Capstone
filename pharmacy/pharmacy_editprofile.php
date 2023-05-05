<?php
    include 'startsession.php';
    include 'redirect_index_if_not_loggedin.php';
    include 'pharmacy_error.php';
    include 'db_pharmacy_connect.php';
    $phar_id=null;
    $query_row;
    if(isset($_SESSION['phar_account'])){
        $phar_id = $_SESSION['phar_account'];
    }
    //EDIT PHARMACY PROFILE
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $edit_row = null;
        $name = htmlspecialchars( $_POST['name']);
        $address = htmlspecialchars($_POST['address']);
        $bio = htmlspecialchars($_POST['bio']);
        if(isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK && !empty($_FILES['image']['tmp_name'])){
            $image =addslashes(file_get_contents($_FILES['image']['tmp_name']));
            $edit_query = "UPDATE pharmacy_table
                            SET `name` = '$name', `address` = '$address', pharmacy_image = '$image' , bio = '$bio' 
                            WHERE pharmacy_pk = '$phar_id'";
            $edit_row = mysqli_query($conn,$edit_query);
        }else{
            $edit_query = "UPDATE pharmacy_table
            SET `name` = '$name', `address` = '$address', bio = '$bio' 
            WHERE pharmacy_pk = '$phar_id'";
            $edit_row = mysqli_query($conn,$edit_query);
        }
        if($edit_row){
            echo '<script>alert("PRODUCT UPDATE SUCCESS")</script>';
        }
    }
    //QUERY LOAD PROFILE TO PAGE
    $query = "SELECT `name`, `address`, pharmacy_image, bio
            FROM pharmacy_table
            WHERE pharmacy_pk = '$phar_id'";
    $query_row = mysqli_fetch_assoc(mysqli_query($conn, $query));
    $conn->close();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Edit Profile | Pharmacy</title>
        <link rel="stylesheet" href="css/styles_pharmacyeditprof.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;500;800&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
    <body>
        <h2>Edit Profile</h2>
        <form action="<?php echo 'pharmacy_editprofile.php?phar_id='.$phar_id.'';?>" enctype="multipart/form-data" method="POST">
            <div id="edit-name-add" class="edit">
                <label for="changename" class="label-for-header">Name of Pharmacy</label>
                <input id="changename" class="input-text" type="text" name = "name" value = "<?php echo $query_row['name']?>">

                <label for="changeaddress" class="label-for-header">Address</label>
                <input id="takeadd" class="input-text" type="text"  name = "address" value = "<?php echo $query_row['address']?>">
            </div>

            <div id="edit-icon" class="edit">
                <?php 
                    if(is_null( $query_row['pharmacy_image'])){
                        echo '<img id="icon" src="..\images\avatar-f.jpg">';
                    }else{
                        echo '<img id="icon" src="data:image/jpeg;base64,'.base64_encode( $query_row['pharmacy_image'] ).'">';
                    }
                ?>
                <label for="changeicon" class="label-for-input">
                    Change my Icon <br>
                    <input id="changeicon" type="file" name = "image" accept="image/jpg, image/jpeg, image/png" onchange="showPreview(event);">
                </label>
            </div>

            <div id="edit-bio" class="edit">
                <label for="changebio" class="label-for-header">Bio</label>
                <textarea id="changebio" name = "bio" placeholder = "Enter Bio here..."><?php echo $query_row['bio']?></textarea>
            </div>

            <div id="button">
                <button type="submit" id="submit">Save Changes</button>
            </div>
        </form>

        <script type="text/javascript">
            function showPreview(event){
                if(event.target.files.length > 0){
                    var src = URL.createObjectURL(event.target.files[0]);
                    var preview = document.getElementById("icon");
                    preview.src = src;
                    preview.style.width = "170px";
                    preview.style.height = "170px";
                    preview.style.objectFit = "cover";
                    }
                }
        </script>
    </body>
</html>