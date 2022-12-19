<?php 
// ## VALIDATE IF USER IS LOGGED IN
if(!isset($_SESSION['user'])){
    // Redirect to login.php if the user session doesn't exist
    header('Location: /egyway/login.php');
}
