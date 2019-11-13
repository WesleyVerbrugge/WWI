<?php
include "functions.php";

try {
    $host = "127.0.0.1";
    $databasename = "wideworldimporters";
    $user = "root";
    $pass ="";
    $port = 3306;
    $connection = mysqli_connect($host, $user, $pass, $databasename, $port);

    $result = mysqli_query($connection, "SELECT countryname FROM countries");


} catch (Exception $e) {
    print ("An error has occurred");
}



?>

<!doctype html>
<html lang="en">
<head>

    <link rel="stylesheet" type="text/css" href="main.css">
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

<?php

?>

<form method="post">
    <div class="input-text">
        <div>
            <label>Voornaam:
                <input type="text" name="voornaam" <?php isset_value("voornaam"); ?> required>*
            </label><br>
        </div>
        <div>
            <label>Tussenvoegsel:
                <input type="text" name="tussenvoegsel" <?php isset_value("tussenvoegsel"); ?>>
            </label><br>
        </div>
        <div>
            <label>Achternaam:
                <input type="text" name="achternaam" <?php isset_value("achternaam"); ?> required>*
            </label><br>
        </div>
        <div>
            <label>Email:
                <input type="email" name="email" <?php isset_value("email"); ?> required>*
            </label><br>
        </div>
        <div>
            <label>Wachtwoord:
                <input type="password" name="wachtwoord" required>*
            </label><br>
        </div>
        <div>
            <label>Hertyp Wachtwoord:
                <input type="password" name="wachtwoord2" required>*
            </label><br>
        </div>
        <div>
            <label>Telefoonnummer:
                <input type="tel" name="telefoonnummer" <?php isset_value("telefoonnummer"); ?> required>*
            </label><br>
        </div>
        <br>
        <div>
            <label>Land:
                <select name="land">
                    <?php

                    if (isset($_POST["land"])){
                        $givencountry = $_POST["land"];
                    }

                    $landenarray = array();

                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                        $country = $row["countryname"];
                        $landenarray[] = $row["countryname"];

                        $selectedcountry = "";

                        if (in_array($givencountry,$landenarray)){
                            if ($row["countryname"] == $givencountry){
                                $selectedcountry = "selected";
                            }
                        }
                        echo ("<option value='" . $country . "' " . $selectedcountry . ">" . $country . "</option>");
                    }

                    ?>
                </select>
            </label><br>
        </div>
        <div>
            <label>Woonplaats:
                <input type="text" name="woonplaats" <?php isset_value("woonplaats"); ?> required>*
            </label><br>
        </div>
        <div>
            <label> Straatnaam:
                <input type="text" name="adress" <?php isset_value("adress"); ?> required>*
            </label>
        </div>
        <div>
            <label> Nummer:
                <input type="number" name="straatnummer" <?php isset_value("straatnummer"); ?> required>*
            </label><br>
        </div>
        <div>
            <label> Secundair Straatnaam:
                <input type="text" name="adress2" <?php isset_value("adress2"); ?>>
            </label>
        </div>
        <div>
            <label> Nummer:
                <input type="number" name="straatnummer2" <?php isset_value("straatnummer2"); ?>>
            </label><br>
        </div>
        <div>
            <label>Postcode:
                <input type="text" name="postcode" <?php isset_value("postcode"); ?> required>*
            </label><br>
        </div>
    </div>

    <input type="submit">
</form>


<?php


mysqli_close($connection);

?>


</body>
</html>