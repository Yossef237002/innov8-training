<?php
require_once 'Database.php';

class User {
    private $first;
    private $last;
    private $age;
    private $date;

    public function __construct($first, $last, $age, $date) {
        $this->first = $first;
        $this->last = $last;
        $this->age = $age;
        $this->date = $date;
    }

    public function save() {
        $conn = Database::connect();
        $stmt = $conn->prepare("INSERT INTO users (first, last, age, date) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssis", $this->first, $this->last, $this->age, $this->date);
        $stmt->execute();
        $stmt->close();
        Database::close();
    }

    public static function generateForm() {
        $first = isset($_COOKIE['first']) ? $_COOKIE['first'] : '';
        $last = isset($_COOKIE['last']) ? $_COOKIE['last'] : '';
        $age = isset($_COOKIE['age']) ? $_COOKIE['age'] : '';
        $date = isset($_COOKIE['date']) ? $_COOKIE['date'] : '';

        echo '<!DOCTYPE html>
        <html>
        <head>
            <title>Sign In Form</title>
        </head>
        <body>
            <h2>Sign In Form</h2>
            <form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">
                <label for="first">First Name:</label><br>
                <input type="text" id="first" name="first" value="' . htmlspecialchars($first) . '" required><br><br>

                <label for="last">Last Name:</label><br>
                <input type="text" id="last" name="last" value="' . htmlspecialchars($last) . '" required><br><br>

                <label for="age">Age:</label><br>
                <input type="number" id="age" name="age" value="' . htmlspecialchars($age) . '" required><br><br>

                <label for="date">Date of Birth:</label><br>
                <input type="text" id="date" name="date" value="' . htmlspecialchars($date) . '" required><br><br>

                <input type="submit" value="Submit">
            </form>
            
            <br>
            <form action="display.php" method="get">
                <input type="submit" value="View Users">
            </form>
        </body>
        </html>';
    }

    public static function displayUsersTable() {
        $conn = Database::connect();
        $sql = "SELECT first, last, age, date FROM users";
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
                    <th>Age</th>
                    <th>Date of Birth</th>
                </tr>';

        while($row = $result->fetch_assoc()) {
            echo "<tr><td>" . htmlspecialchars($row["first"]) . "</td><td>" . htmlspecialchars($row["last"]) . "</td><td>" . htmlspecialchars($row["age"]) . "</td><td>" . htmlspecialchars($row["date"]) . "</td></tr>";
        }

        echo '</table>
        </body>
        </html>';

        Database::close();
    }
}
?>
