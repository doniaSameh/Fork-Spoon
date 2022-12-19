<?php require_once('layout/header.php') ?>
<?php require_once('layout/validate-user.php') ?>
<?php require_once($_SERVER['DOCUMENT_ROOT']."/fork&spoon/database-manager/database-object.php");?>
<?php

$role = $_SESSION['user']['role'];
if ($role == 'admin') {
    require_once('home/home-quality-control.php');
} else {
    require_once('home/home-customer.php');
}
?>
<?php require_once('layout/footer.php') ?>
