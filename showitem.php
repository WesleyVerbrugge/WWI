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

  $q2 = Database::getDb()->prepare("select * from reviews join users on users.UserID = reviews.user_id where product_id like ?");
  $q2->execute([$_GET['item_id']]);
  $q2 = $q2->fetchAll(PDO::FETCH_OBJ);

  // $q3 = Database::GetDb()->prepare("SELECT COUNT(*) FROM reviews WHERE product_id like ?");
  // $q3->execute([$_GET['item_id']]);
  // $q3 = $q3->fetch(PDO::FETCH_OBJ);

  $q3 = count($q2);

    if (!isset($_SESSION["winkelwagen"])) {
        $_SESSION["winkelwagen"] = array();
    }
//    print_r($_GET);
    if (isset($_GET["submitWinkelwagen"])) {
      $quantity = 1;
      
      foreach($_SESSION['winkelwagen'] as &$wagen_item){
          if($_GET['item_id'] == $wagen_item['item_id']){
          $new_quantity = $wagen_item['quantity'] + $quantity;
          $wagen_item['quantity'] = $new_quantity;
          $i = 1;
        }
      }
      if(isset($i)){
        if($i == 1) {
          echo '<div class="alert alert-success" role="alert">
          Item is succesvol toegevoegd!
        </div>';
        } 
      } else {
        $arraytopush = ['item_id' => $q->StockItemID, 'quantity' => $quantity];
        array_push($_SESSION["winkelwagen"], $arraytopush);
        echo '<div class="alert alert-success" role="alert">
        Item is succesvol toegevoegd!
      </div>';
      }
    }

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
        <form method="get" action="showitem.php">
            <input type="submit" class="shopcartbutton" name="submitWinkelwagen" value="In winkelwagen plaatsen">
            <input type="hidden" name="item_id" value="<?php print ($q->StockItemID);?>">
        </form>
        <?php



        ?>
        <BR><BR>
        <p>&checkmark; Voor 23:59 uur besteld, morgen in huis.<BR>
            &checkmark; Geen verzend kosten boven &euro;50.<BR>
        </p>
        <br>
        <h2>Reviews</h2>
        <hr>
        <div class="container">
            <?php
            $limit = 2;
            $rownum = ceil($q3 / $limit);
            for ($i = 1; $i <= $rownum; $i++){
                echo "<div class='row'>";
                foreach ($q2 as $review){
                echo "<div class='col-sm'>";
                echo '
                <div class="card">
                <div class="card-body">
                    <h6 class="card-subtitle mb-2 text-muted">' . $review->Firstname . " " . $review->LastName . '</h6>
                    <p class="card-text">' . $review->review . '</p>
                </div>
                </div>
                </div>
         
                ';
            }
            echo "</div><br>";
            }

            ?>
        </div>
    </div>
      </div>

    <?php include_once('footer.php') ?>
</body>
</html>