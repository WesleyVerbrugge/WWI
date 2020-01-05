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

  $q3 = count($q2);

    if (!isset($_SESSION["winkelwagen"])) {
        $_SESSION["winkelwagen"] = array();
    }

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
          Product has succesfully been added to your <a href="shoppingcart.php">shopping cart</a> !
        </div>';
        } 
      } else {
        $arraytopush = ['item_id' => $q->StockItemID, 'quantity' => $quantity];
        array_push($_SESSION["winkelwagen"], $arraytopush);
        echo '<div class="alert alert-success" role="alert">
        Product has succesfully been added to your <a href="shoppingcart.php">shopping cart</a> !
      </div>';
      }
    }

} else {
  header('Location: '.$defURL);
}
//sql query voor de korting op een prouct
$sql_kortingPercentage = "SELECT DiscountPercentage FROM specialdeals WHERE StockItemID = ?";


?>
<body>
<!-- Foto slides -->
  <div class="floatmidcustom">
    <?php 
    if(isset($_GET['rws'])) {
      echo '<div class="alert alert-success" role="alert">
      Review added succesfuly!
    </div>';
    }
    if(isset($_GET['rrs'])) {
      echo '<div class="alert alert-success" role="alert">
      Review removed succesfully
    </div>';
    }

    if (!empty($q->image)){
        $image = $q->image;
    } else {
        $image = "images/img1.jpg";
    }
      ?>
    <div class="column1">
      <div id="carouselExampleControls" class="borderimage carousel slide" data-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img class="d-block w-100" src="<?php echo htmlspecialchars($image); ?>" alt="First slide">
          </div>
          <div class="carousel-item">
            <img class="d-block w-100" src="<?php echo htmlspecialchars($image); ?>" alt="Second slide">
          </div>
          <div class="carousel-item">
            <img class="d-block w-100" src="<?php echo htmlspecialchars($image); ?>" alt="Third slide">
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
        <p class="prijs">Price: &#8364; <?php echo $q->RecommendedRetailPrice; ?></p>
        <h1 class="margin-left">Product description</h1>
        <p class="margin-left"><?php echo $q->SearchDetails . "." ?></p>
        <br>
        <!-- Vooraad variabelen -->
        <?php
        if ($q->LastStocktakeQuantity >= 10){
            echo "<p class='voldoendevoorraad'>In stock!</p>";
        }
        if (($q->LastStocktakeQuantity > 0) && ($q->LastStocktakeQuantity <10)){
            echo ("<p class='beperktevoorraad'>Limited stock, order fast! Only $q->LastStocktakeQuantity remaining!</p>");
        } if ($q->LastStocktakeQuantity <= 0) {
            echo ("<p class='geenvoorraad'>Sold out!</p>");
        }

        ?>
        <!-- toevoegen knop -->
        <form method="get" action="showitem.php">
            <input type="submit" class="shopcartbutton" name="submitWinkelwagen" value="Add to shopping cart">
            <input type="hidden" id="item_id" name="item_id" value="<?php print ($q->StockItemID);?>">
        </form>
        <?php



        ?>
        <BR><BR>
        <p>&checkmark; Orderd before 23.59, tomorrow at home.<BR>
            &checkmark; No shipping costs above &euro;50.-<BR>
        </p>
        <br>
        <h2>Reviews</h2>
        <hr>

        <div class="container">
              <?php
              foreach($q2 as $review) {
                ?>
                <div class="row">
                  <div class="col-sm">

                  <div class="card">
                    <div class="card-body">
                      <h6 class="card-subtitle mb-2 text-muted"><?php echo $review->Firstname . " " . $review->LastName;?></h6>
                      <p class="card-text"><?php echo $review->review; ?></p>
                      <?php
                      if(isset($_SESSION['user_data'])){
                      if($_SESSION['user_data']['is_admin'] == 1){
                            echo '<a href="delete-review.php?id=' . $review->id . '&item_id=' . $_GET['item_id'] . '"class="btn btn-danger">Verwijder review</a>';
                      }
                      }
                       ?>
                    </div>
                  </div>

                  </div>  
                </div>
                <br>
                <?php
              }
              ?>
              <?php if(isset($_SESSION['user_data'])) {?>
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                Write a review
              </button>
              <?php } else { 
                echo '<div class="alert alert-info" role="alert">
                <a href="login.php">Login</a> to write a review
              </div>';
               } ?>
              <!-- Modal -->
              <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Schrijf je review</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                    <form method="POST" action="showitem.php"></form>
                      <div class="form-group">
                          <textarea class="form-control" id="review" name="review" style="height: 9rem"></textarea>
                      </div>
                      <input type="hidden" id="item_id" name="item_id" value="<?php echo $_GET['item_id']; ?>">
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <button type="submit" id="savereview" class="btn btn-primary">Save review</button>
                    </div>
                  </div>
                </div>
              </div>

        </div>

      </div>

    <?php include_once('footer.php') ?>
</body>
</html>