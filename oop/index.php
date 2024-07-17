<?php
require_once 'User.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    setcookie("first", $_POST['first'], time() + (86400 * 30), "/");
    setcookie("last", $_POST['last'], time() + (86400 * 30), "/");
    setcookie("age", $_POST['age'], time() + (86400 * 30), "/");
    setcookie("date", $_POST['date'], time() + (86400 * 30), "/");

    $user = new User($_POST['first'], $_POST['last'], $_POST['age'], $_POST['date']);
    $user->save();
} else {
    User::generateForm();
}
?>
