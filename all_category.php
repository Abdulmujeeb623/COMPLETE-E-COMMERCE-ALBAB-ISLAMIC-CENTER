
<?php


class Database {
    private $connection;

    public function __construct($dbHost, $dbUser, $dbPass, $dbName) {
        // Create a database connection
        $this->connection = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    public function fetchAllCategories() {
        // Modify your query to fetch all data and order by student name
        $query = "SELECT * FROM categories ORDER BY category_id ASC";

        $result = $this->connection->query($query);

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        return $data;
    }
}
$dbHost = "localhost";
$dbUser = "ibdqwzul_albab";
$dbPass = "Abdulmujeeb_623";
$dbName = "ibdqwzul_albab";


$dbHandler = new Database($dbHost, $dbUser, $dbPass, $dbName);

$categoryInfo = $dbHandler->fetchAllCategories();

?>
