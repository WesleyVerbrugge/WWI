<?php
session_start();

$totaalBedrag = 0;

include_once "header.php";
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

<html xmlns="http://www.w3.org/1999/html">

<body>
<div class="container-fluid" style="width: 80%">
<!-- header pagina -->
<h2 class="">Order</h2>
<hr>
<div class="row">
    <div class="columnOrder">


<table>
    <thead>
    <th>Product</th>
    <th class="tableTextRight">Number</th>
    <th class="tableTextRight">Total</th>
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

        $aantal = $_SESSION["winkelwagen"][$i]["quantity"];
    }

    $naam = $row["StockItemName"];
    $prijsPerStuk = $row["RecommendedRetailPrice"];
    $bedrag = $prijsPerStuk * $aantal;

?>

<tr>
    <td><img height="50" width="50" src="images/img1.jpg"><?php print ($naam);?></td>
    <td class="tableTextRight"><?php print ($aantal);?></td>
    <td class="tableTextRight">&euro;<?php print number_format($bedrag, 2);?></td>
</tr>

    <?php
    $totaalBedrag = $totaalBedrag + $bedrag;
}

    mysqli_stmt_close($statement);
    mysqli_free_result($results);

    // verzendkosten check
if ($totaalBedrag < 50){
    $totaalBedrag = $totaalBedrag + 3.95;

    ?>
    <tr>
        <td></td>
        <td class="tableTextRight">Shipping costs:</td>
        <td class="tableTextRight">&euro;3.95</td>
    </tr>


    <?php
} else {
    ?>
    <tr>
        <td></td>
        <td class="tableTextRight">Shipping costs:</td>
        <td class="tableTextRight">&euro;0.00</td>
    </tr>
    <?php
}
?>
    <tr>
        <td></td>
        <td class="tableTextRight">Total cost:</td>
        <td class="tableTextRight">&euro;<?php print number_format($totaalBedrag, 2)?></td>
    </tr>
    </table>
        <button class="margin-left btn btn-warning" href="shoppingcart.php">< Back to shopping cart</button>
        </div>
    <div class="columnOrder">
        <h1>Delivery details</h1>
        <hr>
    <?php
    if (isset($_SESSION["user_data"])) {
        $sqlUserData = "SELECT * FROM users WHERE UserID = ?";
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
        $adress = $resultsUser["Adress"];
        $phone = $resultsUser["Phone"];
        $country = $resultsUser["Country"];
        $housenumber = $resultsUser["Housenumber"];
        $postalcode = $resultsUser["Postalcode"];
        $city = $resultsUser["City"];
        if (!empty($resultsUser["Prepositions"])){
            $prepositions = $resultsUser["Prepositions"] . " ";
        } else {
            $prepositions = "";
        }

        print ($firstNameUser . " " . $prepositions . $lastNameUser . "<BR>");
        print ($country . "<BR>");
        print ($adress . " " .  $housenumber . "<BR>");
        print ($postalcode . " " . $city . "<BR>");
        ?>

        <BR>
        <a href="accountpage.php">Update delivery details</a>

        <?php

    } else {
        print ("You need to login bofore you are able to place an order. <BR><BR>");
        print ("<a href='login.php'>To login page</a>");
    }
    ?>

    </div>

</div>
    <hr width="100%" class="float-left">

    <br>
<!-- start van PayPal en andere betaalmogelijkheden -->
<script
        src="https://www.paypal.com/sdk/js?client-id=AQT1KXLO32aLVif7-yeL_OrFlKFLBfcicZsaF5lWTKSKlS3nMsNGu9MCWWm4LFy06QpusRHp_JfHzgvH"> // Required. Replace SB_CLIENT_ID with your sandbox client ID.
</script>

<div>
    <script
            src="https://www.paypal.com/sdk/js?client-id=SB_CLIENT_ID"> // Required. Replace SB_CLIENT_ID with your sandbox client ID.
    </script>

    <div id="paypal-button-container"></div>
<input type="text" hidden id="totalprice" value="<?php print($totaalBedrag); ?>">
    <script>
        // vult het te betalen bedrag in als te betalen bedrag
        var totalprice = document.getElementById("totalprice").value;
        paypal.Buttons({
            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: totalprice
                        }
                    }]
                });
            },
            onApprove: function(data, actions) {
                return actions.order.capture().then(function(details) {
                    window.location.href = "orders.php?oc=1";
                    return fetch('/paypal-transaction-complete', {
                        method: 'post',
                        headers: {
                            'content-type': 'application/json'
                        },
                        body: JSON.stringify({
                            orderID: data.orderID
                        })
                    });
                });
            }
        }).render('#paypal-button-container');
    </script>

</div>
</div>
</body>
</html>