<?php

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

const EMAIL_HOST = 'smtp.gmail.com';
const EMAIL_PORT = 587;
const EMAIL_USERNAME = 'donjmipub@gmail.com';
const EMAIL_PASSWORD = 'donjmi@1';
const EMAIL_ENCRYPTION = 'tls';