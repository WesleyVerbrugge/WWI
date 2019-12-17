<?php 
session_start();
include_once "header.php"; 
if(isset($_GET['ls'])){
    echo '<div class="alert alert-success" role="alert">
    Login succesful!
  </div>';
}
?>
<body>
<div class="container-fluid">
    <div class="jumbotron"><h3 class="display-2">Welkom&nbsp;<?php if(isset($_SESSION['user_data'])){ print($_SESSION['user_data']['Firstname']);} ?></h3></div>
</div>
</body>
<?php include_once "footer.php"; ?>