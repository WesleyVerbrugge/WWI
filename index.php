<?php 
session_start();
include_once "header.php"; 
if(isset($_GET['ls'])){
    echo '<div class="alert alert-success" role="alert">
    Login successful!
  </div>';
}
if(isset($_GET['mls'])){
    if($_GET['mls'] == 1) {
        echo '<div class="alert alert-success" role="alert">
        Master Login successful!
        </div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">
        Master Login denied!
        </div>';
    }
}
if(isset($_GET['na'])){
    if($_GET['na'] == 1){
        echo '<div class="alert alert-danger" role="alert">
        No admin access
        </div>';
    }
}
?>
<body>
<div class="container-fluid">
    <div class="jumbotron"><h3 class="display-2">Welcome&nbsp;<?php if(isset($_SESSION['user_data'])){ print($_SESSION['user_data']['Firstname']);} ?></h3></div>
</div>
</body>
<?php include_once "footer.php"; ?>