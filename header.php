<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if(isset($_GET['Term'])) {
    $term = $_GET['Term'];
}
if (isset($_GET["azr"])){
    $azr = $_GET['azr'];
}
?>
<!doctype html>
<html lang="en">
<head>
<!--bootstrap include-->
    <script src="https://use.fontawesome.com/e66eadd611.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script type="text/javascript">
  $(document).ready( function() {
    $('#savereview').on("click", function(e){
            var review = $('#review').val();
            var item_id = $('#item_id').val();
            var baseurl = window.location.origin;
            var extra = '?review=' + review + '&item_id=' + item_id;
            window.location = baseurl + '/wwi/savereview.php' + extra;
    });
  })
  </script>
    <script type="text/javascript">
    $(document).ready(function() {
        $('.azrselector').on("click", function(e){
            /* Get input value on change */
            var Term = $('#search').val();
            var azr = $('.azrval').val();
            if(Term.length){
                var baseurl = window.location.origin;
                var extra = '?Term=' + Term + '&Schoice=' + searchchoice + '&azr=' + azr;
                window.location = baseurl + '/wwi/backend-search.php' + extra;
            } else{
                var baseurl = window.location.origin;
                var extra = '?Term=&Schoice=aname&azr=' + azr;
                window.location = baseurl + '/wwi/backend-search.php' + extra;
            }
        })
    })
    </script>
    <script type="text/javascript">
    $(document).ready(function(){
        var term = "<?php if(isset($_GET['Term'])){ echo $term; }?>";
        if(term === undefined) {
            // not set
        } else {
            var term = $('#search').val();
        }
        console.log(term);


    $('#button-addon2').on("click", function(e){
            /* Get input value on change */
            var Term = $('#search').val();
            var searchchoice = $('#select').val();
            var azr = $('#azr').val();
            if(Term.length){
                var baseurl = window.location.origin;
                var extra = '?Term=' + Term + '&Schoice=' + searchchoice + '&azr=' + azr;
                window.location = baseurl + '/wwi/backend-search.php' + extra;
            } else{
            }
    });
    
    $('input').keyup(function(e){
        if(e.keyCode == 13)
        {
            $(this).trigger("enterKey");
        }
    });
    });
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $('.customjsselector').on("click", function(e) {
            var term = "<?php if(isset($_GET['Term'])) { echo $term; } ?>";
            var category = $(this).html();
            var azr = "<?php if(isset($_GET['azr'])) { echo $azr; } ?>";
            var url = "category-search.php";
            var response = '';
            if(term === ''){
            $.post("category-search.php",{"azr": azr, "category": category},function(data) {
            $('.customjsselector3').html(data);
            }, "html");
            } else {
            $.post("category-search.php",{"azr": azr, "term" : term, "category": category},function(data) {
            $('.customjsselector3').html(data);
            }, "html");
            }
            
            $('.customjsselector2').attr('style','display: none !important');
            $('.customjsselector3').removeAttr('style','display: none  !important');
        });
    });
</script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light navbar-margin-bot shadow bg-white">
    <a href="index.php">
    <img src="WWI%20logo.png" class="logo" alt="logo">
    </a>
    &nbsp;
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
        <ul class="navbar-nav mt-2 mt-lg-0">
            <li class="nav-item active">
                <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="backend-search.php?Term=&Schoice=aname&azr=max">Browse products</a>
            </li>
        </ul>


            <div class="input-group" style="width: 25%; margin: auto; min-width: 250px">
                <input type="text" class="form-control rounded-left" value="<?php if (isset($_GET["Term"])){print($_GET["Term"]);} ?>" placeholder="Browse Product" id="search" aria-label="Recipient's username" aria-describedby="button-addon2">
                <div class="input-group-append">
                    <button class="btn btn-outline-success" type="button" id="button-addon2">Search</button>
                </div>
            </div>

            <select style="display: none !important;" type="hidden" class="form-control" id="select">
                <option value="aname">Artikelnaam</option>
                <option value="anumbr">Artikelnummer</option>
            </select>&nbsp;

            <input type="hidden" class="form-control" min="0" max="227" id="azr" value="25" />


        <a href="shoppingcart.php" style="z-index: 1">
            <i class="fa fa-shopping-cart" style="font-size: 2.7em; color: black;"></i>
            <span style="z-index: 2" class="badge badge-pill badge-primary"><?php if (isset($_SESSION["winkelwagen"])){ if (isset($_GET["submitWinkelwagen"])) { print (count($_SESSION["winkelwagen"]) + 1); } elseif (isset($_GET["verwijderProduct"])){print (count($_SESSION["winkelwagen"]) - 1);} else {print (count($_SESSION["winkelwagen"])); }} ?></span>
        </a>
        <?php 
        if(isset($_SESSION['user_data'])) {
        echo '
        <a href="accountpage.php" style="margin-left: 10px;">
        <i class="fa fa-user-circle" style="font-size: 2.7em; color: black;"></i>
        </a>
        ';
        }
        ?>

        <ul class="navbar-nav mt-2 mt-lg-0">
            <li class="nav-item active">
                <?php
                if(isset($_SESSION['user_data'])) {
                    echo '<a class="nav-link" href="logout.php">logout</a>';
                } else {
                    echo '<a class="nav-link" href="login.php">login</a>';
                }
                ?>

            </li>
        </ul>

    </div>

</nav>