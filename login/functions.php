<?php

function isset_value($input){

    if (isset($_POST[$input])){
        print("value=\"" . $_POST[$input] . "\"");
    }
}

?>