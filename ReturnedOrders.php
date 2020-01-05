<?php
include 'header.php';

//checked of de user een admin is
if($_SESSION['user_data']['is_admin'] == 1){
    $link = mysqli_connect("localhost", "root", "", "wideworldimporters");
    if ($link === false) {
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }
    $sql = "SELECT * FROM transactions JOIN stockitems ON transactions.product_id = StockItems.StockItemID JOIN users ON transactions.user_id = users.UserID WHERE is_returned like ?";
    if ($stmt = mysqli_prepare($link, $sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_term);
    
        // Set parameters
        $param_term = 0;
    
        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            // Check number of rows in the result set
            if (mysqli_num_rows($result) > 0) {
                // Fetch result rows as an associative array
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            } else {
                print(mysqli_stmt_error($stmt));
            }
        } else {
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
        }
    }
} else {
    echo '<script type="text/javascript">
            var baseurl = window.location.origin;
                var extra = "?na=1";
                window.location = baseurl + "/wwi/index.php" + extra;
            </script>';
}
if(isset($_GET['rri'])){
    if(isset($_GET['order_id'])) {
        $order_id = $_GET['order_id'];
        $link = mysqli_connect("localhost", "root", "", "wideworldimporters");
        if($link === false) {
            die("ERROR: Could not connect. " . mysqli_connect_error());
        }
        $order_id = $_GET['order_id'];
        $sql = "DELETE FROM transactions WHERE id like '$order_id'";
        if ($link->query($sql) === TRUE) {
            echo '<script type="text/javascript">
            var baseurl = window.location.origin;
                var extra = "?rs=1";
                window.location = baseurl + "/wwi/returnedorders.php" + extra;
            </script>';
        } else {
            echo "Error deleting record: " . $link->error;
        }
    }
}
?>
<body>
    <div class="container">
        <?php if(isset($_GET['rs'])) {
            echo '<div class="alert alert-success" role="alert">
            Returned item succesfully registered
          </div>';
        } ?>
        <h2 style="margin-left: 35%;">Incoming returned orders</h2>
        <hr>
    <table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Product</th>
      <th scope="col">Product id</th>
      <th scope="col">Orderer</th>
      <th scope="col">Orderer email</th>
      <th scope="col">Register returned item</th>
    </tr>
  </thead>
  <tbody>
      <?php
      foreach($result as $returnedOrder){
      ?>
    <tr>
        <th scope="row"><?php echo htmlspecialchars($returnedOrder['id']); ?></th>
        <td><?php echo htmlspecialchars($returnedOrder['StockItemName']); ?></td>
        <td><?php echo htmlspecialchars($returnedOrder['StockItemID']); ?></td>
        <td><?php echo htmlspecialchars($returnedOrder['Firstname']) . " " . htmlspecialchars($returnedOrder['LastName']); ?></td>
        <td><?php echo htmlspecialchars($returnedOrder['Emailadress']); ?></td>
        <?php echo '<td><button class="btn btn-secondary"><a style="color: white;" href="ReturnedOrders.php?rri=1&order_id=' . $returnedOrder['id'] . '">Register</a></button></td>'; ?>
    </tr>
        <?php } ?>
  </tbody>
</table>
    </div>
</body>