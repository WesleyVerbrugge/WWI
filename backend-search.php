<?php
include_once "header.php";
include_once 'dbconnection.php';

$link = mysqli_connect("localhost", "root", "", "wideworldimporters");

// Check connection
if ($link === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

//sql query voor categorien
$sql_categorien = "SELECT s.StockGroupName, count(*) as AantalProductCategorie FROM stockgroups s JOIN stockitemstockgroups g ON s.StockGroupID=g.StockGroupID JOIN stockitems i ON g.StockItemID=i.StockItemID JOIN stockitemholdings h ON i.StockItemID=h.StockItemID group by s.StockGroupName";
$result_categorien = mysqli_query($link, $sql_categorien);
$arr_categorien = array();
while ($row = mysqli_fetch_array($result_categorien, MYSQLI_ASSOC)) {
    $arr_categorien[$row["StockGroupName"]] = $row["AantalProductCategorie"];
}
// checked of er iets in de zoekbalk is ingevuld
if (isset($_GET["Term"])) {
    //checked of er een getal is ingevuld en past daar de sql query op aan
    if (is_numeric($_GET["Term"])){
        $sql = "SELECT * FROM stockitems LEFT JOIN images_stockitems ON images_stockitems.StockItemID = stockitems.StockItemID where stockitems.stockitemID like ?";
    } else {
        // Prepare a select statement
        $sql = "SELECT * FROM stockitems LEFT JOIN images_stockitems ON images_stockitems.StockItemID = stockitems.StockItemID WHERE StockItemName LIKE ?";
    }

    //sql query voor het aantal producten
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

        // checked of er een getal is ingevuld in de zoekbalk
        if (is_numeric($_GET["Term"])){
            $param_term = $_GET["Term"];
        } else {
            $param_term = '%' . $_GET["Term"] . '%';
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
<!--Back to top Knop-->
<a id="button"></a>

<div class="container-fluid" id="container-producten">
    <div class="sticky-top">
        <nav aria-label="breadcrumb breadcrumb_div">
            <ol class="breadcrumb bg-white shadow-lg breadcrumb-div-in">
                <?php
                // print alle categoriën
                foreach ($arr_categorien as $categorie => $aantalproductcategorie) {
                    print '<li class="breadcrumb-item"><a class="customjsselector" href="#">'. $categorie .'</a></li>';
                }
                ?>
            </ol>
        </nav>
    </div>
    <div style="background-color: transparent; width: 120px">
        <div class="form-inline my-lg-0 mx-auto">
            <div class="form-group">
                <!-- knop voor het aantal zoekresultaten -->
                <label for="exampleFormControlSelect1">Number of search results</label>&nbsp;
                <select class="azrval form-control" id="exampleFormControlSelect1">
                  <option value="25"<?php if (isset($_GET["azr"])){ $azr_value = $_GET["azr"]; if ($azr_value == 25){echo (" selected");}} ?>>25</option>
                  <option value="50"<?php if (isset($_GET["azr"])){ $azr_value = $_GET["azr"]; if ($azr_value == 50){echo (" selected");}} ?>>50</option>
                  <option value="75"<?php if (isset($_GET["azr"])){ $azr_value = $_GET["azr"]; if ($azr_value == 75){echo (" selected");}} ?>>75</option>
                  <option value="100"<?php if (isset($_GET["azr"])){ $azr_value = $_GET["azr"]; if ($azr_value == 100){echo (" selected");}} ?>>100</option>
                  <option value=""<?php if (isset($_GET["azr"])){ $azr_value = $_GET["azr"]; if ($azr_value == ""){echo (" selected");}} ?>>all</option>
                </select>&nbsp;
                <button class="azrselector btn btn-primary">Apply</button>
            </div>
        </div>
    </div>
    <br>
    <div class="customjsselector2 row d-flex justify-content-center">
        <?php
        // checked of er een aantal zoekresultaten is aangeklikt
        if (isset($_GET["azr"])) {
            $azr = $_GET["azr"];
            if($azr == ""){
                $azr = $aantalproducten;
            }
            $i = 1;
            if ($azr == "max" || $azr > $aantalproducten || $azr < 1) {
                $azr = $aantalproducten;
            }
            // print elke kaart voor één product
            if (isset($result)) {
                foreach ($result as $row) {
                    if ($i <= $azr) {
                        ?>
                        <div class="card producten" id="producten">
                            <!-- als er geen foto in de database staat pakt hij onderstaande foto. anders wordt de foto uit de database gebruikt. -->
                            <img src="<?php if (empty($row['image'])) {
                                echo "images/img1.jpg";
                            } else {
                                echo $row['image'];
                            } ?>" class="card-img-top" alt="Product Image">
                            <div class="card-body card-body-text row" id="card-body">
                                <!-- naam -->
                                <h5 class="card-title"><?php echo $row["StockItemName"]; ?></h5>
                                <div class="card-tekst"><p class="card-text"><?php
                                        // korte beschrijving
                                        echo $row["MarketingComments"]; ?></p></div>
                                <!-- knop voor de productpagina -->
                                <div><a href="showitem.php?item_id=<?php echo $row["StockItemID"] ?>"
                                        class="btn btn-primary koop-knop">Go to product</a>
                                    <!-- prijs -->
                                    <div class="product-price">
                                        &#8364;&nbsp;<?php echo $row["RecommendedRetailPrice"]; ?></div>
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
    </div>
</div>
<!-- to top button -->
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