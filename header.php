<!doctype html>
<html lang="en">
<head>
<!--bootstrap include-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script type="text/javascript">
    $(document).ready(function(){
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
    $('input').keyup(function(e){
        if(e.keyCode == 13)
        {
            $(this).trigger("enterKey");
        }
    });
    });
</script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light navbar-margin-bot">
    <img src="WWI%20logo.png" class="logo">
    <a class="navbar-brand" href="#">WWI</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            <li class="nav-item active">
                <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Link</a>
            </li>
            <li class="nav-item">
                <a class="nav-link disabled" href="#">Disabled</a>
            </li>
        </ul>
        <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" id="search" type="text" autocomplete="off" placeholder="Zoek product" />
            <label for="select">Zoektype&nbsp;
            <select class="form-control" id="select">
                <option value="aname">Artikelnaam</option>
                <option value="anumbr">Artikelnummer</option>
            </select><br><br>
            <label for="azr">hoeveelheid zoekresultaten&nbsp; </label>
            <input class="form-control" id="azr" type="number" value="10" />
        </form>

    </div>
</nav>