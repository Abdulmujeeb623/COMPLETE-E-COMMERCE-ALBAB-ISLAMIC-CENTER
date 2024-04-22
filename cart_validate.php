<?php


class DatabaseHandler {
    private $connection;

    public function __construct($dbHost, $dbUser, $dbPass, $dbName) {
        $this->connection = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    public function fetchAllResults() {
        // Modify your query to fetch all data and order by product name
        $query = "SELECT * FROM products ORDER BY name";

        $result = $this->connection->query($query);

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        return $data;
    }

    public function addToCart($userId, $productId, $quantity) {
        // Sanitize inputs
        $productId = $this->testInput($productId);
        $quantity = $this->testInput($quantity);
    
        // Prepare the statement
        $stmt = $this->connection->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)");
        // Bind parameters
        $stmt->bind_param("iii", $userId, $productId, $quantity);
    
        // Execute the statement
        $stmt->execute();
    
        // Close the statement
        $stmt->close();
    }
    
    public function __destruct() {
        $this->connection->close();
    }

    private function testInput($x) {
        $x = trim($x);
        $x = stripslashes($x);
        $x = htmlspecialchars($x);
        return $x;
    }
}

$dbHost = "localhost";
$dbUser = "ibdqwzul_albab";
$dbPass = "Abdulmujeeb_623";
$dbName = "ibdqwzul_albab";

$dbHandler = new DatabaseHandler($dbHost, $dbUser, $dbPass, $dbName);

// Fetch products
$productData = $dbHandler->fetchAllResults();

// Handle adding to cart
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['add_to_cart'])) {
    $productId = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    // Assuming you have a session variable for user_id
    $userId = $_SESSION['user_id'];

    // Sanitize inputs
   // $productId = $dbHandler->testInput($productId);
    //$quantity = $dbHandler->testInput($quantity);

    // Add the item to the cart
    $dbHandler->addToCart($userId, $productId, $quantity);
}
?>
