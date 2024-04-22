<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'ibdqwzul_albab');
define('DB_PASSWORD', 'Abdulmujeeb_623');
define('DB_NAME', 'ibdqwzul_albab');

class Product {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function addProduct($name, $description, $price, $image_url, $stock_quantity, $category_id) {
        // Validate product data
        if(empty($name) || empty($price) || empty($stock_quantity) || empty($category_id)) {
            return false;
        }

        // Insert product into database
        $stmt = $this->db->prepare("INSERT INTO products (name, description, price, image_url, stock_quantity, category_id) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdsii", $name, $description, $price, $image_url, $stock_quantity, $category_id);
        if($stmt->execute()) {
            echo "<script>alert('Product successfully inserted!'); window.location='albab_add_product.php'</script>";
    return true;
} else {
    echo "Failed to add product: " . $stmt->error;
    return false;
}
    }
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Initialize database connection
    $db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if($db->connect_errno) {
        die("Failed to connect to MySQL: " . $db->connect_error);
    }

    // Check if form is submitted for adding product
    if(isset($_POST['productName']) && isset($_POST['productDescription']) && isset($_POST['productPrice']) && isset($_POST['productStock']) && isset($_POST['productCategory'])) {
        $productName = $_POST['productName'];
        $productDescription = $_POST['productDescription'];
        $productPrice = floatval($_POST['productPrice']); // Ensure price is cast to float
        $productStock = intval($_POST['productStock']); // Ensure stock is cast to integer
        $productCategory = intval($_POST['productCategory']); // Ensure category is cast to integer

        // File upload
        $targetDir = "uploads/";
        $targetFile = $targetDir . basename($_FILES["productImage"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["productImage"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["productImage"]["size"] > 5000000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["productImage"]["tmp_name"], $targetFile)) {
                echo "The file ". htmlspecialchars(basename($_FILES["productImage"]["name"])). " has been uploaded.";

                // Create Product object
                $product = new Product($db);

                // Add product
                if($product->addProduct($productName, $productDescription, $productPrice, $targetFile, $productStock, $productCategory)) {
                    echo "<script>alert('Category successfully inserted!'); window.location='albab_add_product.php'</script>";
                } else {
                    echo "Failed to add product";
                }
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }

    // Close database connection
    $db->close();
}
?>
