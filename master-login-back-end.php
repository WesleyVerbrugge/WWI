<?php
session_start();
if(isset($_SESSION['user_data'])) {
    if($_SESSION['user_data']['is_admin'] == 1){
        header('Location: index.php?mls=1');
    } else {
        header('Location: index.php?mls=2');
    }
}
if(isset($_POST['Email'])) {
    if(isset($_POST['Password'])) {
        $email = $_POST['Email'];
        $pwd = $_POST['Password'];
        $link = mysqli_connect("localhost", "root", "", "wideworldimporters");
        if ($link === false) {
            die("ERROR: Could not connect. " . mysqli_connect_error());
        }
        $sql = "SELECT * FROM users WHERE Emailadress LIKE ?";
        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_term);
            $param_term = $email;
    
    
            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);
                // Check number of rows in the result set
                if (mysqli_num_rows($result) > 0) {
                    // Fetch result rows as an associative array
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    // echo(password_hash($pwd, PASSWORD_BCRYPT));
                    // exit;
                    if(password_verify($pwd, $row['Password'])) {
                        $message = "login succesful!";  
                        echo "<script type='text/javascript'>alert('$message');</script>";
                        session_start();
                        $_SESSION['user_data'] = $row;
                        $newURL = "/index.php";
                        if($row['is_admin'] == 1){
                            header("Location: index.php?mls=1");
                        } else {
                            header("Location: index.php?mls=2");
                        }
                    } else {
                        echo "<div class='alert alert-primary' role='alert'>
                        <a href='#' class='alert-link'>Wrong Password</a>
                        </div>";
                    }
                } else {
                    echo "<p>No matches found</p>";
                }
            } else {
                echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
            }
        }
    }
}
?>