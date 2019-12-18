<?php 
session_start();
include_once "header.php"; 
if(isset($_GET['ls'])){
    echo '<div class="alert alert-success" role="alert">
    Login successful!
  </div>';
}
if(isset($_GET['mls'])){
    if($_GET['mls'] == 1) {
        echo '<div class="alert alert-success" role="alert">
        Master Login successful!
        </div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">
        Master Login denied!
        </div>';
    }
}
if(isset($_GET['na'])){
    if($_GET['na'] == 1){
        echo '<div class="alert alert-danger" role="alert">
        No admin access
        </div>';
    }
}
?>
<body>
<div class="container-fluid">
    <div class="jumbotron"><h3 class="display-2">Welcome&nbsp;<?php if(isset($_SESSION['user_data'])){ print($_SESSION['user_data']['Firstname']);} ?></h3></div>
</div>
</body>
<?php
$link = mysqli_connect("localhost", "root", "", "wideworldimporters");

// Check connection
if ($link === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

$sql= "SELECT i.StockItemName, i.RecommendedRetailPrice, i.MarketingComments, i.StockItemID
FROM stockgroups s
JOIN stockitemstockgroups g ON s.StockGroupID=g.StockGroupID
JOIN stockitems i ON g.StockItemID=i.StockItemID
JOIN stockitemholdings h ON i.StockItemID=h.StockItemID
ORDER BY rand()
LIMIT 3";



$result = mysqli_query($link, $sql);
if ($result->num_rows > 0) {
    echo '<div class="container"><div class="row">';
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $naam = $row["StockItemName"];
        $prijs = $row["RecommendedRetailPrice"];
        $omschrijvingg = $row["MarketingComments"];
        $ID = $row["StockItemID"];
        ?> <div class="col-sm-4">
            <?php echo $naam . "<br>" . $omschrijvingg. "<br>";?>
            <img src="images/img1.jpg"/" style="width:150px;height:150px;"><br>
            <?php echo  "€" . $prijs; ?>
            <div><a href="showitem.php?item_id=<?php echo $row["StockItemID"] ?>"
                    class="btn btn-primary koop-knop">Go to Product</a>
            </div>
        </div>
    <?php }} ?>
    </div>
    </div>
<?php include_once "footer.php"; ?>