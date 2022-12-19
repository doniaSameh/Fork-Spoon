<?php
require_once($_SERVER['DOCUMENT_ROOT']."/fork&spoon/database-manager/database-object.php");

$email = $_POST['email'];
// Check if user exists in database
if (isset($email)) {
    // Get the user from database by email
    $db->where("email", $email);
    $user = $db->getOne("users");
    // If the user exists
    if (isset($user)) {
        http_response_code(400);
    } else {
        http_response_code(200);
    }
} else {
    http_response_code(400);
}
