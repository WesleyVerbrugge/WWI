<?php
session_start();
// wordt gechecked of de ingelogde gebruiker wel een admin is
if(isset($_GET['id'])) {
    if(isset($_GET['item_id'])) {
        if($_SESSION['user_data']['is_admin'] == 0) {
            header('Location: showitem.php?item_id=' . $_GET['item_id']);
        }
        $link = mysqli_connect("localhost", "root", "", "wideworldimporters");
        if ($link === false) {
            die("ERROR: Could not connect. " . mysqli_connect_error());
        }
        $sql = "DELETE FROM reviews WHERE ID LIKE ?";
        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_term);
            $param_term = $_GET['id'];
    
    
            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                header('Location: showitem.php?item_id=' . $_GET['item_id'] . '&rrs=1');
            } else {
                echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
            }
        }
    }
}
?>