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

$category = '%' . $_POST['category'] . '%';
$azr = $_POST['azr'];
if(isset($_POST['term'])){
    $term = '%' . $_POST['term'] . '%';
}
$sql;
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
}
// Check connection
if ($link === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
if ($stmt = mysqli_prepare($link, $sql)) {
    if(isset($_POST['term'])){
        $term = '%' . $_POST['term'] . '%';
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
            // Fetch result rows as an associative array
            // $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            // while($row = $result->fetch_assoc()){
            //     array_push($result_array, $row);
            // }
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
                            echo "<div class='product-price'>&#8364;&nbsp;" . str_replace('.', ',', $rc['RecommendedRetailPrice']) . "</div>";
                            echo "</div>";
                            echo "</div>";
                            echo "</div>";
                            $i++;
                        }
                    }
                }
            }

            // echo json_encode($result_array);
        } else {
            echo "<p>No matches found</p>";
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
    }
}
// Close statement
/*
if (isset($_GET["azr"])) {
            $azr = $_GET["azr"];
            $i = 1;
            if ($azr == "max" || $azr > $aantalproducten || $azr < 1) {
                $azr = $aantalproducten;
            }
            if (isset($result)) {
                foreach ($result as $row) {
                    if ($i <= $azr) {
                        ?>
                        <div class="card producten" id="producten">
                            <img src="<?php if (empty($row['image'])) {
                                echo "images/img1.jpg";
                            } else {
                                echo $row['image'];
                            } ?>" class="card-img-top" alt="Product Image">
                            <div class="card-body card-body-text row" id="card-body">
                                <h5 class="card-title"><?php echo $row["StockItemName"]; ?></h5>
                                <div class="card-tekst"><p class="card-text"><?php
                                        echo $row["MarketingComments"]; ?></p></div>
                                <div><a href="showitem.php?item_id=<?php echo $row["StockItemID"] ?>"
                                        class="btn btn-primary koop-knop">Bekijk Product</a>
                                    <div class="product-price">
                                        &#8364;&nbsp;<?php echo str_replace('.', ',', $row["RecommendedRetailPrice"]); ?></div>
                                </div>
                            </div>
                        </div>
                        <?php
                        $i++;
                    }
                }
            } else {
                $defURL = "index.php";
                header('Location: ' . $defURL);
            }
        }
        */
        