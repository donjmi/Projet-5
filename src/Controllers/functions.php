<?php

function str_secur($string){
    return trim(htmlspecialchars($string));
}


/**
 * debug
 *
 * @param  mixed $var
 * @return void
 */
function debug($var=null, $txt =null){
    echo '<pre>';
    print_r($var);
    echo '</pre>';
    print_r($txt);
    echo '</pre>';
    die();

}