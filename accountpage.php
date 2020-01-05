<?php
session_start();

include "header.php";
include "dbconnection.php";

// database connectie
try {
    $connection = mysqli_connect("localhost", "root", "", "wideworldimporters", 3306);
} catch (mysqli_sql_exception $e){
    print ("Geen verbinding gemaakt <BR>");
    print ($e);
}
?>

<html>

<head>
    <title>Account page</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
<!-- header pagina -->
<h2>Account page</h2>
<hr>



<?php
// controleerd of het wachtwoord zojuist geweizigd is en geeft dan een melding
if(isset($_GET['pcs'])){
    if($_GET['pcs'] == 1){
        echo '<div class="alert alert-success" role="alert">
        Password changed succesfuly!
      </div>';
    }
}
print ("<div>");

    // controleerd of $_SESSION["user_data"] is geset. Deze wordt gevuld als er correct is ingelogd.
    if (isset($_SESSION["user_data"])) {
        //sql query voor ophalen gegevens
        $sqlUserData = "SELECT * FROM users WHERE UserID = ?";
        $statementUserData = mysqli_prepare($connection, $sqlUserData);

        // als er geen connectie plaats kan vinden met de database pakt de 'die' de error op.
        if (!$statementUserData) {
            die("mysqli error: " . mysqli_error($connection));
        }
        // variable voor de array met op de plaats waar de key 0 is (de eerste in een array). bij deze key hoordt het userid waarmee de data van de user uit de database kan worden gehaald.
        $valueUser = $_SESSION["UserID"][0];

    //vult het itemID in bij de sql query
        mysqli_stmt_bind_param($statementUserData, "i", $valueUser);
        // als de statement hierboven niet kan worden uitgevoerd wordt de error opgevangen door de die
        if (!mysqli_stmt_execute($statementUserData)) {
            die('stmt error: ' . mysqli_stmt_error($statementUserData));
        }

        mysqli_stmt_execute($statementUserData);
        $resultsUserdata = mysqli_stmt_get_result($statementUserData);
    //met $row kun je nu de item informatie ophalen
        $resultsUser = mysqli_fetch_array($resultsUserdata);

        // variabelen voor data van de ingelogde user. deze data komt uit de database
        $firstNameUser = $resultsUser["Firstname"];
        $lastNameUser = $resultsUser["LastName"];
        $email = $resultsUser["Emailadress"];
        $adress = $resultsUser["Adress"];
        $phone = $resultsUser["Phone"];
        $country = $resultsUser["Country"];
        $housenumber = $resultsUser["Housenumber"];
        $postalcode = $resultsUser["Postalcode"];
        $city = $resultsUser["City"];
        // kijkt of er bij het registreren een tussenvoegsel is ingevuld. als dat het geval is wordt deze weergegeven.
        if (!empty($resultsUser["Prepositions"])){
            $prepositions = $resultsUser["Prepositions"] . " ";
        } else {
            // is er niks ingevuld bij het tussenvoegsel dan is het een lege string dat wordt weergegeven. Dit zie je uiteraard niet op de pagina.
            $prepositions = "";
        }

        // het printen van alle bovenstaande variabelen
        print ($firstNameUser . " " . $prepositions . $lastNameUser . "<BR>");
        print ($country . "<BR>");
        print ($adress . " " .  $housenumber . "<BR>");
        print ($postalcode . " " . $city . "<BR>");
        print ($email . "<BR>");
        print ($phone);
    }

    // voor updaten
    if (isset($_GET["Submit-changes"])) {
        $firstNameUserUpdate = $_GET["firstname"];
        $prepositionsUpdate = $_GET["prepositions"];
        $lastNameUserUpdate = $_GET["lastname"];
        $emailUpdate = $_GET["emailadress"];
        $adressUpdate = $_GET["street"];
        $phoneUpdate = $_GET["phone"];
        $countryUpdate = $_GET["country"];
        $housenumberUpdate = $_GET["housenumber"];
        $postalcodeUpdate = $_GET["postalcode"];
        $cityUpdate = $_GET["city"];

        //update sql query
        $sqlUpdate = "UPDATE users SET Firstname = '$firstNameUserUpdate', Prepositions = '$prepositionsUpdate', LastName = '$lastNameUserUpdate', Emailadress = '$emailUpdate', Country = '$countryUpdate', City = '$cityUpdate', Adress = '$adressUpdate', Housenumber = '$housenumberUpdate', Postalcode = '$postalcodeUpdate', Phone = '$phoneUpdate' WHERE UserID = '$valueUser' ";
        $statementUpdate = mysqli_prepare($connection, $sqlUpdate);

        // checked of de update query kan worden uitgevoerd of niet. zo niet vangt 'die' de error op
        if (!mysqli_stmt_execute($statementUpdate)) {
            die('stmt error: ' . mysqli_stmt_error($statementUpdate));
        }

        mysqli_stmt_execute($statementUpdate);
    }


?>

       <!-- het update scherm met de bekende gegevens. deze bekende gegevens worden ingevuld in de input velden -->
        <div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="accountpage.php">
                            <div class="form-group">
                                <label>First Name:
                                    <input style="" type="text" name="firstname" class="form-control" value="<?php print ($firstNameUser);?>">
                                </label>
                                <label>Preposition:
                                    <input style="" type="text" name="prepositions" class="form-control" value="<?php print ($prepositions);?>">
                                </label>
                                <label>Last Name:
                                    <input style="" type="text" name="lastname" class="form-control" value="<?php print ($lastNameUser);?>">
                                </label>
                            </div>
                            <div class="form-group">
                                <label>Country:
                                    <input style="" type="text" name="country" class="form-control" value="<?php print ($country);?>">
                                </label>
                            </div>
                            <div class="form-group">
                                <label>Street:
                                    <input style="" type="text" name="street" class="form-control" value="<?php print ($adress);?>">
                                </label>
                                <label>Housenumber:
                                    <input style="" type="text" name="housenumber" class="form-control" value="<?php print ($housenumber);?>">
                                </label>
                            </div>
                            <div class="form-group">
                                <label>Postalcode:
                                    <input style="" type="text" name="postalcode" class="form-control" value="<?php print ($postalcode);?>">
                                </label>
                                <label>City:
                                    <input style="" type="text" name="city" class="form-control" value="<?php print ($city);?>">
                                </label>
                            </div>
                            <div class="form-group">
                                <label>Email:
                                    <input style="" type="text" name="emailadress" class="form-control" value="<?php print ($email);?>">
                                </label>
                            </div>
                            <div class="form-group">
                                <label>Phone:
                                    <input style="" type="text" name="phone" class="form-control" value="<?php print ($phone);?>">
                                </label>
                            </div>
                    </div>
                    <!-- buttons om je wijzigingen op te slaan of uit het scherm te gaan. -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="Submit-changes">Save changes</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
<BR><BR>
    <!-- knoppen voor het update gegevens scherm, je bestellingen en naar het wachtwoord wijzigen scherm. -->
</div>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Update Account Details</button>
<a class="btn btn-secondary" href="orders.php" style="margin-left: 3rem">Your orders</a>
<br>
<br>
<a class="btn btn-primary" href="change-password.php">Change your password</a>



<?php
// checked of de gebruiker is ingelogd
 if (isset($_SESSION["user_data"])){
     //checked of de user een admin is
     if ($_SESSION["user_data"]["is_admin"] == 1){
         echo "<a class=\"btn btn-secondary\" href=\"ReturnedOrders.php\" style=\"margin-left: 3rem\">Returned Orders</a>";
     }
 }

    ?>

</body>
</html>


