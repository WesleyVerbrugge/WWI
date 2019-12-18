<?php
session_start();
$eindtotaal = 0;
include "header.php";
include "dbconnection.php";
// database connectie
$connection = mysqli_connect("localhost", "root", "", "wideworldimporters", 3306);
// var_dump($_SESSION['winkelwagen']);

if(isset($_GET['delete_item_id'])){
    foreach($_SESSION['winkelwagen'] as $index => $item){
        // var_dump($index);
        if($_GET['delete_item_id'] == $item['item_id']){
            unset($_SESSION['winkelwagen'][$index]);
            $_SESSION['winkelwagen'] = array_values($_SESSION['winkelwagen']);
        }
    }
}
?>

<html>

<head>
    <title>Shopping cart</title>
    <link rel="stylesheet" href="style.css">
</head>

<!-- header pagina -->
<h2 class="margin-left">Shopping cart</h2>
<?php

//checked of knop voor legen winkelwagen geset is
if (isset($_GET["LeegCart"])){
    $_SESSION["winkelwagen"] = NULL;
}


?>
    <?php
    // checked of de winkelwagen leeg is
        if (empty($_SESSION["winkelwagen"])){
            print ("<p class=\"winkelwagenleeg\">");
            print ("Your shopping cart is empty");
            print ("</p>");
        } else {
    ?>
            <table id="cart" class="table table-hover table-condensed" style="margin-left: 0">
                <thead>
                <tr>
                    <th style="width:50%">Product</th>
                    <th style="width:10%">Price</th>
                    <th style="width:8%">Quantity</th>
                    <th style="width:22%" class="text-center">Subtotal</th>
                    <th style="width:8%"></th>
                </tr>
                </thead>
    <?php
    //sql query product informatie
$sql = "SELECT * FROM stockitems left JOIN stockitemholdings ON stockitems.StockItemID = stockitemholdings.StockItemID left JOIN images_stockitems ON images_stockitems.StockItemID = stockitems.StockItemID WHERE stockitems.StockItemID = ?";
$statement = mysqli_prepare($connection, $sql);

// for loop die elke rij voor een toegevoegd product print
for ($i = 0; $i < (count($_SESSION["winkelwagen"])); $i++) {

    // pakt steeds het volgende nummer uit de winkelwagen array. Deze array bestaat uit de default key's en de value is het itemID.
    $value = $_SESSION["winkelwagen"][$i]['item_id'];
    // foreach($_SESSION['winkelwagen'][$i] as $item){
    //     $value = $item['item_id'];
    // }
    //vult het itemID in bij de sql query
    mysqli_stmt_bind_param($statement, "i", $value);
    mysqli_stmt_execute($statement);
    $results = mysqli_stmt_get_result($statement);
    //met $row kun je nu de item informatie ophalen
    $row = mysqli_fetch_array($results);

    ?>


    <?php
        // variabelen voor gebruikte product informatie
        $ItemID = $row["StockItemID"];
        $naam = $row["StockItemName"];
        $prijs = $row["RecommendedRetailPrice"];
        $beschrijving = $row["MarketingComments"];
        ?>
        <tbody>
        <tr>
            <!-- foto van product -->
            <td data-th="Product">
                <div class="row">
                    <div class="col-sm-2 hidden-xs"><a href="showitem.php?item_id=<?php print($ItemID); ?>"><img height="100px" src="images/img1.jpg" alt="Product Image" class="img-responsive"/></a></div>
                    <div class="col-sm-10">
                        <h4 class="nomargin"><a class="stretched-link text-dark" href="showitem.php?item_id=<?php print($ItemID); ?>"><?php print ($naam); ?></a></h4>
                        <p><?php if (!empty($beschrijving)){print $beschrijving;} ?></p>
                    </div>
                    </div>
            </td>
            <td data-th="Price">&#8364;<?php print ($prijs) ?></td>
                <!-- prijs per stuk met een str_replace om een . naar een , te veranderen -->
            <!-- form om de aantallen te veranderen -->
            <td data-th="Quantity" style="text-align: center">
                <form method="post">
                    <div class="quantity">
                <input style="width: 60%; display: inline-block" min="1" class="form-control" type="number" name="aantalProducten<?php print ($ItemID); ?>" value="<?php
                    foreach($_SESSION['winkelwagen'] as $item) {
                        if($item['item_id'] == $row['StockItemID']){
                            $aantalproductid = "aantalProducten" . $ItemID;
                            if (isset($_POST[$aantalproductid])){
                                $_SESSION["winkelwagen"][$i]["quantity"] = $_POST[$aantalproductid];
                            }
                            echo $_SESSION["winkelwagen"][$i]["quantity"];
                        }
//                        $aantal = $_SESSION["winkelwagen"][$i]["quantity"];
                    }

                    ?>"></div>
                    <button style="margin-top: .1rem" class="btn btn-info btn"><i class="fa fa-refresh"></i></button>
                </form>
                </td>
            <td data-th="Subtotal" class="text-center">&#8364;<?php print(number_format(($totaal = $prijs * $_SESSION["winkelwagen"][$i]["quantity"]), 2)); $eindtotaal += $totaal; ?></td>

<td>
    <form action="shoppingcart.php" method="get">
        <button type="submit" class="btn-danger btn" name="verwijderProduct"><i class="fa fa-trash-o"></i></button>
        <input type="hidden" name="delete_item_id" value="<?php echo $row['StockItemID']; ?>">
    </form>
</td>
        </tr>

      <?php
    }

 ?>
        </tbody>
                <tfoot>
                <tr class="visible-xs">
                    <td></td>
                <td></td>
                    <td style="text-align: right"><strong>Shipping:</strong></td>
                    <td style="text-align: center"><?php $shippingCost = 3.95; if ($eindtotaal < 50){ $freeShippingPrice = str_replace(".",",",50 - $eindtotaal); print ("<strong>&#8364; " . str_replace(".",",",$shippingCost) . "</strong><br><div class=\"alert alert-warning\" style='font-size: small; padding: 0; margin: 0;' role=\"alert\">Add <color class='text-success'>&#8364; $freeShippingPrice</color> worth of products to receive <color class='text-success'><b>free shipping</b></color>!</div>"); $eindtotaal += $shippingCost;} else { print ("<color class='text-success'>Free shipping</color>");}  ?></td>
                    <td></td>
                </tr>
                <tr>
                    <td><a href="backend-search.php?Term=&Schoice=aname&azr=max" class="btn btn-warning"><i class="fa fa-angle-left"></i> Continue Shopping</a></td>
                    <td colspan="2" class="hidden-xs"></td>
                    <td class="hidden-xs text-center"><strong><?php print ("&#8364; " . number_format($eindtotaal, 2));?></strong></td>
                    <td><a href="orderCheck.php" class="btn btn-success btn-block">Checkout <i class="fa fa-angle-right"></i></a></td>
                </tr>
                </tfoot>
</table>
<p>
            <!-- button voor het legen van de gehele winkelwagen
            Deze knop is licht zichtbaar voor het debuggen
            -->
    <form class="margin-left" action="shoppingcart.php" method="get" style="opacity: 10%">
        <input type="submit" name="LeegCart" value="leeg winkelwagen">
    </form>
</p>
            <!-- knop die je naar de pagina voor het zien van je bestelling brengt -->
<!--            <form class="margin-left" action="orderCheck.php">-->
<!--                <input type="submit" name="orderCheck" value="bestellen">-->
<!--            </form>-->
<pre>
<?php
// sluit de for loop af
}
//    print_r($_SESSION["winkelwagen"]);
?>
</pre>
<script>
    jQuery('<div class="quantity-nav"><div class="quantity-button quantity-up">+</div><div class="quantity-button quantity-down">-</div></div>').insertAfter('.quantity input');
    jQuery('.quantity').each(function() {
        var spinner = jQuery(this),
            input = spinner.find('input[type="number"]'),
            btnUp = spinner.find('.quantity-up'),
            btnDown = spinner.find('.quantity-down'),
            min = input.attr('min'),
            max = input.attr('max');

        btnUp.click(function() {
            var oldValue = parseFloat(input.val());
            if (oldValue >= max) {
                var newVal = oldValue;
            } else {
                var newVal = oldValue + 1;
            }
            spinner.find("input").val(newVal);
            spinner.find("input").trigger("change");
        });

        btnDown.click(function() {
            var oldValue = parseFloat(input.val());
            if (oldValue <= min) {
                var newVal = oldValue;
            } else {
                var newVal = oldValue - 1;
            }
            spinner.find("input").val(newVal);
            spinner.find("input").trigger("change");
        });

    });
</script>
</html>