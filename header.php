<?php
if(isset($_GET['Term'])) {
    $term = $_GET['Term'];
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
    $(document).ready(function() {
        $('.azrselector').on("click", function(e){
            /* Get input value on change */
            var Term = $(this).val();
            var azr = $('.azrval').val();
            if(Term.length){
                var baseurl = window.location.origin;
                var extra = '?Term=' + Term + '&Schoice=' + searchchoice + '&azr=' + azr;
                window.location = baseurl + '/school/wwi/backend-search.php' + extra;
            } else{
                var baseurl = window.location.origin;
                var extra = '?Term=&Schoice=aname&azr=' + azr;
                window.location = baseurl + '/school/wwi/backend-search.php' + extra;
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
            $('#search').val(term);
        }
        $('#search').bind("enterKey", function(e){
            /* Get input value on change */
            var Term = $(this).val();
            var resultDropdown = $(this).siblings(".result");
            var searchchoice = $('#select').val();
            var azr = $('#azr').val();
            if(Term.length){
                var baseurl = window.location.origin;
                var extra = '?Term=' + Term + '&Schoice=' + searchchoice + '&azr=' + azr;
                window.location = baseurl + '/school/wwi/backend-search.php' + extra;
            } else{
                resultDropdown.empty();
            }
        
        // Set search input value on click of result item
        // $(document).on("click", ".result p", function(){
        //     $(this).parents(".search-box").find('input[type="text"]').val($(this).text());
        //     $(this).parent(".result").empty();
        // });
    });

    $('#button-addon2').on("click", function(e){
            /* Get input value on change */
            var Term = $('#search').val();
            var searchchoice = $('#select').val();
            var azr = $('#azr').val();
            if(Term.length){
                var baseurl = window.location.origin;
                var extra = '?Term=' + Term + '&Schoice=' + searchchoice + '&azr=' + azr;
                window.location = baseurl + '/school/wwi/backend-search.php' + extra;
            } else{
            }
        
        // Set search input value on click of result item
        // $(document).on("click", ".result p", function(){
        //     $(this).parents(".search-box").find('input[type="text"]').val($(this).text());
        //     $(this).parent(".result").empty();
        // });
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
    <img src="WWI%20logo.png" class="logo">
    </a>
    &nbsp;
    <a class="navbar-brand" href="#">WWI</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
        <ul class="navbar-nav mt-2 mt-lg-0">
            <li class="nav-item active">
                <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="backend-search.php?Term=&Schoice=aname&azr=max">Bladeren door producten</a>
            </li>
            <li class="nav-item">
                <a class="nav-link disabled" href="#" hidden>Disabled</a>
            </li>
        </ul>
        <form class="form-inline my-lg-0 mx-auto">
            <div class="input-group">
                <input type="text" class="form-control rounded-left" placeholder="Zoek product" id="search" aria-label="Recipient's username" aria-describedby="button-addon2">
                <div class="input-group-append">
                    <button class="btn btn-outline-success" type="button" id="button-addon2">Zoek</button>
                </div>
            </div>
<!--            <input class="form-control mr-sm-2" id="search" type="text" autocomplete="off" placeholder="Zoek product" />-->
            <label for="select">Zoektype&nbsp;</label>
            <select class="form-control" id="select">
                <option value="aname">Artikelnaam</option>
                <option value="anumbr">Artikelnummer</option>
            </select>&nbsp;
            <label for="azr">hoeveelheid zoekresultaten&nbsp; </label>
            <input class="form-control" min="0" max="227" id="azr" type="number" value="10" />
        </form>
        <a href="Shopping%20cart.php">
            <i class="fa fa-shopping-cart" style="font-size: 2.7em; color: black;"></i>
        </a>
<!--        <a>-->
<!--        <i class="fa fa-user-circle" style="font-size: 2.5em"></i>-->
<!--        </a>-->
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