<?php
    if (!isset($_SESSION['session_account'])) {
        header('Location: ../index.php');
        exit;
    }
?>