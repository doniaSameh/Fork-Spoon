<?php
require_once('../../database-manager/database-object.php');

$data = array(
    "name" => $_POST["name"],
    "email" => $_POST["email"],
    "password" => $_POST["password"],
    "role" => "customerService",
    "status" => "approved"
);
$result = $db->insert('users', $data);

if ($result) {
    header('Location: /egyway/');
} else {
    header('Location: /egyway/add-user.php?error=failed');
}

