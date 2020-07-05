<?php
// Database informations

define('DB_DSN', 'mysql:host=localhost;dbname=blog;charset=utf8');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_OPTIONS', array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));



const EMAIL_HOST = 'smtp.gmail.com';
const EMAIL_PORT = 587;
const EMAIL_USERNAME = 'email';
const EMAIL_PASSWORD = 'password';
const EMAIL_ENCRYPTION = 'tls';
