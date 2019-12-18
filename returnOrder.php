<?php
include 'header.php';
if(isset($_GET['order_id'])){
    $order_id = $_GET['order_id'];
    $link = mysqli_connect("localhost", "root", "", "wideworldimporters");
if ($link === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
$sql = "SELECT * FROM transactions JOIN StockItems ON transactions.product_id = StockItems.StockItemID WHERE id like ?";
if ($stmt = mysqli_prepare($link, $sql)) {
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "s", $param_term);

    // Set parameters
    $param_term = $order_id;

    // Attempt to execute the prepared statement
    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);
        // Check number of rows in the result set
        if (mysqli_num_rows($result) > 0) {
            // Fetch result rows as an associative array
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        } else {
            echo "<p>No matches found</p>";
        }
    } else {
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
    }
}

// Close statement
mysqli_stmt_close($stmt);
}
if(isset($_GET['ro'])){
    $link = mysqli_connect("localhost", "root", "", "wideworldimporters");
if ($link === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
$sql = "UPDATE transactions SET is_returned='0' WHERE id=$order_id";
// echo $sql2;
// echo "lol";
if(mysqli_query($link, $sql)){
    echo '<script type="text/javascript">
            var baseurl = window.location.origin;
                window.location = baseurl + "/wwi/returnitem.pdf";
            </script>';
} else {
    echo mysqli_error($link);
    // header('Location: accountpage.php?');
}
}
?>
<body>
    <div class="container">
        <h2 style="margin-left: 40%;">Return your order</h2>
        <hr>
        <table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Product</th>
      <th scope="col">Ordered on</th>
    </tr>
  </thead>
  <tbody>
    <tr>
        <?php if(!empty($row)){ ?>
        <th scope="row"><?php echo htmlspecialchars($row['id']); ?></th>
        <td><?php echo htmlspecialchars($row['StockItemName']); ?></td>
        <td><?php echo htmlspecialchars($row['order_date']); ?></td>
        <?php } ?>
    </tr>
  </tbody>
</table>
<div class="alert alert-warning" role="alert">
  Are you sure you want to return this item?
  <button style="margin-left: 5px; float: right;" class="btn btn-success"><a style="color: white;" href="orders.php">Go back</a></button>
  <?php if(isset($order_id)) { echo '<button style="float: right;" class="btn btn-danger"><a style="color: white;" href="returnOrder.php?ro=1&order_id=' . $order_id . '">Return item</a></button>'; }?>
</div>
    </div>
</body>