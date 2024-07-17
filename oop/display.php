<?php
require_once 'User.php';

if (isset($_COOKIE['first']) && isset($_COOKIE['last']) && isset($_COOKIE['age']) && isset($_COOKIE['date'])) {
    User::displayUsersTable();
} else {
    echo '<!DOCTYPE html>
    <html>
    <head>
        <title>Access Denied</title>
    </head>
    <body>
        <h1>Access Denied</h1>
        <p>You do not have access to this page. Please <a href="index.php">sign in</a>.</p>
    </body>
    </html>';
}
?>
