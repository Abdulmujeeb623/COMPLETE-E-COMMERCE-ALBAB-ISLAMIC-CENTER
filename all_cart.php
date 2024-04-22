<?php 
session_start();
include('albab_navbar2.php');

// Database connection
$mysqli = new mysqli("localhost", "ibdqwzul_albab", "Abdulmujeeb_623", "ibdqwzul_albab");

if ($mysqli->connect_error) {
    die("Database connection failed: " . $mysqli->connect_error);
}

// Fetch products from the cart for the current user
$userId = $_SESSION['user_id'];
$query = "SELECT cart.*, products.name, products.price, products.image_url, products.description FROM cart JOIN products ON cart.product_id = products.product_id WHERE cart.user_id = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

$cartItems = [];
while ($row = $result->fetch_assoc()) {
    $cartItems[] = $row;
}

// Check if remove button is clicked
if(isset($_POST['remove_item'])) {
    $productId = $_POST['product_id'];
    // Remove item from the cart
    $query = "DELETE FROM cart WHERE user_id = ? AND product_id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("ii", $userId, $productId);
    $stmt->execute();
    // Check if the deletion was successful
    if ($stmt->affected_rows > 0) {
        // Item removed successfully
        echo "<script>alert('Product successfully deleted!'); window.location='all_cart.php'</script>";
    } else {
        // Failed to remove item
        echo "Failed to remove item.";
    }
}

// Calculate total price
$totalPrice = 0;
foreach ($cartItems as $item) {
    $totalPrice += $item['price'] * $item['quantity'];
}
?>

<!-- Page Header Start -->
<div class="container-fluid bg-secondary mb-5">
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
        <h1 class="font-weight-semi-bold text-uppercase mb-3">Carts</h1>
        <div class="d-inline-flex">
            <p class="m-0"><a href="albab_dashboard.php">Home</a></p>
            <p class="m-0 px-2">-</p>
            <p class="m-0">Carts</p>
        </div>
    </div>
</div>

<!-- Cart Start -->
<div class="container pt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered text-center">
                    <thead class="bg-secondary text-dark">
                        <tr>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Total</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cartItems as $item): ?>
                            <tr>
                                <td>
                                    <img src="<?php echo $item['image_url']; ?>" alt="" style="max-width: 50px; height: auto;">
                                    <?php echo $item['name']; ?>
                                </td>
                                <td><del>N</del><?php echo $item['price']; ?></td>
                                <td>
                                    <div class="input-group quantity" style="max-width: 100px;">
                                        <div class="input-group-prepend">
                                            <button class="btn btn-sm btn-primary btn-minus">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                        </div>
                                        <input type="text" class="form-control form-control-sm bg-secondary text-center" value="<?php echo $item['quantity']; ?>">
                                        <div class="input-group-append">
                                            <button class="btn btn-sm btn-primary btn-plus">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                                <td><del>N</del><?php echo $item['price'] * $item['quantity']; ?></td>
                                <td>
                                    <form method="post">
                                        <input type="hidden" name="product_id" value="<?php echo $item['product_id']; ?>">
                                        <button type="submit" name="remove_item" class="btn btn-sm btn-primary">
                                            <i class="fa fa-times"></i> 
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card border-secondary">
                <div class="card-header bg-secondary border-0">
                    <h4 class="font-weight-semi-bold m-0">Cart Summary</h4>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3 pt-1">
                        <h6 class="font-weight-medium">Subtotal</h6>
                        <h6 class="font-weight-medium"><del>N</del><?php echo $totalPrice; ?></h6>
                    </div>
                    <div class="d-flex justify-content-between">
                        <h6 class="font-weight-medium">Shipping</h6>
                        <h6 class="font-weight-medium"><del>N</del>1000</h6>
                    </div>
                </div>
                <div class="card-footer border-secondary bg-transparent">
                    <div class="d-flex justify-content-between mt-2">
                        <h5 class="font-weight-bold">Total</h5>
                        <h5 class="font-weight-bold"><del>N</del><?php echo $totalPrice + 1000; ?></h5>
                    </div>
                    <button onclick="proceedToCheckout()" class="btn btn-block btn-primary my-3 py-3">Proceed To Checkout</button>
                </div>
            </div>
        </div>
    </div>
</div><!-- Cart End -->
<script>
    function proceedToCheckout() {
        // Redirect to checkout.php
        window.location.href = "checkout.php";
    }
</script>

<?php include('albab_footer.php') ?>
