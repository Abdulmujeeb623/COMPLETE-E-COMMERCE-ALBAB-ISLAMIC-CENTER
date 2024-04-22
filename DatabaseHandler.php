<?php
class DatabaseHandler {
    public $connection; // Change the visibility to public

    public function __construct($dbHost, $dbUser, $dbPass, $dbName) {
        $this->connection = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    public function fetchCartItems($userId) {
        $query = "SELECT cart.quantity, products.product_id, products.name, products.description, products.price, products.image_url FROM cart JOIN products ON cart.product_id = products.product_id WHERE cart.user_id = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $cartItems = [];
        while ($row = $result->fetch_assoc()) {
            $cartItems[] = $row;
        }
        $stmt->close();
        return $cartItems;
    }

    public function deleteCartItem($userId, $productId) {
        // First, delete corresponding entries from the 'transaction' table
        $deleteTransactionQuery = "DELETE FROM transaction WHERE cart_id IN (SELECT cart_id FROM cart WHERE user_id = ? AND product_id = ?)";
        $stmt1 = $this->connection->prepare($deleteTransactionQuery);
        $stmt1->bind_param("ii", $userId, $productId);
        $stmt1->execute();
        $stmt1->close();
    
        // Then, delete the cart item
        $deleteCartQuery = "DELETE FROM cart WHERE user_id = ? AND product_id = ?";
        $stmt2 = $this->connection->prepare($deleteCartQuery);
        $stmt2->bind_param("ii", $userId, $productId);
        $result = $stmt2->execute();
        $stmt2->close();
    
        return $result;
    }
    
}
?>
