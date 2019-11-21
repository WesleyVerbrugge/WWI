<?php
include_once('dbconnection.php');
include "header.php";
$defURL = "index.php";
if(isset($_GET['item_id'])){
  $q = Database::getDb()->prepare("SELECT * FROM stockitems left JOIN stockitemholdings ON stockitems.StockItemID = stockitemholdings.StockItemID left JOIN images_stockitems ON images_stockitems.StockItemID = stockitems.StockItemID WHERE stockitems.StockItemID = ?");
  $q->execute([$_GET['item_id']]);
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
<body>
 <!--
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
        <td><?php //echo $q->StockItemID ?></td>
        <td><?php //echo $q->StockItemName ?></td>
        <td><?php //echo $q->RecommendedRetailPrice ?></td>
        <td><?php //echo $q->Size ?></td>
        <td><?php //echo $q->LastStocktakeQuantity ?></td>
        <td><img height="42" width="42" src="<?php //if(empty($q->image)){ echo "placeholder.png"; } else { echo $q->image; }?>"></td>
          <td><?php //echo $q->SearchDetails ?></td>
      </tr>
    </tbody>
  </table>
  -->
    <div class="column1">
        <img class="borderimage" height="600" width="600" src="images/img1.jpg"><BR><BR>
        <h1 class="margin-left">Beschrijving</h1>
        <p class="margin-left"><?php echo $q->SearchDetails . "." ?></p>
    </div>
    <div class="column2">
        <p class="title"><?php echo $q->StockItemName ?></p>
        <p class="prijs">Prijs: &#8364; <?php echo $q->RecommendedRetailPrice ?></p>
        <?php
        if ($q->LastStocktakeQuantity >= 10){
            echo "<p class='voldoendevoorraad'>Op voorraad!</p>";
        }
        if (($q->LastStocktakeQuantity > 0) && ($q->LastStocktakeQuantity <10)){
            echo ("<p class='beperktevoorraad'>Beperkt op voorraad, bestel snel! Nog maar $q->LastStocktakeQuantity beschikbaar.</p>");
        } if ($q->LastStocktakeQuantity <= 0) {
            echo ("<p class='geenvoorraad'>Uitverkocht!</p>");
        }

        ?>
        <button type="button"  class="shopcartbutton" > In winkelwagen plaatsen</button>
        <BR><BR>
        <p>&checkmark; Voor 23:59 uur besteld, morgen gratis in huis.</p>
    </div>

</body>
</html>