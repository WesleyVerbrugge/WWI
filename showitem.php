<?php
include_once('dbconnection.php');
$defURL = "index.php";
if(isset($_POST['item_id'])){
  $q = Database::getDb()->prepare("SELECT * FROM stockitems JOIN stockitemholdings ON stockitems.StockItemID = stockitemholdings.StockItemID WHERE stockitems.StockItemID = ?");
  $q->execute([$_POST['item_id']]);
  $q = $q->fetch(PDO::FETCH_OBJ);
} else {
  header('Location: '.$defURL);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
  <title>Document</title>
</head>
//
<body>
  <table>
    <thead>
      <th>id</th>
      <th>naam</th>
      <th>price</th>
      <th>size</th>
      <th>stock</th>
      <th>image</th>
      <th>description</th>
    </thead>
    <tbody>
      <tr>
        <td><?php echo $q->StockItemID ?></td>
        <td><?php echo $q->StockItemName ?></td>
        <td><?php echo $q->RecommendedRetailPrice ?></td>
        <td><?php echo $q->Size ?></td>
        <td><?php echo $q->LastStocktakeQuantity ?></td>
        <td><img height="42" width="42" src="<?php if(empty($q->photo)){ echo "placeholder.png"; } else { echo $q->image; }?>"></td>
          <td><?php echo $q->SearchDetails ?></td>
      </tr>
    </tbody>
  </table>
</body>
</html>