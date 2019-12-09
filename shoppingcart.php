<?php
session_start();

$eindtotaal = 0;

include "header.php";
include "dbconnection.php";
// database connectie
$connection = mysqli_connect("localhost", "root", "", "wideworldimporters", 3306);

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
    $value = $_SESSION["winkelwagen"][$i];

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
        <tr>
            <!-- foto van product -->
            <td class="column1Shoppincart borderright"><img height="75" width="75" src="images/img1.jpg"><?php print ($naam) ?></td>
            <a class="column2Shoppingcart">
                <!-- prijs per stuk met een str_replace om een . naar een , te veranderen -->
            <td class="borderright tableTextRight">&#8364;<?php print (str_replace('.', ',', $prijs)) ?></td>
                <td class="borderright tableTextRight">
                    <!-- form om de aantallen te veranderen -->
                    <form action="shoppingcart.php" method="post">
                        <select name="aantal">
                            <option name="1" value="1" <?php if ((isset($_POST["aantal"])) && ($_POST["aantal"] == 1)){ print (" selected");} ?>>1</option>
                            <option name="2" value="2" <?php if ((isset($_POST["aantal"])) && ($_POST["aantal"] == 2)){ print (" selected");} ?>>2</option>
                            <option name="3" value="3" <?php if ((isset($_POST["aantal"])) && ($_POST["aantal"] == 3)){ print (" selected");} ?>>3</option>
                            <option name="4" value="4" <?php if ((isset($_POST["aantal"])) && ($_POST["aantal"] == 4)){ print (" selected");} ?>>4</option>
                            <option name="5" value="5" <?php if ((isset($_POST["aantal"])) && ($_POST["aantal"] == 5)){ print (" selected");} ?>>5</option>
                            <option name="6" value="6" <?php if ((isset($_POST["aantal"])) && ($_POST["aantal"] == 6)){ print (" selected");} ?>>6</option>
                            <option name="7" value="7" <?php if ((isset($_POST["aantal"])) && ($_POST["aantal"] == 7)){ print (" selected");} ?>>7</option>
                            <option name="8" value="8" <?php if ((isset($_POST["aantal"])) && ($_POST["aantal"] == 8)){ print (" selected");} ?>>8</option>
                            <option name="9" value="9" <?php if ((isset($_POST["aantal"])) && ($_POST["aantal"] == 9)){ print (" selected");} ?>>9</option>
                            <option name="10" value="10" <?php if ((isset($_POST["aantal"])) && ($_POST["aantal"] == 10)){ print (" selected");} ?>>10</option>
                        </select>
                        <input type="submit" name="bijwerkenAantal" value="Bijwerken">
                    </form>
                    <?php
                    //checked welk nummer geselecteerd is en veranderd $aantal naar dat nummer
                    $aantal = 1;
                    if (isset($_POST["aantal"])) {
                        if (($_POST["aantal"]) == 1) {
                            $aantal = 1;
                        }
                        if (($_POST["aantal"]) == 2) {
                            $aantal = 2;
                        }
                        if (($_POST["aantal"]) == 3) {
                            $aantal = 3;
                        }
                        if (($_POST["aantal"]) == 4) {
                            $aantal = 4;
                        }
                        if (($_POST["aantal"]) == 5) {
                            $aantal = 5;
                        }
                        if (($_POST["aantal"]) == 6) {
                            $aantal = 6;
                        }
                        if (($_POST["aantal"]) == 7) {
                            $aantal = 7;
                        }
                        if (($_POST["aantal"]) == 8) {
                            $aantal = 8;
                        }
                        if (($_POST["aantal"]) == 9) {
                            $aantal = 9;
                        }
                        if (($_POST["aantal"]) == 10) {
                            $aantal = 10;
                        }
                    }
                    ?>
                </td>
                    <td class="borderright tableTextRight">
                        <!-- button voor het verwijderen van een product uit de winkelwagen -->
                        <form action="shoppingcart.php" method="get">
                            <input type="submit" name="verwijderProduct" value="Verwijder">
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