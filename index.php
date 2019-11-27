<?php session_start(); ?>
<?php include_once "header.php"; ?>
<body>
<div class="container-fluid">
    <div class="jumbotron"><h3 class="display-2">Welkom&nbsp; <?php print($_SESSION['user_data']['PreferredName']); ?></h3></div>
</div>
</body>
<?php include_once "footer.php"; ?>