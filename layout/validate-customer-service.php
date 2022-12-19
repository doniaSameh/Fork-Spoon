<?php 
// ## VALIDATE IF USER IS QUALITY CONTROL
if($_SESSION['user']['role'] != "customerService"){
    header('Location: /egyway/');
}
