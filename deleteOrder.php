<?php 
include 'header.php';
if(isset($_GET['order_id'])) {
    $link = mysqli_connect("localhost", "root", "", "wideworldimporters");
if ($link === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
$sql = "SELECT * FROM transactions JOIN StockItems ON transactions.product_id = StockItems.StockItemID WHERE id like ?";
if ($stmt = mysqli_prepare($link, $sql)) {
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "s", $param_term);

    // Set parameters
    $param_term = $_GET['order_id'];

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
if(isset($_GET['do'])) {
    if($_GET['do'] == 1){
        $link = mysqli_connect("localhost", "root", "", "wideworldimporters");
        if($link === false) {
            die("ERROR: Could not connect. " . mysqli_connect_error());
        }
        $order_id = $_GET['order_id'];
        $sql = "DELETE FROM transactions WHERE id like '$order_id'";
        if ($link->query($sql) === TRUE) {
            echo '<script type="text/javascript">
            var baseurl = window.location.origin;
                var extra = "?do=1";
                window.location = baseurl + "/school/wwi/orders.php" + extra;
            </script>';
        } else {
            echo "Error deleting record: " . $link->error;
        }
    }
}
}
?>
<body>
    <div class="container">
        <h2 style="margin-left: 40%;">Delete your order<h2>
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
<?php
if(isset($_GET['order_id'])){
echo '<div class="alert alert-warning" role="alert">
Are you sure you wanna delete this order?
<button class="btn btn-danger" style="margin-left: 5px; float: right;"><a style="color: white;" href="deleteOrder.php?do=1&order_id=' . $_GET['order_id'] . '">Delete</a></button>
<button class="btn btn-success" style="float: right;"><a style="color: white;" href="orders.php">Go back</a></button>
</div>';
}
?>
    </div>
</body>