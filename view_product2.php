<?php
session_start();
include('cart_validate.php');

$host = "localhost";
$username = "ibdqwzul_albab";
$password = "Abdulmujeeb_623";
$database = "ibdqwzul_albab";

$dbHandler = new mysqli($host, $username, $password, $database);

if ($dbHandler->connect_error) {
    die("Connection failed: " . $dbHandler->connect_error);
}

$productId = $_GET['product_id'];

$query = "SELECT name, description, price, image_url, stock_quantity FROM products WHERE product_id = ?";
$stmt = $dbHandler->prepare($query);
$stmt->bind_param("i", $productId);
$stmt->execute();
$result = $stmt->get_result();
$productData = $result->fetch_assoc();
$stmt->close();


?>


<?php include('albab_navbar2.php'); ?>



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
            <div class="card-footer d-flex justify-content-between bg-light border align-items-center">
                <form method="post"  class="d-flex align-items-center">
                    <input type="hidden" name="product_id" value="<?php echo $productId; ?>">
                    <input type="number" name="quantity" value="1" min="1" class="form-control mr-2" style="width: 80px;">
                    <button type="submit" name="add_to_cart" class="btn btn-primary">
                        <i class="fas fa-shopping-cart mr-2"></i>Add To Cart
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Shop Detail End -->
<!-- You May Also Like Section -->

<?php include('albab_footer.php'); ?>