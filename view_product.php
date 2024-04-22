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
    $query = "SELECT name, description, price, image_url, stock_quantity FROM products WHERE product_id = ?";
    $stmt = $dbHandler->prepare($query);
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    $productData = $result->fetch_assoc();

    $stmt->close();
} 

// Select other products
$query = "SELECT product_id, name, description, price, image_url, stock_quantity FROM products";
$stmt = $dbHandler->prepare($query);
$stmt->execute();
$result = $stmt->get_result();

$stmt->close();
?>

<?php include("albab_navbar.php"); ?>

<!-- Page Header Start -->
<div class="container-fluid bg-secondary mb-5">
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
        <h1 class="font-weight-semi-bold text-uppercase mb-3">Shop Detail</h1>
        <div class="d-inline-flex">
            <p class="m-0"><a href="">Home</a></p>
            <p class="m-0 px-2">-</p>
            <p class="m-0">Shop Detail</p>
        </div>
    </div>
</div>
<!-- Page Header End -->

<!-- Shop Detail Start -->
<div class="container-fluid py-5">
    <div class="row px-xl-5">
        <div class="col-lg-5 pb-5">
            <img src="<?php echo $productData['image_url']; ?>" alt="Product Image" class="img-fluid">
        </div>

        <div class="col-lg-7 pb-5">
            <h3 class="font-weight-semi-bold"><?php echo $productData['name']; ?></h3>
            <p class="mb-4"><?php echo $productData['description']; ?></p>
            <h3 class="font-weight-semi-bold mb-4"><del>N</del><?php echo $productData['price']; ?></h3>
            <p class="mb-4">Stock Quantity: <?php echo $productData['stock_quantity']; ?></p>
            <button class="btn btn-primary px-3"><i class="fa fa-shopping-cart mr-1"></i> Add To Cart</button>
        </div>
    </div>
</div>
<!-- Shop Detail End -->

<!-- You May Also Like Section -->
<div class="container-fluid py-5">
    <div class="text-center mb-4">
        <h2 class="section-title px-5"><span class="px-2">You May Also Like</span></h2>
    </div>
    <div class="row px-xl-5">
        <div class="col">
            <div class="owl-carousel related-carousel">
                <?php
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <div class="card product-item border-0">
                        <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                            <img class="img-fluid w-100" src="<?php echo $row['image_url']; ?>" alt="">
                        </div>
                        <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                            <h6 class="text-truncate mb-3"><?php echo $row['name']; ?></h6>
                            <div class="d-flex justify-content-center">
                                <h6><del>N</del><?php echo $row['price']; ?></h6><h6 class="text-muted ml-2"><del>N<?php echo $row['price']; ?></del></h6>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-between bg-light border">
                        <a href="view_product.php?product_id=<?php echo $row['product_id']; ?>" class="btn btn-primary btn-sm">View</a>
                            <a href="#" class="btn btn-sm text-dark p-0"><i class="fas fa-shopping-cart text-primary mr-1"></i>Add To Cart</a>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>
<!-- You May Also Like Section End -->

<?php include("albab_footer.php"); ?>
