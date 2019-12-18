<?php
include "header.php";
?>


<h2 class="container">Change your password</h2>
<hr>

<body>
<div class="container">
    <!-- header pagina -->
    <h2>Account page</h2>
<form action="resetpassword.php" method="post">
    <div class="form-group">
        <label for="oldp">Old password</label>
        <input class="form-control" type="password" name="oldp" id="oldp">
    </div>
    <div class="form-group">
        <label for="newp1">New password</label>
        <input class="form-control" type="password" name="newp1" id="newp1">
    </div>
    <div class="form-group">
        <label for="newp2">Confirm new password</label>
        <input class="form-control" type="password" name="newp2" id="newp2">
    </div>
    <button class="btn btn-warning" type="submit">Change my password</button>
</form>
    <BR>
    <a href="accountpage.php">Back to account page</a>