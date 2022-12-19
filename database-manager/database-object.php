<?php
require_once('MysqliDb.php');
$host = "localhost";
$username = "root";
$password = "";
$dbname = "flight_booking_db";

$db = new MysqliDb($host, $username, $password, $dbname);
