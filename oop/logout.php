<?php
setcookie("first", "", time() - 3600, "/");
setcookie("last", "", time() - 3600, "/");
setcookie("email", "", time() - 3600, "/");

header("Location: signin.php");
?>
