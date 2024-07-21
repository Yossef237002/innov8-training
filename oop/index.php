<?php
require_once 'User.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $first = $_POST['first'];
    $last = $_POST['last'];
    $password = $_POST['password'];
    $email = $_POST['email'];


    if (User::emailExists($email)) {
        echo '<!DOCTYPE html>
        <html>
        <head>
            <title>Sign Up</title>
        </head>
        <body>
            <h2>Sign Up</h2>
            <p>Email already exists. Please try a different email or <a href="index.php">return to sign up</a>.</p>
            <form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">
                <label for="first">First Name:</label><br>
                <input type="text" id="first" name="first" value="' . htmlspecialchars($first) . '" required><br><br>

                <label for="last">Last Name:</label><br>
                <input type="text" id="last" name="last" value="' . htmlspecialchars($last) . '" required><br><br>

                <label for="password">Password:</label><br>
                <input type="password" id="password" name="password" required><br><br>

                <label for="email">Email:</label><br>
                <input type="email" id="email" name="email" value="' . htmlspecialchars($email) . '" required><br><br>

                <input type="submit" value="Sign Up">
            </form>
            <br>
            <form action="signin.php" method="get">
                <input type="submit" value="Sign In">
            </form>
        </body>
        </html>';
    } else {
      
        $user = new User($first, $last, $password, $email);
        $user->save();
        
        
        header("Location: display.php");
        exit();
    }
} else {
    User::generateForm();
}
?>
