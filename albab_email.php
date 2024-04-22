<?php

// Establish a database connection (replace with your database credentials)
$servername = "localhost";
$username = "ibdqwzul_albab";
$password = "Abdulmujeeb_623";
$dbname = "ibdqwzul_albab";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate email
    $email = filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);
    $name = $_POST["name"];
    
    if ($email) {
        // Prepare and bind the statement
        $sql = "INSERT INTO newsletter (name, email) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        
        if ($stmt) {
            $stmt->bind_param("ss", $name, $email); // "ss" represents two string parameters

            // Execute the statement
            if ($stmt->execute()) {
                // Email subscription successful, send confirmation email
                echo "<script>alert('Subscription successful. Check your email for confirmation.'); window.location='index.php'</script>";
            } else {
                echo "Error: " . $stmt->error;
            }

            // Close the statement
            $stmt->close();
        } else {
            echo "Error in preparing the statement.";
        }
    } else {
        echo "Invalid email address.";
    }
}

$conn->close();

?>
