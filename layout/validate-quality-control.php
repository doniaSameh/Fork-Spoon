<?php 
// ## VALIDATE IF USER IS QUALITY CONTROL
if($_SESSION['user']['role'] != "qualityControl"){
    header('Location: /egyway/');
}
