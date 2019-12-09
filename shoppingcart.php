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
    <title>Winkelwagen</title>
    <link rel="stylesheet" href="style.css">
</head>

<!-- header pagina -->
<h2 class="margin-left">Winkelwagen</h2>
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
            print ("Uw winkelwagen is leeg");
            print ("</p>");
        } else {
    ?>

<table class="shoppingcarttable">
    <thead>
        <th>Product</th>
        <th>Prijs Per Stuk</th>
        <th>Aantal</th>
        <th>Verwijderen</th>
        <th>Totaal</th>
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
        ?>
        <tbody>
        <tr>
            <!-- foto van product -->
            <td class="column1Shoppincart borderright"><img height="75" width="75" src="images/img1.jpg"><?php print ($naam) ?></td>
            <a class="column2Shoppingcart">
                <!-- prijs per stuk met een str_replace om een . naar een , te veranderen -->
            <td class="borderright tableTextRight">&#8364;<?php print (str_replace('.', ',', $prijs)) ?></td>
                <td class="borderright tableTextRight">
                    <!-- form om de aantallen te veranderen -->
                    <?php 
                    foreach($_SESSION['winkelwagen'] as $item) {
                        // var_dump($item['item_id']);
                        // var_dump($row['StockItemID']);
                        if($item['item_id'] == $row['StockItemID']){
                            echo $item['quantity'];
                        }
                        $aantal = $item['quantity'];
                    }
                    ?>
                </td>
                    <td class="borderright tableTextRight">
                        <!-- button voor het verwijderen van een product uit de winkelwagen -->
                        <form action="shoppingcart.php" method="get">
                            <button type="submit" class="btn btn-danger" name="verwijderProduct">-</button>
                            <input type="hidden" name="delete_item_id" value="<?php echo $row['StockItemID']; ?>">
                        </form>
                    </td>
            <td class="tableTextRight">&#8364;<?php
                // totaal prijs van het product * aantal
                    $totaal = $prijs * $aantal;
                    print (str_replace('.', ',', $totaal));
                    $eindtotaal = $eindtotaal + $totaal;
                ?></td>
            </a>
        </tr>
      <?php
    // verwijderd product als knop voor verwijderen is ingedrukt
    }
    if (isset($_GET["verwijderProduct"])){
        unset($_SESSION["winkelwagen"][$row["StockItemID"]]);
    }

    if ($eindtotaal < 50){
        $eindtotaal = $eindtotaal + 3.95;

        ?>
    <tr>
       <td></td>
        <td></td>
        <td></td>
        <td class="tableTextRight borderright">Verzend kosten:</td>
        <td class="tableTextRight">&euro;3.95</td>
    </tr>


        <?php
    } else {
        ?>
        <tr>
       <td></td>
        <td></td>
        <td></td>
        <td class="tableTextRight borderright">Verzend kosten:</td>
        <td class="tableTextRight">&euro;0,00</td>
    </tr>
        <?php
    }
?>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td class="borderright tableTextRight">Totaal bedrag:</td>
        <td class="totaalbedrag tableTextRight">&#8364;<?php

            //print het te betalen bedrag voor de gehele winkelwagen
            print (str_replace('.', ',', $eindtotaal));
            ?></td>
    </tr>
</table>
<p>
            <!-- button voor het legen van de gehele winkelwagen -->
    <form class="margin-left" action="shoppingcart.php" method="get">
        <input type="submit" name="LeegCart" value="leeg winkelwagen">
    </form>
</p>
            <!-- knop die je naar de pagina voor het zien van je bestelling brengt -->
            <form class="margin-left" action="orderCheck.php">
                <input type="submit" name="orderCheck" value="bestellen">
            </form>

<?php
// sluit de for loop af
}

?>

</html>