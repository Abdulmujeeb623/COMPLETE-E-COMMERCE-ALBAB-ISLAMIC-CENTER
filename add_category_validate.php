<?php
$dbHost = "localhost";
$dbUser = "ibdqwzul_albab";
$dbPass = "Abdulmujeeb_623";
$dbName = "ibdqwzul_albab";

$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

class CategoryForm
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function saveFormData($categoryName, $categoryImage, $categoryQuantity)
    {
        $stmt = $this->conn->prepare("INSERT INTO categories (name, image_url, quantity) VALUES (?, ?, ?)");

        if ($stmt === false) {
            die("Prepare failed: " . $this->conn->error);
        }

        $stmt->bind_param("sss", $categoryName, $categoryImage, $categoryQuantity);

        if ($stmt->execute()) {
            echo "<script>alert('Category successfully inserted!'); window.location='add_category_form.php'</script>";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }
}

$categoryForm = new CategoryForm($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $categoryName = $_POST["category_name"];
    $categoryImage = $_FILES["category_image"]["name"];
    $categoryQuantity = $_POST["category_stock"];

    $uploadDirectory = "uploads/";
    $targetFilePath = $uploadDirectory . basename($categoryImage);
    $fileExtension = pathinfo($targetFilePath, PATHINFO_EXTENSION);
    $allowedExtensions = array("jpg", "jpeg", "png", "gif");

    if (!in_array(strtolower($fileExtension), $allowedExtensions)) {
        echo "Error: Only jpg, jpeg, png, and gif files are allowed.";
        exit();
    }

    if (file_exists($targetFilePath)) {
        echo "Error: File already exists. Please rename the file and try again.";
        exit();
    }

    // Check file size
    if ($_FILES["category_image"]["size"] > 5000000) { // 5MB
        echo "Error: File size exceeds maximum limit (5MB).";
        exit();
    }

    if (move_uploaded_file($_FILES["category_image"]["tmp_name"], $targetFilePath)) {
        $categoryForm->saveFormData($categoryName, $targetFilePath, $categoryQuantity);
    } else {
        echo "Error uploading file.";
    }
}

$conn->close();
?>
