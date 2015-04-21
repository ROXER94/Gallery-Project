<?php session_start();
unset($_SESSION[ "logged_user" ] );
header("Location: Index.php");//Takes a logged out user back to the Index page
?>