<?php 
// session cookie lost when close browser
// $lifetime = 0; 
$lifetime = 3 * 365 *  24 * 60 * 60;
if(session_status() === PHP_SESSION_NONE){
session_set_cookie_params($lifetime, '/');
session_start();
}
?>