<?php
if(isset($_POST['fname'])) {
    if(isset($_POST['pname'])) {
        if(isset($_POST['email'])) {
            if(isset($_POST['pwd'])) {
                if(isset($_POST['pwd2'])) {
                    $email = $_POST['email'];
                    $pwd = $_POST['pwd'];
                    $fname = $_POST['fname'];
                    $pname = $_POST['pname'];
                    $pwd2 = $_POST['pwd2'];
                    $sname = $fname . $pname;
                    if(!$pwd == $pwd2) {
                        echo "<script type='text/javascript'>alert('De wachtwoorden komen niet overeen');</script>";
                        exit;
                    }
                    $pwd = password_hash($pwd, PASSWORD_DEFAULT);
                    $link = mysqli_connect("localhost", "root", "", "wideworldimporters");
                    if ($link === false) {
                        die("ERROR: Could not connect. " . mysqli_connect_error());
                    }
                    $sql = "INSERT INTO people ('FullName', 'PreferredName', 'SearchName', 'LogonName', 'HashedPassword') VALUES (?, ?, ?, ?, ?)";                
                    if($stmt = mysqli_prepare($link, $sql)){
                        mysqli_stmt_bind_param($stmt, "bbbbb", $fname, $pname, $sname, $email, $pwd);
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