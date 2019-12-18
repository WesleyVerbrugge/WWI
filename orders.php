<?php 
session_start();
if (isset($_GET["oc"]) && $_GET["oc"] == 1){
    unset($_SESSION["winkelwagen"]);
}
include "header.php";
$link = mysqli_connect("localhost", "root", "", "wideworldimporters", 3306);
$sql = "SELECT * FROM transactions JOIN StockItems on transactions.product_id = StockItems.StockItemID WHERE user_id = ?";
$stmt = mysqli_prepare($link, $sql);
$user_id = $_SESSION['user_data']['UserID'];
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$results = mysqli_stmt_get_result($stmt);
//met $row kun je nu de item informatie ophalen
$row = mysqli_fetch_array($results);

?>
<body>
<div class="container">
<?php
if(isset($_GET['do'])){
  if($_GET['do'] == 1){
    echo '<div class="alert alert-success" role="alert">
    Order succesfully deleted!
  </div>';
  }
}

if (isset($_GET["oc"]) && $_GET["oc"] == 1){
    print ("<div class=\"alert alert-success\" role=\"alert\">Your order is complete, thank you for your purchase!</div>");
    unset($_SESSION["winkelwagen"]);
}
?>
<h2 style="margin-left: 40%;">Orders</h2>
<hr>
<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Product</th>
      <th scope="col">Ordered on</th>
      <th scope="col">Delivered on</th>
      <th scope="col">Cancel Order</th>
      <th scope="col">Return Order</th>
    </tr>
  </thead>
  <tbody>
    <?php 
    if(is_array($row)) {
        foreach($results as $order){
            echo '<tr>
            <th scope="row">' . $order['id'] . '</th>
            <td>' . $order['StockItemName'] . '</td>
            <td>' . $order['order_date'] . '</td>
            ';
            if(!is_null($order['delivery_date'])){
                echo '<td>' . $order['delivery_date'] . '</td>';
                echo '<td></td>';
                echo '<td><button class="btn btn-danger"><a style="color: white;" href="returnorder.php?order_id=' . $order['id'] . '">-</a></button></td>';
            } else {
                echo '<td>Not delivered yet</td>';
                echo '<td><button class="btn btn-danger"><a style="color: white;" href="deleteorder.php?order_id=' . $order['id'] . '">-</a></button></td>';
                echo '<td></td>';
            }
            
            echo
            '</tr>';
        }
    }
    ?>
  </tbody>
</table>
</div>
</body>