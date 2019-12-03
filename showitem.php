<?php
session_start();

//connectie db
include_once('dbconnection.php');
//header
include "header.php";
$defURL = "index.php";
//sql query
if(isset($_GET['item_id'])){
  $q = Database::getDb()->prepare("SELECT * FROM stockitems left JOIN stockitemholdings ON stockitems.StockItemID = stockitemholdings.StockItemID left JOIN images_stockitems ON images_stockitems.StockItemID = stockitems.StockItemID WHERE stockitems.StockItemID = ?");
  $q->execute([$_GET['item_id']]);
  $q = $q->fetch(PDO::FETCH_OBJ);


} else {
  header('Location: '.$defURL);
}

//sql query voor de korting op een prouct
$sql_kortingPercentage = "SELECT DiscountPercentage FROM specialdeals WHERE StockItemID = ?";

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
<!-- Foto slides -->
  <div class="floatmidcustom">
    <div class="column1">
      <div id="carouselExampleControls" class="borderimage carousel slide" data-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img class="d-block w-100" src="images/img1.jpg" alt="First slide">
          </div>
          <div class="carousel-item">
            <img class="d-block w-100" src="images/img1.jpg" alt="Second slide">
          </div>
          <div class="carousel-item">
            <img class="d-block w-100" src="images/img1.jpg" alt="Third slide">
          </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
    </div>
    </div>
    <div class="column2">
        <!-- title, prijs, beschrijving aan de rechterkant van de pagina -->
        <p class="title"><?php echo $q->StockItemName ?></p>
        <p class="prijs">Prijs: &#8364; <?php echo str_replace('.', ',', $q->RecommendedRetailPrice); ?></p>
        <p>Verzend kosten: &#8364; 3,95</p>
        <h1 class="margin-left">Beschrijving</h1>
        <p class="margin-left"><?php echo $q->SearchDetails . "." ?></p>
        <br>
        <!-- Vooraad variabelen -->
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
        <!-- toevoegen knop -->
        <form method="post" action="Shopping%20cart.php">
            <input type="submit" class="shopcartbutton" name="submit" value="In winkelwagen plaatsen">
        <?php
        //if (isset($_POST["submit"]) && !empty($_POST["submit"])){
//            $aantal = 4;
//            $ID = $q->StockItemID;
//            if (!isset($_SESSION["winkelwagen"])){
//                $_SESSION["winkelwagen"] = array();
//            }
//            $_SESSION["winkelwagen"][$ID] = $aantal;
        //}

            if (!isset($_SESSION["winkelwagen"])){
                $_SESSION["winkelwagen"] = array();
            }
            array_push($_SESSION["winkelwagen"], $q->StockItemID);
        ?>
        </form>
        <BR><BR>
        <p>&checkmark; Voor 23:59 uur besteld, morgen in huis.<BR>
            &checkmark; Geen bezorg kosten boven 50.<BR>
        </p>

    </div>
      </div>
    <?php include_once('footer.php') ?>
</body>
</html>