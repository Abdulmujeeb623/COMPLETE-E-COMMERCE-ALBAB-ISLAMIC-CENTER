
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
        $query = "SELECT * FROM products ORDER BY product_id ASC";

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

$productInfo = $dbHandler->fetchAllResults();

?>
<?php include('admin_navbar.php');?>

<!DOCTYPE html>
<html>
<head>
    <title>Product Records</title>
</head>
<body>

    <div class="container">
        <h1 class="text-center mt-4 mb-4">Product Records</h1>
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Images</th>
                    <th>Quantity</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productInfo as $product) { ?>
                    <tr>
                        <td><?php echo $product['name']; ?></td>
                        <td><?php echo $product['description']; ?></td>
                        <td><?php echo $product['price']; ?></td>
                        <td><?php echo $product['image_url']; ?></td>
                        <td><?php echo $product['stock_quantity']; ?></td> 
                        <td><a href="edit_product2.php?product_id=<?php echo $product['product_id']; ?>" class="btn btn-primary btn-sm">Edit</a></td>
                        <td><a href="edit_product2.php?product_id=<?php echo $product['product_id']; ?>" class="btn btn-danger btn-sm">Delete</a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

<?php include("albab_footer.php");?>
</body>
</html>
