<?php
// require_once('MysqliDb.php');
require_once($_SERVER['DOCUMENT_ROOT']."/fork&spoon/database-manager/MysqliDb.php");
$host = "localhost";
$username = "root";
$password = "";
$dbname = "fork_and_spoon_db";

$db = new MysqliDb($host, $username, $password, $dbname);
