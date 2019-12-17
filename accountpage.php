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
    <title>Account pagina</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
<!-- header pagina -->
<h2 class="margin-left">Account pagina</h2>

    <!-- <div class="columnAccount"> -->

<?php
    if (isset($_SESSION["user_data"])) {
        $sqlUserData = "SELECT * FROM users LEFT JOIN addressdata ON addressdata.UserID = users.UserID WHERE users.UserID = ?";
    //$sqlUserData = "SELECT * FROM user_adress WHERE user_id = ?";
        $statementUserData = mysqli_prepare($connection, $sqlUserData);

        if (!$statementUserData) {
            die("mysqli error: " . mysqli_error($connection));
        }
        $valueUser = $_SESSION["UserID"][0];

    //vult het itemID in bij de sql query
        mysqli_stmt_bind_param($statementUserData, "i", $valueUser);
        if (!mysqli_stmt_execute($statementUserData)) {
            die('stmt error: ' . mysqli_stmt_error($statementUserData));
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

        print ($firstNameUser . " " . $lastNameUser . "<BR>");
        print ($adress . "<BR>");
        print ($email . "<BR>");
        print ($phone);
    }
?>
<!-- </div> -->
</div>
</body>
</html>
