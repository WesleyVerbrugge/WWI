<?php
session_start();
if(isset($_GET['review'])){
  if(isset($_GET['item_id'])){
    $review = $_GET['review'];
    $item_id = $_GET['item_id'];
    $user_id = $_SESSION['user_data']['UserID'];
    $link = mysqli_connect("localhost", "root", "", "wideworldimporters");
    $sql = "INSERT INTO reviews (review, product_id, user_id) VALUES ('$review', '$item_id', '$user_id')";
    if($stmt = mysqli_prepare($link, $sql)){
      if (mysqli_stmt_execute($stmt)) {
          header('Location: showitem.php?item_id=' . $item_id . '&rws=1');
      } else {
          echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
      }
    }
  }
}
?>