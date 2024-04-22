
<?php
include('admin_navbar.php');

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
        $query = "SELECT * FROM categories ORDER BY category_id ASC";

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

$categoryInfo = $dbHandler->fetchAllResults();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Categories</title>
</head>
<body>

    <div class="container">
        <h1 class="text-center mt-4 mb-4">All Categories</h1>
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Quantity</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categoryInfo as $category) { ?>
                    <tr>
                        <td><?php echo $category['name']; ?></td>
                        <td><?php echo $category['image_url']; ?></td>
                        <td><?php echo $category['quantity']; ?></td> 
                        <td><a href="edit_category2.php?category_id=<?php echo $category['category_id']; ?>" class="btn btn-primary btn-sm">Edit</a></td>
                        <td><a href="edit_category2.php?category_id=<?php echo $category['category_id']; ?>" class="btn btn-primary btn-sm">Delete</a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

<?php include ("albab_footer.php"); ?>
</body>
</html>
