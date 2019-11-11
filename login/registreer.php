<?php
include "functions.php";
?>

<!doctype html>
<html lang="en">
<head>
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
    <div>
        <label>Voornaam:
            <input type="text" name="voornaam" <?php isset_value("voornaam"); ?> required>*
        </label><br>
        <label>Tussenvoegsel:
            <input type="text" name="tussenvoegsel" <?php isset_value("tussenvoegsel"); ?>>
        </label><br>
        <label>Achternaam:
            <input type="text" name="achternaam" <?php isset_value("achternaam"); ?> required>*
        </label><br>
        <label>Email:
            <input type="email" name="email" <?php isset_value("email"); ?> required autocomplete="email">*
        </label><br>
        <label>Wachtwoord:
            <input type="password" name="wachtwoord" <?php isset_value("wachtwoord"); ?> required>*
        </label><br>
        <label>Hertyp Wachtwoord:
            <input type="password" name="wachtwoord2" <?php isset_value("wachtwoord2"); ?> required>*
        </label><br>
        <label>Telefoonnummer:
            <input type="tel" name="telefoonnummer" <?php isset_value("telefoonnummer"); ?> required>*
        </label><br>
        <br>
        <label>Land:
            <input type="text" name="land" <?php isset_value("land"); ?> required>*
        </label><br>
        <label>Woonplaats:
            <input type="text" name="woonplaats" <?php isset_value("woonplaats"); ?> required>*
        </label><br>
        <label> Straatnaam:
            <input type="text" name="adress" <?php isset_value("adress"); ?> required>*
        </label>
        <label> Nummer:
            <input type="number" name="straatnummer" <?php isset_value("straatnummer"); ?> required>*
        </label><br>
        <label> Secundair Straatnaam:
            <input type="text" name="adress2" <?php isset_value("adress2"); ?>>
        </label>
        <label> Nummer:
            <input type="number" name="straatnummer2" <?php isset_value("straatnummer2"); ?>>
        </label><br>
        <label>Postcode:
            <input type="text" name="postcode" <?php isset_value("postcode"); ?> required>*
        </label><br>
    </div>

    <input type="submit">
</form>


<?php

?>


</body>
</html>