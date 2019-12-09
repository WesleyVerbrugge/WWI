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
<?php
if (isset($_GET["LeegCart"])){
    $_SESSION["winkelwagen"] = NULL;
}
?>
    <?php
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
        <th>Totaal</th>
    </thead>
    <?php
$sql = "SELECT * FROM stockitems left JOIN stockitemholdings ON stockitems.StockItemID = stockitemholdings.StockItemID left JOIN images_stockitems ON images_stockitems.StockItemID = stockitems.StockItemID WHERE stockitems.StockItemID = ?";
$statement = mysqli_prepare($connection, $sql);
var_dump($_SESSION['winkelwagen']);
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
            <td class="column1Shoppincart borderright"><img height="75" width="75" src="images/img1.jpg"><?php print ($naam) ?></td>
            <a class="column2Shoppingcart">
            <td class="borderright tableTextRight">&#8364;<?php print (str_replace('.', ',', $prijs)) ?></td>
                <td class="borderright tableTextRight">
                    <form action="Shopping%20cart.php" method="post">
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
<p>
    <form class="margin-left" action="Shopping%20cart.php" method="get">
        <input type="submit" name="LeegCart" value="leeg winkelmandje">
    </form>
</p>


<?php

}
?>

</html>