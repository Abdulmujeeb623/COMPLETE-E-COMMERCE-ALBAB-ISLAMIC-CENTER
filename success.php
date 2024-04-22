<?php
session_start();
include('albab_navbar2.php');

// Database connection
$mysqli = new mysqli("localhost", "ibdqwzul_albab", "Abdulmujeeb_623", "ibdqwzul_albab");

if ($mysqli->connect_error) {
    die("Database connection failed: " . $mysqli->connect_error);
}

// Check if payment status is "success" from the GET function
if (isset($_GET['payment_status']) && $_GET['payment_status'] == "success") {
    // Get the user's session id
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];

        // SQL query to fetch transaction and transaction details for the user
        $query = "SELECT t.transaction_id, t.transaction_reference, t.timestamp, t.email, t.total_amount, t.payment_status,
                         GROUP_CONCAT(td.product_name) AS product_names,
                         GROUP_CONCAT(td.price) AS prices,
                         GROUP_CONCAT(td.description) AS descriptions,
                         GROUP_CONCAT(td.image_url) AS image_urls,
                         GROUP_CONCAT(td.quantity) AS quantities
                  FROM transaction t
                  INNER JOIN transaction_details td ON t.transaction_id = td.transaction_id
                  WHERE t.user_id = ?
                  GROUP BY t.transaction_id
                  ORDER BY t.timestamp DESC"; // Order by timestamp descending

        $stmt = $mysqli->prepare($query);

        if ($stmt) {
            $stmt->bind_param("i", $user_id);

            if ($stmt->execute()) {
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    // Display transaction and transaction details
                    echo '<div class="container">';
                    echo '<h3>Transaction Details:</h3>';
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="card mb-3">';
                        echo '<div class="card-body">';
                        echo '<h5 class="card-title">Transaction Information</h5>';
                        echo '<p class="card-text">Transaction ID: ' . $row['transaction_id'] . '</p>';
                        echo '<p class="card-text">Transaction Reference: ' . $row['transaction_reference'] . '</p>';
                        echo '<p class="card-text">Transaction Email: ' . $row['email'] . '</p>';
                        echo '<p class="card-text">Transaction Amount: ' . ($row['total_amount'] + 1000) . '</p>'; // Adding delivery fee
                        echo '<p class="card-text">Transaction Status: ' . $row['payment_status'] . '</p>';
                        echo '<p class="card-text">Transaction Time: ' . $row['timestamp'] . '</p>';
                        echo '<h5 class="card-title">Product Information</h5>';
                        // Explode the concatenated fields into arrays
                        $product_names = explode(",", $row['product_names']);
                        $prices = explode(",", $row['prices']);
                        $descriptions = explode(",", $row['descriptions']);
                        $image_urls = explode(",", $row['image_urls']);
                        $quantities = explode(",", $row['quantities']);

                        // Display products inside a responsive table
                        echo '<div class="table-responsive">';
                        echo '<table class="table">';
                        echo '<thead><tr><th>Product Name</th><th>Price</th><th>Description</th><th>Image</th><th>Quantity</th></tr></thead>';
                        echo '<tbody>';
                        for ($i = 0; $i < count($product_names); $i++) {
                            echo '<tr>';
                            echo '<td>' . $product_names[$i] . '</td>';
                            echo '<td>' . $prices[$i] . '</td>';
                            echo '<td>' . $descriptions[$i] . '</td>';
                            echo '<td><img src="' . $image_urls[$i] . '" alt="Product Image" style="max-width: 50px; max-height: 50px;"></td>'; // Inline styling for image size
                            echo '<td>' . $quantities[$i] . '</td>';
                            echo '</tr>';
                        }
                        echo '</tbody>';
                        echo '</table>';
                        echo '</div>'; // End of table-responsive
                        echo '</div>';
                        echo '</div>';
                    }
                    echo '</div>';
                } else {
                    // No transactions found for the user
                    echo "No transactions found for the user.";
                }
            } else {
                // Database query execution error
                echo "Database Error: " . $stmt->error;
            }

            $stmt->close();
        } else {
            // Error preparing statement
            echo "Error preparing statement: " . $mysqli->error;
        }
    }
} else {
    // Handle unsuccessful payment status
    echo "Payment was not successful.";
}

// Close the database connection
$mysqli->close();
include('albab_footer.php');
?>
