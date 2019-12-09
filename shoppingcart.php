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
                    <?php 
                    foreach($_SESSION['winkelwagen'] as $item) {
                        if($item['item_id'] == $row['StockItemID']){
                            echo $item['quantity'];
                            $aantal = $item['quantity'];
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