<?php
session_start(); // Starting the session if not already started

if (isset($_GET['reference'])) {
    $reference = $_GET['reference'];

    // Perform input validation on the reference
    if (!preg_match('/^[A-Za-z0-9]+$/', $reference)) {
        header("Location: checkout.php");
        exit;
    }

    $curl = curl_init();

    // Set your Paystack secret key here
    $secretKey = 'sk_test_4cdf192918dad2e24fefb32b3d3fa431d51271de';

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.paystack.co/transaction/verify/" . rawurlencode($reference),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Authorization: Bearer $secretKey", // Use your secret key here
            "Cache-Control: no-cache",
        )
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        // Handle cURL errors, e.g., log the error
        error_log("cURL Error: $err");
        header("Location: albab_dashboard.php");
        exit;
    } else {
        $result = json_decode($response);

        // Check if the request was successful and the status is "success"
        if (isset($result->data->status) && $result->data->status == "success") {
            $status = $result->data->status;
            $reference = $result->data->reference;
            $amount = $result->data->amount;
            $cus_email_var = isset($result->data->customer->email) ? $result->data->customer->email : "";

            // Extract customer details
            $fullName = isset($_SESSION['name']) ? $_SESSION['name'] : '';

            // Include database connection
            $dbHost = "localhost";
            $dbUser = "ibdqwzul_albab";
            $dbPass = "Abdulmujeeb_623";
            $dbName = "ibdqwzul_albab";

            $conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            if (isset($_GET['full_name'])) {
                // Get full name from the URL parameter
                $fullName = $_GET['full_name'];

                // Fetch billing information for the current user
                $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;
                $sql = "SELECT billing_id FROM billing WHERE user_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $user_id);
                $stmt->execute();
                $result = $stmt->get_result();
                $billingInfo = $result->fetch_assoc();
                $billing_id = isset($billingInfo['billing_id']) ? $billingInfo['billing_id'] : 0; // Assuming the column name is 'billing_id'
                $stmt->close();

                // Fetch products from the cart for the current user
                $sql = "SELECT c.*, p.name, p.price, p.image_url, p.description
                        FROM cart c
                        INNER JOIN products p ON c.product_id = p.product_id
                        WHERE c.user_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $user_id);
                $stmt->execute();
                $result = $stmt->get_result();

                $cartItems = array();
                while ($row = $result->fetch_assoc()) {
                    $cartItems[] = $row;
                }

                $stmt->close();

                // Check if cart items are empty
                if (empty($cartItems)) {
                    // Handle empty cart (e.g., redirect the user back to the shopping page)
                    header("Location: shopping.php");
                    exit();
                }

                // Insert transaction details into the transaction table
                $payment_status = "success"; // Assuming you have the payment status from somewhere
                $totalPrice = 0;

                // Start transaction
                $conn->begin_transaction();

                $sqlTransaction = "INSERT INTO `transaction` (`user_id`, `billing_id`, `transaction_reference`, `name`, `email`, `total_amount`, `payment_status`) VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmtTransaction = $conn->prepare($sqlTransaction);
                $stmtTransaction->bind_param("iisssds", $user_id, $billing_id, $reference, $fullName, $cus_email_var, $totalPrice, $payment_status);

                if (!$stmtTransaction->execute()) {
                    // Handle insertion failure
                    echo "Error: " . $stmtTransaction->error;
                    $conn->rollback();
                    exit;
                } else {
                    $transaction_id = $stmtTransaction->insert_id;

                    // Insert product details into the transaction_details table
                    $sqlDetails = "INSERT INTO `transaction_details` (`transaction_id`, `product_name`, `price`, `image_url`, `description`, `quantity`) VALUES (?, ?, ?, ?, ?, ?)";
                    $stmtDetails = $conn->prepare($sqlDetails);

                    foreach ($cartItems as $item) {
                        $productName = $item['name'];
                        $price = $item['price'];
                        $imageUrl = $item['image_url'];
                        $description = $item['description'];
                        $quantity = $item['quantity']; // Fetching quantity from cart item

                        $stmtDetails->bind_param("isdssi", $transaction_id, $productName, $price, $imageUrl, $description, $quantity);
                        $stmtDetails->execute();
                        $totalPrice += $price * $quantity; // Calculating total price with quantity
                    }

                    $stmtDetails->close();

                    // Update total amount in the transaction table
                    $sqlUpdateTotalAmount = "UPDATE `transaction` SET `total_amount` = ? WHERE `transaction_id` = ?";
                    $stmtUpdateTotalAmount = $conn->prepare($sqlUpdateTotalAmount);
                    $stmtUpdateTotalAmount->bind_param("di", $totalPrice, $transaction_id);
                    $stmtUpdateTotalAmount->execute();
                    $stmtUpdateTotalAmount->close();

                    // Commit transaction
                    $conn->commit();

                    // Clear the cart after successful transaction
                    $sqlClearCart = "DELETE FROM cart WHERE user_id = ?";
                    $stmtClearCart = $conn->prepare($sqlClearCart);
                    $stmtClearCart->bind_param("i", $user_id);

                    if (!$stmtClearCart->execute()) {
                        // Handle cart clearing failure
                        echo "Error clearing cart: " . $stmtClearCart->error;
                        // Optionally, you can redirect the user to an error page or handle it in another way
                    } else {
                        // Redirect the user to a success page with payment status
                      header("Location: success.php?payment_status=success");
                      exit();

                    }

                    $stmtClearCart->close();
                }

                $stmtTransaction->close();
            } else {
                // Handle missing full name
                header("Location: index.php");
                exit();
            }
        } else {
            // Handle unsuccessful transaction verification
            header("Location: index.php");
            exit();
        }
    }
} else {
    // Handle missing reference
    header("Location: index.php");
    exit();
}
?>
