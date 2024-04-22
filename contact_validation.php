<?php
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

    public function saveFormData($yourName, $yourEmail, $yourSubject, $yourMessage)
    {
        // Use prepared statement to prevent SQL injection
        $stmt = $this->conn->prepare("INSERT INTO contact (name, email, subject, message) VALUES (?, ?, ?, ?)");

        // Check if the prepared statement was successful
        if ($stmt === false) {
            die("Prepare failed: " . $this->conn->error);
        }

        // Bind parameters with types
        $stmt->bind_param("ssss", $yourName, $yourEmail, $yourSubject, $yourMessage);

        // Validate and sanitize input using test_input function
        $yourName = $this->test_input($yourName);
        $yourEmail = $this->test_input($yourEmail);
        $yourSubject = $this->test_input($yourSubject);
        $yourMessage = $this->test_input($yourMessage);

        // Execute the prepared statement
        if ($stmt->execute()) {
            echo "<script>alert('Form successfully inserted!'); window.location='contact.php'</script>";
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
    $yourName = $_POST["your_name"];
    $yourEmail = $_POST["your_email"];
    $yourSubject = $_POST["your_subject"];
    $yourMessage = $_POST["your_message"];

    // Save form data using the DonationForm class method
    $donationForm->saveFormData($yourName, $yourEmail, $yourSubject, $yourMessage);
}

// Close the database connection
$conn->close();
?>