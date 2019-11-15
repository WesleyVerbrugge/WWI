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
        if(Term.length){
            // $.get("backend-search.php", {term: inputVal}).done(function(data){
            //     // Display the returned data in browser
            //     resultDropdown.html(data);
            // });
            var baseurl = window.location.origin;
            var extra = '?Term=' + Term;
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
    <div class="search-box">
        <input type="text" autocomplete="off" placeholder="Zoek product" />
        <div class="result"></div>
    </div>
</body>
</html>