<?php
session_start();
unset($_SESSION['user_data']);
unset($_SESSION["UserID"]);
header('Location: index.php');
?>