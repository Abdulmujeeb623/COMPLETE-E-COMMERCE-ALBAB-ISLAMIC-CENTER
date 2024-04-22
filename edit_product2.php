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

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['product_id'])) {
    $productId = $_GET['product_id'];

    // Load the product data from the database based on the ID
    $query = "SELECT * FROM products WHERE product_id = ?";
    $stmt = $dbHandler->prepare($query);
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    $productData = $result->fetch_assoc();

    $stmt->close();
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_product'])) {
        // Handle form submission to update product information
        $productId = $_POST['id'];
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $image = $_POST['image'];
        $stock = $_POST['stock'];

        $query = "UPDATE products SET name = ?, description = ?, price = ?, image_url = ?, stock_quantity = ? WHERE product_id = ?";
        $stmt = $dbHandler->prepare($query);
        $stmt->bind_param("sssisi", $name, $description, $price, $image, $stock, $productId);

        $stmt->execute();
        $stmt->close();
        // Redirect to the product records page after the update
        header("Location: edit_product.php"); // Added "header" function
        exit; // Exit after redirect
    } elseif (isset($_POST['delete_product'])) {
        // Handle form submission to delete a product
        $productId = $_POST['id']; // Corrected variable name

        // Delete the product information from the database
        $query = "DELETE FROM products WHERE product_id = ?";
        $stmt = $dbHandler->prepare($query);
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $stmt->close();

        // Redirect to the product records page after the delete
        header("Location: edit_product.php"); // Added "header" function
        exit; // Exit after redirect
    }
}
?>
<?php include("admin_navbar.php"); ?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Product Record</title>
</head>
<body>

<div class="container">
    <h1 class="text-center mt-4 mb-4">Edit Product Record</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $productData['product_id']; ?>">
        <div class="form-group">
            <label for="title">Name</label>
            <input type="text" class="form-control" id="title" name="name" value="<?php echo $productData['name']; ?>">
        </div>
        <div class="form-group">
            <label for="content">Description</label>
            <input type="text" class="form-control" id="description" name="description" value="<?php echo $productData['description']; ?>">
        </div>
        <div class="form-group">
            <label for="price">Price</label>
            <input type="text" class="form-control" id="price" name="price" value="<?php echo $productData['price']; ?>">
        </div>
        
        <div class="form-group">
            <label for="image">Image</label>
            <input type="text" class="form-control" id="image" name="image" value="<?php echo $productData['image_url']; ?>">
        </div>
        
        <div class="form-group">
            <label for="stock">Stock Quantity</label>
            <input type="text" class="form-control" id="stock" name="stock" value="<?php echo $productData['stock_quantity']; ?>">
        </div>

        <button type="submit" name="update_product" class="btn btn-warning">Update</button>
        <button type="submit" name="delete_product" class="btn btn-danger">Delete</button>
    </form>
</div>

<?php include("albab_footer.php");?>
</body>
</html>
