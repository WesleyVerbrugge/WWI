<?php include_once "header.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>PHP Live MySQL Database Search</title>
<link rel="stylesheet" href="style.css">
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $('.search-box input[type="text"]').bind("enterKey", function(e){
        /* Get input value on change */
        var Term = $(this).val();
        var resultDropdown = $(this).siblings(".result");
        var searchchoice = $('#select').val();
        var azr = $('#azr').val();
        if(Term.length){
            var baseurl = window.location.origin;
            var extra = '?Term=' + Term + '&Schoice=' + searchchoice + '&azr=' + azr;
            window.location = baseurl + '/wwi/backend-search.php' + extra;
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
    <div class="search-box container-fluid">
        <input type="text" autocomplete="off" placeholder="Zoek product" />
        <label for="select">Zoektype
        <select id="select">
            <option value="aname">Artikelnaam</option>
            <option value="anumbr">Artikelnummer</option>
        </select><br><br>
        <label for="azr">hoeveelheid zoekresultaten</label>
        <input id="azr" type="number" value="10" />
        <div class="result"></div>
    </div>
<?php include_once "footer.php"; ?>