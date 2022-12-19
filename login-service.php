<?php
require_once($_SERVER['DOCUMENT_ROOT']."/fork&spoon/database-manager/database-object.php");
$email = $_POST['email'];
$password = $_POST['password'];


if (empty($email) or empty($password)) {
    header('Location: /fork&spoon/login.php?error=empty'); // Pass query string to the login.php
} else {
    // Get the user from database by email
    $db->where("email", $email);
    $user = $db->getOne("users");

    if (isset($user)) {
        if ($user['isDisabled']) {
            header('Location: /fork&spoon/login.php?error=disabled', true); // Pass query string to the login.php

        } else {
            // Check if the credentials are valid for the retrieved user.
            if ($email == $user['email'] and $password == $user['password']) {
                if ($user['status'] == 'pending') {
                    header('Location: /fork&spoon/login.php?error=pending'); // Pass query string to the login.php
                } else {
                    // Set the session with the valid user
                    session_start();
                    $_SESSION['user'] = $user;
                    // Redirect the home after successful session set
                    header('Location: /fork&spoon/index.php');
                }
            } else {
                header('Location: /fork&spoon/login.php?error=invalid'); // Pass query string to the login.php
            }
        }
    } else {
        // The user doesn't exist in the database,
        // redirect to login screen with error message "Invalid username or password"
        header('Location: /fork&spoon/login.php?error=invalid'); // Pass query string to the login.php
    }
}
