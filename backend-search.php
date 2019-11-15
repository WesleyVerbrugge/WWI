<?php
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
$link = mysqli_connect("localhost", "root", "", "wideworldimporters");
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
 
if(isset($_GET["Term"]) && isset($_GET["Schoice"])){
    // Prepare a select statement
    if(isset($_GET["Schoice"])) {
      if($_GET["Schoice"] == "aname") {
        $sql = "SELECT * FROM stockitems WHERE StockItemName LIKE ?";
      } else {
        $sql = "SELECT * FROM stockitems WHERE StockItemID LIKE ?";
      }
    }
    
    
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_term);
        
        // Set parameters
        if(isset($_GET["Schoice"])) {
          if($_GET["Schoice"] == "aname") {
            $param_term = '%' . $_GET["Term"] . '%';
          } else {
            $param_term = $_GET["Term"];
          }
        }
        
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
            // Check number of rows in the result set
            if(mysqli_num_rows($result) > 0){
                // Fetch result rows as an associative array
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            } else{
                echo "<p>No matches found</p>";
            }
        } else{
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
        }
    }
     
    // Close statement
    mysqli_stmt_close($stmt);
}
 
// close connection
mysqli_close($link);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>
<body>
<table>
<thead>
<th>id</th>
<th>name</th>
<th></th>
</thead>
<tbody>
<?php
foreach($result as $row){
  echo '<tr>';
  echo '<td>' . $row['StockItemID'] . '</td>';
  echo '<td>' . $row['SearchDetails'] . '</td>';
  echo '<td><form method="post" action="showitem.php"><input type="hidden" name="item_id" value="' . $row["StockItemID"] . '"/> <input type="submit" value="bekijk item"></form></td>';
  echo '</tr>';
}
?>
</tbody>
</table>
</body>
</html>