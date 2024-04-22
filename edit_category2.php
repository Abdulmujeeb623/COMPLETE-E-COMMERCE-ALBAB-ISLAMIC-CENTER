<?php
session_start(); // Start the session

$host = "localhost"; // Your database host
$username = "ibdqwzul_albab"; // Your database username
$password = "Abdulmujeeb_623"; // Your database password
$database = "ibdqwzul_albab"; // Your database name

// Create a database connection
$dbHandler = new mysqli($host, $username, $password, $database);

// Check the connection
if ($dbHandler->connect_error) {
    die("Connection failed: " . $dbHandler->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['category_id'])) {
    $categoryId = $_GET['category_id'];

    // Load the product data from the database based on the ID
    $query = "SELECT * FROM categories WHERE category_id = ?";
    $stmt = $dbHandler->prepare($query);
    $stmt->bind_param("i", $categoryId);
    $stmt->execute();
    $result = $stmt->get_result();
    $categoryData = $result->fetch_assoc();

    $stmt->close();
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_category'])) {
        // Handle form submission to update product information
        $categoryId = $_POST['id'];
        $name = $_POST['name'];
        $image = $_POST['image'];
        $stock = $_POST['quantity'];

        $query = "UPDATE categories SET name = ?, image_url = ?, quantity = ? WHERE category_id = ?";
        $stmt = $dbHandler->prepare($query);
        $stmt->bind_param("sssi", $name, $image, $stock, $categoryId);

        $stmt->execute();
        $stmt->close();
        // Redirect to the product records page after the update
        header("Location: edit_category.php"); // Added "header" function
        exit; // Exit after redirect
    } elseif (isset($_POST['delete_category'])) {
        // Handle form submission to delete a product
        $categoryId = $_POST['id']; // Corrected variable name

        // Delete the product information from the database
        $query = "DELETE FROM categories WHERE category_id = ?";
        $stmt = $dbHandler->prepare($query);
        $stmt->bind_param("i", $categoryId);
        $stmt->execute();
        $stmt->close();

        // Redirect to the product records page after the delete
        header("Location: edit_category.php"); // Added "header" function
        exit; // Exit after redirect
    }
}
?>
<?php include("albab_navbar.php"); ?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Category Record</title>
</head>
<body>

<div class="container">
    <h1 class="text-center mt-4 mb-4">Edit Categories</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $categoryData['category_id']; ?>">
        <div class="form-group">
            <label for="title">Name</label>
            <input type="text" class="form-control" id="title" name="name" value="<?php echo $categoryData['name']; ?>">
        </div>
        
        <div class="form-group">
            <label for="image">Image</label>
            <input type="text" class="form-control" id="image" name="image" value="<?php echo $categoryData['image_url']; ?>">
        </div>
        
        <div class="form-group">
            <label for="stock">Stock Quantity</label>
            <input type="text" class="form-control" id="stock" name="stock" value="<?php echo $categoryData['quantity']; ?>">
        </div>

        <button type="submit" name="update_category" class="btn btn-warning">Update</button>
        <button type="submit" name="delete_category" class="btn btn-danger">Delete</button>
    </form>
</div>

<?php include("albab_footer.php"); ?>
</body>
</html>
