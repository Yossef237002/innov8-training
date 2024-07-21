<?php
require_once 'User.php';

if (isset($_COOKIE['email'])) {
    User::displayUsersTable();
} else {
    echo '<!DOCTYPE html>
    <html>
    <head>
        <title>Access Denied</title>
    </head>
    <body>
        <h1>Access Denied</h1>
        <p>You do not have access to this page. Please <a href="signin.php">sign in</a>.</p>
    </body>
    </html>';
}
?>
