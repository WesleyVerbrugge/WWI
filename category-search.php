<?php
$result_array = array();
$link = mysqli_connect("localhost", "root", "", "wideworldimporters");
try {
    $aantalproducten = NULL;
    $sql_aantalproducten = "select distinct count(StockItemID) as items_count from stockitems where StockItemID is not null";

    $result_aantalproducten = mysqli_query($link, $sql_aantalproducten);
    if ($row_aantalproducten = mysqli_fetch_array($result_aantalproducten, MYSQLI_ASSOC)) {
        $aantalproducten = $row_aantalproducten["items_count"];
    }

} catch (mysqli_sql_exception $e) {
    echo "Could not count the products $e";
}

// maakt een variabele die de aangeklikt catergorie zo maakt dat het gebruikt kan worden in de database
$category = '%' . $_POST['category'] . '%';
$azr = $_POST['azr'];
// checked of er een zoekopdracht is meegegeven vanuit de zoekbalk
if(isset($_POST['term'])){
    $term = '%' . $_POST['term'] . '%';
}

// checked of $category is gemaakt
if(!empty($category)) {
    if(!empty($term)){
    $link = mysqli_connect("localhost", "root", "", "wideworldimporters");
    $sql = "SELECT * FROM stockgroups s
    JOIN stockitemstockgroups g ON s.StockGroupID=g.StockGroupID 
    JOIN stockitems i ON g.StockItemID=i.StockItemID
    JOIN stockitemholdings h ON i.StockItemID=h.StockItemID WHERE s.StockGroupName LIKE ? AND i.StockItemName LIKE ?";
    } else {
    $sql = "SELECT * FROM stockgroups s
    JOIN stockitemstockgroups g ON s.StockGroupID=g.StockGroupID 
    JOIN stockitems i ON g.StockItemID=i.StockItemID
    JOIN stockitemholdings h ON i.StockItemID=h.StockItemID WHERE s.StockGroupName LIKE ?";
}
    if ((!empty($_POST["term"])) && is_numeric($_POST["term"])){
        $sql = "SELECT * FROM stockgroups s
    JOIN stockitemstockgroups g ON s.StockGroupID=g.StockGroupID 
    JOIN stockitems i ON g.StockItemID=i.StockItemID
    JOIN stockitemholdings h ON i.StockItemID=h.StockItemID WHERE s.StockGroupName LIKE ? AND i.StockItemID LIKE ?";
    }
}
// Check connection
if ($link === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
if ($stmt = mysqli_prepare($link, $sql)) {
    if(isset($_POST['term'])){
        if (is_numeric($_POST["term"])){
            $term = $_POST["term"];
        } else {
        $term = '%' . $_POST['term'] . '%';
        }
    }
    $category = '%' . $_POST['category'] . '%';
    // Bind variables to the prepared statement as parameters
    if(!empty($category)) {
    if(!empty($term)){
        mysqli_stmt_bind_param($stmt, "ss", $category, $term);
    } else {
        mysqli_stmt_bind_param($stmt, "s", $category);
    }     
    }
    


    // Attempt to execute the prepared statement
    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);
        // Check number of rows in the result set
        if (mysqli_num_rows($result) > 0) {
            if (isset($azr)) {
                $i = 1;
                if ($azr == "max" || $azr > $aantalproducten || $azr < 1) {
                    $azr = $aantalproducten;
                }
                if(isset($result)) {
                    foreach ($result as $rc) {
                        if($i <= $azr) {
                            echo "<div class='card producten' id='producten'>";
                            if(empty($rc['image'])) {
                                echo "<img src='images/img1.jpg' class='card-img-top' alt='Product Image'>";
                            } else {
                                echo "<img src='" . $rc['image'] . "' class='card-img-top' alt='Product Image'>";
                            }
                            echo "<div class='card-body card-body-text row' id='card-body'>";
                            echo "<h5 class='card-title'>" . $rc['StockItemName'] . "</h5>";
                            echo "<div class='card-tekst'><p class='card-text'>" . $rc['MarketingComments'] . "</p></div>";
                            echo '<div><a href="showitem.php?item_id=' . $rc["StockItemID"] . '" class="btn btn-primary koop-knop">Bekijk Product</a>';
                            echo "<div class='product-price'>&#8364;&nbsp;" . $rc['RecommendedRetailPrice'] . "</div>";
                            echo "</div>";
                            echo "</div>";
                            echo "</div>";
                            $i++;
                        }
                    }
                }
            }
        } else {
            echo "<p>No matches found</p>";
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
    }
}
