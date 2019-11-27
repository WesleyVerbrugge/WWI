<?php
include_once "header.php";
include_once 'dbconnection.php';
// $q = Database::getDb()->prepare("SELECT * FROM stockitems LEFT JOIN images_stockitems ON images_stockitems.StockItemID = stockitems.StockItemID JOIN stockitems  WHERE column_one = ? AND column_two =?");
// $q->execute([$variable1, $variable2]);
// $q = $q->fetchAll(PDO::FETCH_OBJ);
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
$link = mysqli_connect("localhost", "root", "", "wideworldimporters");

// Check connection
if ($link === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

if (isset($_GET["Term"]) && isset($_GET["Schoice"])) {
    // Prepare a select statement
    if (isset($_GET["Schoice"])) {
        if ($_GET["Schoice"] == "aname") {
            $sql = "SELECT * FROM stockitems LEFT JOIN images_stockitems ON images_stockitems.StockItemID = stockitems.StockItemID WHERE StockItemName LIKE ?";
        } else {
            $sql = "SELECT * FROM stockitems LEFT JOIN images_stockitems ON images_stockitems.StockItemID = stockitems.StockItemID where stockitems.stockitemID like ?";
        }
    }

    //sql kwiery voor categorien
    $sql_categorien = "SELECT s.StockGroupName, count(*) as AantalProductCategorie FROM stockgroups s JOIN stockitemstockgroups g ON s.StockGroupID=g.StockGroupID JOIN stockitems i ON g.StockItemID=i.StockItemID JOIN stockitemholdings h ON i.StockItemID=h.StockItemID group by s.StockGroupName";
    $result_categorien = mysqli_query($link, $sql_categorien);
    $arr_categorien = array();
    while ($row = mysqli_fetch_array($result_categorien, MYSQLI_ASSOC)) {
        $arr_categorien[$row["StockGroupName"]] = $row["AantalProductCategorie"];
    }

    //sql kwiery voor het aantal producten
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


    if ($stmt = mysqli_prepare($link, $sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_term);

        // Set parameters
        if (isset($_GET["Schoice"])) {
            if ($_GET["Schoice"] == "aname") {
                $param_term = '%' . $_GET["Term"] . '%';
            } else {
                $param_term = $_GET["Term"];
            }
        }


        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            // Check number of rows in the result set
            if (mysqli_num_rows($result) > 0) {
                // Fetch result rows as an associative array
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            } else {
                echo "<p>No matches found</p>";
            }
        } else {
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
        }
    }

    // Close statement
    mysqli_stmt_close($stmt);
}

// close connection
mysqli_close($link);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<!--<table style="border: solid;">-->
<!--<thead>-->
<!--<th>id</th>-->
<!--<th>name</th>-->
<!--<th></th>-->
<!--</thead>-->
<!--<tbody>-->
<?php
//if(isset($_GET['azr'])){
//  $azr = $_GET['azr'];
//  $i = 1;
//  foreach($result as $row){
//    if($i <= $azr) {
//      echo '<tr>';
//      echo '<td>' . $row['StockItemID'] . '</td>';
//      echo '<td>' . $row['SearchDetails'] . '</td>';
//      echo '<td><form method="post" action="showitem.php"><input type="hidden" name="item_id" value="' . $row["StockItemID"] . '"/> <input type="submit" value="bekijk item"></form></td>';
//      echo '</tr>';
//      $i++;
//    }
//  }
//}
?>
<!--</tbody>-->
<!--</table>-->
<!--Back to top Knop-->
<a id="button"></a>

<div class="container-fluid" id="container-producten">
    <div class="sticky-top">
        <nav aria-label="breadcrumb breadcrumb_div">
            <ol class="breadcrumb bg-white shadow-lg breadcrumb-div-in">
                <?php
                foreach ($arr_categorien as $categorie => $aantalproductcategorie) {
                    print '<li class="breadcrumb-item"><a class="customjsselector" href="#">'. $categorie .'</a></li>';
                }
                ?>
            </ol>
        </nav>
    </div>
    <div class="customjsselector2 row d-flex justify-content-center">
        <?php
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
                                <div class="card-tekst"><p class="card-text"><?php /*echo $row["SearchDetails"];*/
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
        ?>
    </div>
    <div class="customjsselector3 row d-flex justify-content-center">
        <?php
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
                                <div class="card-tekst"><p class="card-text"><?php /*echo $row["SearchDetails"];*/
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
        ?>
    </div>
</div>
<script>
    var btn = $('#button');

    $(window).scroll(function() {
        if ($(window).scrollTop() > 300) {
            btn.addClass('show');
        } else {
            btn.removeClass('show');
        }
    });

    btn.on('click', function(e) {
        e.preventDefault();
        $('html, body').animate({scrollTop:0}, '300');
    });


</script>
</body>
</html>