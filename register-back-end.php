<?php
// checked of alle velden zijn ingevuld ipv tussenvoegsel
if(isset($_POST['fname'])) {
    if(isset($_POST['sname'])) {
        if(isset($_POST['email'])) {
            if(isset($_POST['pwd'])) {
                if(isset($_POST['pwd2'])) {
                    if(isset($_POST['adress'])){
                        if(isset($_POST["country"])) {
                            if(isset($_POST["city"])) {
                                if(isset($_POST["housenumber"])) {
                                    if(isset($_POST["postalcode"])) {
                                        // maakt variabelen aan voor alle ingevulde gegevens
                                        $email = $_POST['email'];
                                        $pwd = $_POST['pwd'];
                                        $adress = $_POST['adress'];
                                        $fname = $_POST['fname'];
                                        $sname = $_POST['sname'];
                                        $pwd2 = $_POST['pwd2'];
                                        $country = $_POST["country"];
                                        $city = $_POST["city"];
                                        $housenumber = $_POST["housenumber"];
                                        $postalcode = $_POST["postalcode"];

                                        // checked of de 2 ingevulde wachtwoorden wel met elkaar overeen komen
                                        if (!$pwd == $pwd2) {
                                            echo "password is niet hetzelfde";
                                        }
                                        //hashed het wachtwoord
                                        $pwd = password_hash($pwd, PASSWORD_DEFAULT);
                                        $link = mysqli_connect("localhost", "root", "", "wideworldimporters");
                                        if ($link === false) {
                                            die("ERROR: Could not connect. " . mysqli_connect_error());
                                        }
                                        //checked of er een tussenvoegsel is ingevuld
                                        if (!empty($_POST['bname'])) {
                                            $bname = $_POST['bname'];
                                            //checked of het telefoonnummer is ingevuld
                                            if (!empty($_POST['phone'])) {
                                                $phone = $_POST['phone'];
                                                $sql = "INSERT INTO users (Firstname, Prepositions, LastName, Emailadress, Country, City, Password, Adress, Housenumber, Postalcode, Phone) VALUES ('$fname', '$bname', '$sname', '$email', '$country', '$city', '$pwd', '$adress', '$housenumber', '$postalcode', '$phone')";
                                            } else {
                                                $sql = "INSERT INTO users (Firstname, Prepositions, LastName, Emailadress, Country, City, Password, Adress, Housenumber, Postalcode) VALUES ('$fname', '$bname', '$sname', '$email', '$country', '$city', '$pwd', '$adress', '$housenumber', '$postalcode')";
                                            }
                                        } else {
                                            // checked of telefoonnummer is ingevuld
                                            if (!empty($_POST['phone'])) {
                                                $phone = $_POST['phone'];
                                                $sql = "INSERT INTO users (Firstname, LastName, Emailadress, Country, City, Password, Adress, Housenumber, Postalcode, Phone) VALUES ('$fname', '$sname', '$email', '$country', '$city', '$pwd', '$adress', '$housenumber', '$postalcode', '$phone')";
                                            } else {
                                                $sql = "INSERT INTO users (Firstname, LastName, Emailadress, Country, City, Password, Adress, Housenumber, Postalcode) VALUES ('$fname', '$sname', '$email', '$country', '$city', '$pwd', '$adress', '$housenumber', '$postalcode')";
                                            }
                                        }
                                        if ($stmt = mysqli_prepare($link, $sql)) {
                                            if (mysqli_stmt_execute($stmt)) {
                                                header('Location: login.php?rs=1');
                                            } else {
                                                echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
?>