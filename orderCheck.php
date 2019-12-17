<?php
session_start();

$totaalBedrag = 0;

include "header.php";
include "dbconnection.php";
// database connectie
try {
    $connection = mysqli_connect("localhost", "root", "", "wideworldimporters", 3306);
} catch (mysqli_sql_exception $e){
    print ("Geen verbinding gemaakt <BR>");
    print ($e);
}
$sql = "SELECT * FROM stockitems left JOIN stockitemholdings ON stockitems.StockItemID = stockitemholdings.StockItemID left JOIN images_stockitems ON images_stockitems.StockItemID = stockitems.StockItemID WHERE stockitems.StockItemID = ?";
$statement = mysqli_prepare($connection, $sql);

?>

<html>

<head>
    <title>Bestelling</title>
    <link rel="stylesheet" href="style.css">
</head>

<!-- header pagina -->
<h2 class="margin-left">Bestelling</h2>

<div class="row">
    <div class="columnOrder">


<table>
    <thead>
    <th>Naam</th>
    <th class="tableTextRight">Aantal</th>
    <th class="tableTextRight">Bedrag</th>
    </thead>

<?php
// for loop die elke rij voor een toegevoegd product print
for ($i = 0; $i < (count($_SESSION["winkelwagen"])); $i++) {

    // pakt steeds het volgende nummer uit de winkelwagen array. Deze array bestaat uit de default key's en de value is het itemID.
    $value = $_SESSION["winkelwagen"][$i]['item_id'];

    //vult het itemID in bij de sql query
    mysqli_stmt_bind_param($statement, "i", $value);
    mysqli_stmt_execute($statement);
    $results = mysqli_stmt_get_result($statement);
    //met $row kun je nu de item informatie ophalen
    $row = mysqli_fetch_array($results);

    foreach($_SESSION['winkelwagen'] as $item) {

        $aantal = $item['quantity'];
    }

    $naam = $row["StockItemName"];
    $prijsPerStuk = $row["RecommendedRetailPrice"];
    $bedrag = $prijsPerStuk * $aantal;

?>

<tr>
    <td><img height="50" width="50" src="images/img1.jpg"><?php print ($naam);?></td>
    <td class="tableTextRight"><?php print ($aantal);?></td>
    <td class="tableTextRight">&euro;<?php print (str_replace('.', ',', $bedrag));?></td>
</tr>

    <?php
    $totaalBedrag = $totaalBedrag + $bedrag;
}

    mysqli_stmt_close($statement);
    mysqli_free_result($results);

if ($totaalBedrag < 50){
    $totaalBedrag = $totaalBedrag + 3.95;

    ?>
    <tr>
        <td></td>
        <td class="tableTextRight">Verzend kosten:</td>
        <td class="tableTextRight">&euro;3,95</td>
    </tr>


    <?php
} else {
    ?>
    <tr>
        <td></td>
        <td class="tableTextRight">Verzend kosten:</td>
        <td class="tableTextRight">&euro;0,00</td>
    </tr>
    <?php
}
?>
    <tr>
        <td></td>
        <td class="tableTextRight">Totaal Bedrag:</td>
        <td class="tableTextRight">&euro;<?php print (str_replace('.', ',',$totaalBedrag))?></td>
    </tr>
    </table>
        </div>

    <div class="columnOrder">

    <?php
    if (isset($_SESSION["user_data"])) {
        $sqlUserData = "SELECT * FROM users LEFT JOIN addressdata ON addressdata.UserID = users.UserID WHERE users.UserID = ?";
        //$sqlUserData = "SELECT * FROM user_adress WHERE user_id = ?";
        $statementUserData = mysqli_prepare($connection, $sqlUserData);

        if (!$statementUserData){
            die("mysqli error: " . mysqli_error($connection));
        }
        $valueUser = $_SESSION["UserID"][0];

        //vult het itemID in bij de sql query
        mysqli_stmt_bind_param($statementUserData, "i", $valueUser);
        if ( !mysqli_stmt_execute($statementUserData) ) {
            die( 'stmt error: '.mysqli_stmt_error($statementUserData) );
        }

        mysqli_stmt_execute($statementUserData);
        $resultsUserdata = mysqli_stmt_get_result($statementUserData);
        //met $row kun je nu de item informatie ophalen
        $resultsUser = mysqli_fetch_array($resultsUserdata);

        $firstNameUser = $resultsUser["Firstname"];
        $lastNameUser = $resultsUser["LastName"];
        $email = $resultsUser["Emailadress"];
        $country = $resultsUser["CountryName"];
        $city = $resultsUser["CityName"];
        $street = $resultsUser["StreetName"];
        $housenumber = $resultsUser["HouseNumber"];
        $postalcode = $resultsUser["PostalCode"];
        $phone = $resultsUser["PhoneNumber"];

        print ($firstNameUser . " " . $lastNameUser . "<BR>");
        print ($street . " " . $housenumber . " " . $city . " " . $country . " " . $postalcode . "<BR>");
        print ($email . "<BR>");
        print ($phone);


    } else {
        print ("You need to login bofore you are able to place an order. <BR><BR>");
        print ("<a href='login.php'>To login page</a>");
    }

    ?>
    </div>
</div>

</html>