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

    <!-- <div class="columnAccount"> -->

<?php
if(isset($_GET['pcs'])){
    if($_GET['pcs'] == 1){
        echo '<div class="alert alert-success" role="alert">
        Password changed succesfuly!
      </div>';
    }
}
    if (isset($_SESSION["user_data"])) {
        $sqlUserData = "SELECT * FROM users WHERE UserID = ?";
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
        $country = $resultsUser["Country"];
        $housenumber = $resultsUser["Housenumber"];
        $postalcode = $resultsUser["Postalcode"];
        $city = $resultsUser["City"];

        print ($firstNameUser . " " . $lastNameUser . "<BR>");
        print ($country . "<BR>");
        print ($adress . " " .  $housenumber . "<BR>");
        print ($postalcode . " " . $city . "<BR>");
        print ($email . "<BR>");
        print ($phone);
    }
?>
<br>
<br>
<!-- </div> -->
<div class="jumbotron">
<h2>Change your password</h2>
<hr>
<form action="resetpassword.php" method="post">
    <div class="form-group">
        <label for="oldp">Old password</label>
        <input class="form-control" type="password" name="oldp" id="oldp">
    </div>
    <div class="form-group">
        <label for="newp1">New password</label>
        <input class="form-control" type="password" name="newp1" id="newp1">
    </div>
    <div class="form-group">
        <label for="newp2">Confirm new password</label>
        <input class="form-control" type="password" name="newp2" id="newp2">
    </div>
    <button class="btn btn-warning" type="submit">Change my password</button>
</form>
</div>
</div>
</body>
</html>
