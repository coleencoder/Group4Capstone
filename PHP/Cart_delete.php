<?php 
    include 'db_order_connect.php';
    //DELETE ROW
  $id='';
  if(isset($_POST['id'])){
    $id .= $_POST['id'];
  }
  $delete_query = "DELETE FROM cart_table WHERE cus_prod_id = '$id'";
  $delete  = mysqli_query($conn, $delete_query);
  if($delete){echo 1;}
  $conn->close();
?>