<?php
session_start();
unset($_SESSION['user_data']);
unset($_SESSION["UserID"]);
unset($_SESSION['Amountlogin']);
header('Location: index.php');
?>