<?php
require_once 'Database.php';

class User {
    private $first;
    private $last;
    private $password;
    private $email;

    public function __construct($first, $last, $password, $email) {
        $this->first = $first;
        $this->last = $last;
        $this->password = password_hash($password, PASSWORD_DEFAULT);
        $this->email = $email;
    }

    public function save() {
        $conn = Database::connect();
        $stmt = $conn->prepare("INSERT INTO users (first, last, password, email) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $this->first, $this->last, $this->password, $this->email);
        $stmt->execute();
        $stmt->close();
        Database::close();
    }
    public static function emailExists($email) {
        $conn = Database::connect();
        $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $count=null;
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();
        Database::close();
        
        return $count > 0;
    }

    public static function generateForm() {
        $first = isset($_COOKIE['first']) ? $_COOKIE['first'] : '';
        $last = isset($_COOKIE['last']) ? $_COOKIE['last'] : '';
        $email = isset($_COOKIE['email']) ? $_COOKIE['email'] : '';

        echo '<!DOCTYPE html>
        <html>
        <head>
            <title>Sign Up Form</title>
        </head>
        <body>
            <h2>Sign Up Form</h2>
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
    }

    public static function displayUsersTable() {
        $conn = Database::connect();
        $sql = "SELECT first, last, email FROM users";
        $result = $conn->query($sql);

        echo '<!DOCTYPE html>
        <html>
        <head>
            <title>Display Table</title>
        </head>
        <body>
            <h1>Users Table</h1>
            <table border="2">
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                </tr>';

        while($row = $result->fetch_assoc()) {
            echo "<tr><td>" . htmlspecialchars($row["first"]) . "</td><td>" . htmlspecialchars($row["last"]) . "</td><td>" . htmlspecialchars($row["email"]) . "</td></tr>";
        }

        echo '</table>
            <br>
            <form method="post" action="logout.php">
                <input type="submit" value="Logout">
            </form>
        </body>
        </html>';

        Database::close();
    }

    public static function authenticate($email, $password) {
        $conn = Database::connect();
        $stmt = $conn->prepare("SELECT password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $hash = null;
        $stmt->bind_result($hash);
        // $hash = null;
        $stmt->fetch();
        $stmt->close();
        Database::close();

        return $hash && password_verify($password, $hash);
    }
} 
?>
