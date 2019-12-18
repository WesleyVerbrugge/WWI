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
    <!-- Button trigger modal -->
    <!-- Modal -->
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
                    <form>
                        <div class="form-group">
                            <label>First Name:
                                <input style="" type="text" name="firstname" class="form-control">
                            </label>
                            <label>Preposition:
                                <input style="" type="text" name="preposition" class="form-control">
                            </label>
                            <label>Last Name:
                                <input style="" type="text" name="lastname" class="form-control">
                            </label>
                        </div>
                        <div class="form-group">
                            <label>Country:
                                <input style="" type="text" name="country" class="form-control">
                            </label>
                        </div>
                        <div class="form-group">
                            <label>Country:
                                <input style="" type="text" name="country" class="form-control">
                            </label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
<?php
if(isset($_GET['pcs'])){
    if($_GET['pcs'] == 1){
        echo '<div class="alert alert-success" role="alert">
        Password changed succesfuly!
      </div>';
    }
}
print ("<div>");

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
        if (!empty($resultsUser["Prepositions"])){
            $prepositions = $resultsUser["Prepositions"] . " ";
        } else {
            $prepositions = "";
        }

        print ($firstNameUser . " " . $prepositions . $lastNameUser . "<BR>");
        print ($country . "<BR>");
        print ($adress . " " .  $housenumber . "<BR>");
        print ($postalcode . " " . $city . "<BR>");
        print ($email . "<BR>");
        print ($phone);
    }

?>
<BR><BR>
</div>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Update Account Details</button>
<br>
<br>
<a class="btn btn-primary" href="change-password.php">Change your password</a>
</body>
</html>


