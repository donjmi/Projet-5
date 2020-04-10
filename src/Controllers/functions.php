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
function debug($var){
    echo '<pre>';
    print_r($var);
    echo '</pre>';
    die();

}