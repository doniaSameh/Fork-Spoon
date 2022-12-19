<?php
session_start();
// Clear the user from the session
unset($_SESSION['user']);
unset($_SESSION['search_result']);
// Redirect to login page
header('Location: /Fork&Spoon/user-service/login.php');