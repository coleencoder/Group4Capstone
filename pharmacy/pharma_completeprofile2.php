<?php 
include 'startsession.php';
include 'redirect_index_if_not_loggedin.php';
include 'db_pharmacy_connect.php';
$phar_account;
if(isset($_SESSION['phar_account'])){
    $phar_account = $_SESSION['phar_account'];
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    //GET IMAGE INTO VARIABLE
    $document =addslashes(file_get_contents($_FILES['document']['tmp_name']));
    //INSERT IMAGE VARIABLE INTO DATABASE QUERY 
    $insert_docu_image = "UPDATE pharmacy_table
                            SET document = '$document', docu_approved = '1', is_completed = '1'
                            WHERE pharmacy_pk = '$phar_account'";
    //EXECUTE QUERY AND PUT INTO VARIABLE 
    $insert = mysqli_query($conn, $insert_docu_image);
    //CHECKS IF QUERY IS SUCCESSFUL
    if($insert){
        echo '<script>alert("UPLOAD OF DOCUMENT SUCCESS!")</script>';
        echo '<script>setTimeout(function() { window.location.href = "pharmacyprofile_fresh.php"; }, 1000);</script>';
    }
    //CLOSE DATABASE CONNECTION
    $conn -> close();
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Complete | Pharmacy</title>
        <link rel="stylesheet" href="css/styles_pharmacyprofcomplete2.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;500;800&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>

    <body>
        <h2>Complete your Account</h2>
        <form id="complete-form" action="pharma_completeprofile2.php"  enctype="multipart/form-data" method = "POST">
            <div class="master-tab">
                <div class="tab">
                <h3>Upload a proof of your pharmacy's legitimacy</h3>
                <p>This could be a file or a photo of your business permit, or other
                    document that legalizes the operation of your pharmacy.</p>
                    <div class="input-holder">
                        <label for="input-legit" class="input-label">
                            Select a file <br>
                            <i class="fa fa-file"></i>
                            <input id="input-legit" name = "document" class="input" type="file" accept="image/jpg, image/png, image/jpeg, .doc, .docx, .pdf" required onchange="showFileName(event);">
                            <br>
                            <span id="filename"></span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="buttons">
                <a id="go-back" href="pharmacyprofile_fresh.html">Go Back</a>
                <button id="submit" type="submit">Submit</button>
            </div>
        </form>
        <script type="text/javascript">
            var input = document.getElementById('input-photo');
            var infoArea = document.getElementById('filename');
            input.addEventListener('change', showFileName);
            function showFileName(event) {
            // the change event gives us the input it occurred in 
             var pics = event.srcElement;
  
            // the input has an array of files in the `files` property, each one has a name that you can use. We're just using the name here.
            var fileName = pics.files[0].name;
            infoArea.textContent = 'File name: ' + fileName;}
        </script>
    </body>
</html>