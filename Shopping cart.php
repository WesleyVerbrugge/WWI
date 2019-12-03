<?php
session_start();

$eindtotaal = 0;

include "header.php";
include "dbconnection.php";
$connection = mysqli_connect("localhost", "root", "", "wideworldimporters", 3306);

?>

<html>

<head>
    <title>Winkelwagen</title>
    <link rel="stylesheet" href="style.css">
</head>

<h2 class="margin-left">Winkelwagen</h2>

<table class="shoppingcarttable">
    <thead>
        <th>Product</th>
        <th>Prijs Per Stuk</th>
        <th>Aantal</th>
        <th>Totaal</th>
    </thead>
    <?php
$sql = "SELECT * FROM stockitems left JOIN stockitemholdings ON stockitems.StockItemID = stockitemholdings.StockItemID left JOIN images_stockitems ON images_stockitems.StockItemID = stockitems.StockItemID WHERE stockitems.StockItemID = ?";
$statement = mysqli_prepare($connection, $sql);

for ($i = 0; $i < (count($_SESSION["winkelwagen"])); $i++) {

    $value = $_SESSION["winkelwagen"][$i];

    mysqli_stmt_bind_param($statement, "i", $value);
    mysqli_stmt_execute($statement);
    $results = mysqli_stmt_get_result($statement);
    $row = mysqli_fetch_array($results);

    ?>


    <?php

        $ItemID = $row["StockItemID"];
        $naam = $row["StockItemName"];
        $prijs = $row["RecommendedRetailPrice"];
        ?>
        <tr>
            <td class="column1Shoppincart borderright"><img height="75" width="75" src="placeholder.png"><?php print ($naam) ?></td>
            <a class="column2Shoppingcart">
            <td class="borderright tableTextRight">&#8364;<?php print (str_replace('.', ',', $prijs)) ?></td>
                <td class="borderright tableTextRight">
                    <form action="Shopping%20cart.php" method="get">
                        <select>
                            <option name="aantal" value="1">1</option>
                            <option name="aantal" value="2">2</option>
                            <option name="aantal3" value="3">3</option>
                            <option name="aantal4" value="4">4</option>
                            <option name="aantal5" value="5">5</option>
                            <option name="aantal6" value="6">6</option>
                            <option name="aantal7" value="7">7</option>
                            <option name="aantal8" value="8">8</option>
                            <option name="aantal9" value="9">9</option>
                            <option name="aantal10" value="10">10</option>
                        </select>
                    </form>
                    <?php
                    $aantal = 1;

                    if (isset($_GET["1"]) == 1){
                        $aantal = 1;
                    }
                    if (isset($_GET["2"]) == 2){
                        $aantal = 2;
                    }


                    print ($aantal);
                    ?>
                </td>
            <td class="tableTextRight">&#8364;<?php
                $totaal = $prijs * $aantal;
                $eindtotaal = $eindtotaal + $totaal;
                print (str_replace('.', ',', $totaal));
                ?></td>
            </a>
        </tr>

        <?php
    }
?>
    <tr>
        <td></td>
        <td></td>
        <td class="borderright tableTextRight">Totaal bedrag:</td>
        <td class="totaalbedrag tableTextRight">&#8364;<?php print (str_replace('.', ',', $eindtotaal)); ?></td>
    </tr>
</table>

<input type="submit" name="LeegCart" value="leeg winkelmandje">

</html>