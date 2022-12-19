<?php
require_once($_SERVER['DOCUMENT_ROOT']."/fork&spoon/database-manager/database-object.php");
$data = array(
    "name" => $_POST["name"],
    "email" => $_POST["email"],
    "password" => $_POST["password"],
    "phonenumber"=> $_POST["phonenumber"],
    "role" => "customer",
    "status" => "pending"
);
echo "hi".$data;
$id = $db->insert('users', $data);

if ($id) {
    header('Location: /fork&spoon/login.php'); // Pass query string to the login.php
} else {
   
    header('Location: /fork&spoon/signup.php?error=failed');
}
