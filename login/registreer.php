<?php
require_once "functions.php";

try {
    $host = "127.0.0.1";
    $databasename = "wideworldimporters";
    $user = "root";
    $pass = "";
    $port = 3306;
    $connection = mysqli_connect($host, $user, $pass, $databasename, $port);


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
function check_given_value_name($name){

    if ((isset($_POST[$name]) && !empty($_POST[$name]) && isset($_POST["submit"]))) {
        $maxlengte = 50;
        //gebruik textoutput na de volgende ifstatement
        $textoutput = trim($_POST[$name]);
        $textoutput = stripslashes($textoutput);
        if (strlen($textoutput) <= $maxlengte){
            //todo do something
        } else {
            print ("Je " . $name . " mag maar maximaal " . $maxlengte . " tekens lang zijn.<br>");
        }
    } else {
        print ("Je moet verplicht een " . $name . " invoeren. <br>");
    }

}

function check_given_value_achtername($name){

    if ((isset($_POST[$name]) && !empty($_POST[$name]) && isset($_POST["submit"]))) {
        $maxlengte = 50;
        $tussenvoegsel = "";
        if (isset($_POST["tussenvoegsel"]) && !empty($_POST["tussenvoegsel"])){
            $tussenvoegsel = $_POST["tussenvoegsel"];
        }
        //gebruik textoutput na de volgende ifstatement
        $achternaam = $_POST[$name];
        $achternaam = $tussenvoegsel . " " . $achternaam;
        $textoutput = trim($achternaam);
        $textoutput = stripslashes($textoutput);
        if (strlen($textoutput) <= $maxlengte){
            //todo do something
        } else {
            print ("Je " . $name . " mag maar maximaal " . $maxlengte . " tekens lang zijn.<br>");
        }
    } else {
        print ("Je moet verplicht een " . $name . " invoeren. <br>");
    }

}

function check_given_value_email($email){

    if ((isset($_POST[$email]) && !empty($_POST[$email]) && isset($_POST["submit"]))) {
        $maxlengte = 256;
        //gebruik textoutput na de volgende ifstatement
        $textoutput = trim($_POST[$email]);
        $textoutput = stripslashes($textoutput);
        if (strlen($textoutput) <= $maxlengte){
            if (filter_var($textoutput, FILTER_VALIDATE_EMAIL)){
            //todo do something
            } else {
                print ("Het opgegeven email is niet geldig.<br>");
            }
        } else {
            print ("Je " . $email . " adres mag maar maximaal " . $maxlengte . " tekens lang zijn.<br>");
        }
    } else {
        print ("Je moet verplicht een " . $email . " invoeren.<br>");
    }

}

function check_password($wachtwoord, $wachtwoord2){

    if (isset($_POST[$wachtwoord]) && !empty($_POST[$wachtwoord])){
        if (isset($_POST[$wachtwoord2]) && !empty($_POST[$wachtwoord2])){

        } else {
            print ("Je moet verplicht een tweede wachtoord invoeren.");
        }
    } else {
        print ("Je moet verplicht een wachtoord invoeren.");
    }
}

//validation codes
check_given_value_name("voornaam");
check_given_value_achtername("achternaam");
check_given_value_email("email");
check_password("wachtwoord", "wachtwoord2");


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
    </div>
    <input type="submit" name="submit" value="verzonden">
</form>


<pre>
<?php


mysqli_close($connection);

?>
</pre>

</body>
</html>