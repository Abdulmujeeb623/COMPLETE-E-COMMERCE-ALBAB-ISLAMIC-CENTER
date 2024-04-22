<?php
session_start();
// Assuming you have a database connection established
$servername = "localhost";
$username = "ibdqwzul_albab";
$password = "Abdulmujeeb_623";
$dbname = "ibdqwzul_albab";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

class DonationForm
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function saveFormData($yourUserId, $yourName, $yourEmail, $yourNumber, $yourAddress1, $yourAddress2, $yourCountry, $yourCity, $yourState)
    {
        // Use prepared statement to prevent SQL injection
        $stmt = $this->conn->prepare("INSERT INTO billing (user_id, name, email, number, address1, address2, country, city, state) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

        // Check if the prepared statement was successful
        if ($stmt === false) {
            die("Prepare failed: " . $this->conn->error);
        }

        // Bind parameters with types
        $stmt->bind_param("issssssss", $yourUserId, $yourName, $yourEmail, $yourNumber, $yourAddress1, $yourAddress2, $yourCountry, $yourCity, $yourState);

        // Validate and sanitize input using test_input function
        
        $yourName = $this->test_input($yourName);
        $yourEmail = $this->test_input($yourEmail);
        $yourNumber = $this->test_input($yourNumber);
        $yourAddress1 = $this->test_input($yourAddress1);
        $yourAddress2 = $this->test_input($yourAddress2);
        $yourCountry = $this->test_input($yourCountry);
        $yourCity = $this->test_input($yourCity);
        $yourState = $this->test_input($yourState);

        // Execute the prepared statement
        if ($stmt->execute()) {
            echo "<script>alert('Form successfully inserted!'); window.location='checkout.php'</script>";
                } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    }

    private function test_input($data)
    {
        // Use the built-in PHP function to sanitize and validate input
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}

// Create an instance of the DonationForm class
$donationForm = new DonationForm($conn);

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $yourUserId = $_SESSION["user_id"];
    
    $yourName = $_POST["your_name"];
    $yourEmail = $_POST["your_email"];
    $yourNumber = $_POST["your_number"];
    $yourAddress1 = $_POST["your_address1"];
    $yourAddress2 = $_POST["your_address2"];
    $yourCountry = $_POST["your_country"];
    $yourCity = $_POST["your_city"];
    $yourState = $_POST["your_state"];

    // Save form data using the DonationForm class method
    $donationForm->saveFormData($yourUserId, $yourName, $yourEmail, $yourNumber, $yourAddress1, $yourAddress2, $yourCountry, $yourCity, $yourState);
}

// Close the database connection
$conn->close();
?>