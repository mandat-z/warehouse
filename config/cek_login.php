<?php
session_start();
if (!isset($_SESSION['id_user'])) {
    header("Location: /warehouse/dist/login.php");
    exit;
}
?>