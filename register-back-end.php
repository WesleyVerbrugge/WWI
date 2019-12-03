<?php
if(isset($_POST['fname'])) {
    if(isset($_POST['sname'])) {
        if(isset($_POST['email'])) {
            if(isset($_POST['pwd'])) {
                if(isset($_POST['pwd2'])) {
                    $email = $_POST['email'];
                    $pwd = $_POST['pwd'];
                    
                    $fname = $_POST['fname'];
                    $sname = $_POST['sname'];
                    $pwd2 = $_POST['pwd2'];
                    echo $email . " " . $pwd . ' ' . $fname . ' ' . $sname; 
                    if(!$pwd == $pwd2) {
                        echo "password is niet hetzelfde";
                    }
                    $pwd = password_hash($pwd, PASSWORD_DEFAULT);
                    $link = mysqli_connect("localhost", "root", "", "wideworldimporters");
                    if ($link === false) {
                        die("ERROR: Could not connect. " . mysqli_connect_error());
                    }
                    if(!empty($_POST['bname'])) {
                        $bname = $_POST['bname'];
                        $sql = "INSERT INTO users (Firstname, Prepositions, LastName, Emailadress, Password) VALUES ('test', ?, ?, ?, ?)";
                    } else {
                        $sql = "INSERT INTO users (Firstname, LastName, Emailadress, Password) VALUES ('$fname', '$sname', '$email', '$pwd')";
                    }
                    if($stmt = mysqli_prepare($link, $sql)){
                        if (mysqli_stmt_execute($stmt)) {
                            echo "good";
                        } else {
                            echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                        }
                    }

                }
            }
        }
    }
}
?>