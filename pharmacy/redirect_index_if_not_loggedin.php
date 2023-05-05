<?php
    if (!isset($_SESSION['phar_account'])) {
        header('Location: index.php');
        exit;
    }
?>