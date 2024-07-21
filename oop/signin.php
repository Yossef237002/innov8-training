<?php
require_once 'User.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (User::authenticate($email, $password)) {
        setcookie("email", $email, time() + (86400 * 30), "/");
        header("Location: display.php");
        exit();
    } else {
        echo '<!DOCTYPE html>
        <html>
        <head>
            <title>Sign In</title>
        </head>
        <body>
            <h2>Sign In</h2>
            <p>Invalid email or password. Please try again.</p>
            <form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">
                <label for="email">Email:</label><br>
                <input type="email" id="email" name="email" required><br><br>

                <label for="password">Password:</label><br>
                <input type="password" id="password" name="password" required><br><br>

                <input type="submit" value="Sign In">
            </form>
            <br>
            <form action="index.php" method="get">
                <input type="submit" value="Return to Sign Up">
            </form>
        </body>
        </html>';
    }
} else {
    echo '<!DOCTYPE html>
    <html>
    <head>
        <title>Sign In</title>
    </head>
    <body>
        <h2>Sign In</h2>
        <form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">
            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" required><br><br>

            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" required><br><br>

            <input type="submit" value="Sign In">
        </form>
        <br>
        <form action="index.php" method="get">
            <input type="submit" value="Return to Sign Up">
        </form>
    </body>
    </html>';
}
?>
