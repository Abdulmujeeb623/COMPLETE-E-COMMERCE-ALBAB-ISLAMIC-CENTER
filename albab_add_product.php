<?php

class DatabaseHandler {
    private $connection;

    public function __construct($dbHost, $dbUser, $dbPass, $dbName) {
        // Create a database connection
        $this->connection = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    public function fetchAllResults() {
        // Modify your query to fetch all data and order by student name
        $query = "SELECT * FROM categories";

        $result = $this->connection->query($query);

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        return $data;
    }
}

$dbHost = "localhost";
$dbUser = "ibdqwzul_albab";
$dbPass = "Abdulmujeeb_623";
$dbName = "ibdqwzul_albab";
$dbHandler = new DatabaseHandler($dbHost, $dbUser, $dbPass, $dbName);

// Fetch categories
$categoryInfo = $dbHandler->fetchAllResults();


?>
<?php include("admin_navbar.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product and Category</title>
    <!-- Bootstrap CSS -->
   
</head>
<body>

<div class="container mt-5">

            <h3>Add Product</h3>
            <form  method="post" action="add_product.php" enctype="multipart/form-data">
            <div class="form-group">
                <label for="productName">Product Name:</label>
                <input type="text" class="form-control" id="productName" name="productName" required>
            </div>
            <div class="form-group">
                <label for="productDescription">Description:</label>
                <textarea class="form-control" id="productDescription" name="productDescription"></textarea>
            </div>
            <div class="form-group">
                <label for="productPrice">Price:</label>
                <input type="number" class="form-control" id="productPrice" name="productPrice" required>
            </div>
            <div class="form-group">
                <label for="productImage">Image:</label>
                <input type="file" class="form-control-file" id="productImage" name="productImage" required>
            </div>
            <div class="form-group">
                <label for="productStock">Stock Quantity:</label>
                <input type="number" class="form-control" id="productStock" name="productStock" required>
            </div>
            <div class="form-group">
    <label for="productCategory">Category:</label>
    <select class="form-control" id="productCategory" name="productCategory">
        <?php foreach ($categoryInfo as $category): ?>
            <option value="<?php echo $category['category_id']; ?>"><?php echo $category['name']; ?></option>
        <?php endforeach; ?>
    </select>
</div>
    <button type="submit" class="btn btn-primary">Add Product</button>
            </form>
       
</div>
<?php include("albab_footer.php"); ?>


</body>
</html>
