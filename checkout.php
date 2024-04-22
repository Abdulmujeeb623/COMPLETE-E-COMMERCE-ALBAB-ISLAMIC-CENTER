<?php 
session_start();
include('albab_navbar2.php');

// Include your database handler class
include('DatabaseHandler.php');

// Create an instance of your DatabaseHandler class
$dbHost = "localhost";
$dbUser = "ibdqwzul_albab";
$dbPass = "Abdulmujeeb_623";
$dbName = "ibdqwzul_albab";
try {
    $dbHandler = new DatabaseHandler($dbHost, $dbUser, $dbPass, $dbName);
} catch (Exception $e) {
    // Handle connection error
    echo "Connection failed: " . $e->getMessage();
    exit();
}

// Fetch products from the cart for the current user
$userId = $_SESSION['user_id'];
$cartItems = $dbHandler->fetchCartItems($userId);

// Check if remove button is clicked
if(isset($_POST['remove_item'])) {
    $productId = $_POST['product_id'];
    // Remove item from the cart
    $dbHandler->deleteCartItem($userId, $productId);
}

// Initialize subtotal and total price variables
$subtotal = 0;
$totalPrice = 0;

// Calculate total price
foreach ($cartItems as $item) {
    $totalPrice += $item['price'] * $item['quantity'];
    $subtotal += $item['price'] * $item['quantity'];
}

// Fetch user's email from the users table
$userEmail = '';
$user_id = $_SESSION['user_id'];
$sql = "SELECT email FROM users WHERE user_id = ?";
$stmt = $dbHandler->connection->prepare($sql); // Use $dbHandler->connection instead of $conn
$stmt->bind_param("s", $user_id);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($userEmail);
$stmt->fetch();
$stmt->close();

// Fetch billing information for the current user
$billingInfo = [];
$sql = "SELECT * FROM billing WHERE user_id = ?";
$stmt = $dbHandler->connection->prepare($sql);
$stmt->bind_param("s", $user_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $billingInfo = $result->fetch_assoc();

    // Extract billing information from the $billingInfo array
    $billingName = $billingInfo['name'];
    $billingEmail = $billingInfo['email'];
    $billingNumber = $billingInfo['number'];
    $billingAddress1 = $billingInfo['address1'];
    $billingAddress2 = $billingInfo['address2'];
    $billingCountry = $billingInfo['country'];
    $billingCity = $billingInfo['city'];
    $billingState = $billingInfo['state'];
}
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>ALBAB ISLAMIC CENTER - Checkout</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="keywords" content="Al-Bab Islamic Center, Checkout, Islamic materials, Islamic stores, Online shopping, Secure payment, Convenient checkout">
<meta name="description" content="Complete your purchase securely and conveniently at Al-Bab Islamic Center. Explore our wide selection of Islamic materials, proceed to checkout with ease, and make secure payments for your order. Experience hassle-free shopping and elevate your spiritual journey with us.">
<!-- Add your CSS and JavaScript files here -->
</head>
<!-- Page Header Start -->
<div class="container-fluid bg-secondary mb-5">
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
        <h1 class="font-weight-semi-bold text-uppercase mb-3">Checkout</h1>
        <div class="d-inline-flex">
            <p class="m-0"><a href="albab_dashboard.php">Home</a></p>
            <p class="m-0 px-2">-</p>
            <p class="m-0">Checkout</p>
        </div>
    </div>
</div>
<!-- Page Header End --><!-- Checkout Start -->
<!-- Checkout Start -->
<div class="container-fluid pt-5">
    <div class="row px-xl-5">
        <div class="col-lg-8">
            <!-- Billing and Shipping Address Forms -->
            <!-- Your billing and shipping address forms code goes here -->
            <div class="mb-4">
                <h4 class="font-weight-semi-bold mb-4">Billing Address</h4>
                <div class="row">
                <form id="registrationForm" class="col-12" method="post" action="billing_validate.php" enctype="multipart/form-data">
    <div class="form-group">
        <label>Full Name</label>
        <input class="form-control" type="text" name="your_name"  value="<?php echo isset($billingName) ? $billingName : ''; ?>">
    </div>

    <div class="form-group">
        <label>Email</label>
        <input class="form-control" type="text" name="your_email"  value="<?php echo isset($billingEmail) ? $billingEmail : ''; ?>">
    </div>
    <div class="form-group">
        <label>Mobile No</label>
        <input class="form-control" type="text" name="your_number"  value="<?php echo isset($billingNumber) ? $billingNumber : ''; ?>">
    </div>
    <div class="form-group">
        <label>Address Line 1</label>
        <input class="form-control" type="text" name="your_address1"  value="<?php echo isset($billingAddress1) ? $billingAddress1 : ''; ?>">
    </div>
    <div class="form-group">
        <label>Address Line 2</label>
        <input class="form-control" type="text" name="your_address2"  value="<?php echo isset($billingAddress2) ? $billingAddress2 : ''; ?>">
    </div>
    <div class="form-group">
        <label>Country</label>
        <select class="custom-select" name="your_country" required>
            <option value="Nigeria" <?php echo isset($billingCountry) && $billingCountry == 'Nigeria' ? 'selected' : ''; ?>>Nigeria</option>
            <option value="Ghana" <?php echo isset($billingCountry) && $billingCountry == 'Ghana' ? 'selected' : ''; ?>>Ghana</option>
            <!-- Add other options with similar logic -->
        </select>
    </div>
    <div class="form-group">
        <label>City</label>
        <input class="form-control" type="text" name="your_city" value="<?php echo isset($billingCity) ? $billingCity : ''; ?>" required>
    </div>
    <div class="form-group">
        <label>State</label>
        <input class="form-control" type="text" name="your_state"  value="<?php echo isset($billingState) ? $billingState : ''; ?>" required>
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-primary btn-block">Submit</button>
    </div>
</form>



                    <div class="col-md-12 form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="newaccount">
                            <label class="custom-control-label" for="newaccount">Create an account</label>
                        </div>
                    </div>
                    <div class="col-md-12 form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="shipto" data-toggle="collapse" data-target="#shipping-address">
                            <label class="custom-control-label" for="shipto">Ship to different address</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="collapse mb-4" id="shipping-address">
                <h4 class="font-weight-semi-bold mb-4">Shipping Address</h4>
                <div class="row">
                <form id="registrationForm" class="col-12" method="post" action="billing_validate.php" enctype="multipart/form-data">
    <div class="form-group">
        <label>Full Name</label>
        <input class="form-control" type="text" name="your_name" placeholder="Habeebat">
    </div>

    <div class="form-group">
        <label>Email</label>
        <input class="form-control" type="text" name="your_email" placeholder="example@email.com">
    </div>
    <div class="form-group">
        <label>Mobile No</label>
        <input class="form-control" type="text" name="your_number" placeholder="08033946730">
    </div>
    <div class="form-group">
        <label>Address Line 1</label>
        <input class="form-control" type="text" name="your_address1" placeholder="123 Street">
    </div>
    <div class="form-group">
        <label>Address Line 2</label>
        <input class="form-control" type="text" name="your_address2" placeholder="123 Street">
    </div>
    <div class="form-group">
        <label>Country</label>
        <select class="custom-select" name="your_country">
            <option selected>Nigeria</option>
            <option>Ghana</option>
            <option>South Africa</option>
            <option>Niger</option>
            <option>Ethoipia</option>
            <option>Afghanistan</option>
            <option>Egypt</option>
            <option>Tunisia</option>
            <option>Morrocco</option>
            <option>Albania</option>
            <option>Algeria</option>
        </select>
    </div>
    <div class="form-group">
        <label>City</label>
        <input class="form-control" type="text" name="your_city" placeholder="Ilorin">
    </div>
    <div class="form-group">
        <label>State</label>
        <input class="form-control" type="text" name="your_state" placeholder="Kwara">
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-primary btn-block">Submit</button>
    </div>
</form>


                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-secondary mb-5">
                <div class="card-header bg-secondary border-0">
                    <h4 class="font-weight-semi-bold m-0">Order Total</h4>
                </div>
                <div class="card-body">
                    <h5 class="font-weight-medium mb-3">Products</h5>
                    <!-- Display products dynamically -->
                    <?php foreach ($cartItems as $item): ?>
                        <div class="d-flex justify-content-between">
                            <p><?php echo $item['name']; ?></p>
                            <p><del>N</del><?php echo $item['price']; ?></p>
                        </div>
                    <?php endforeach; ?>
                    <hr class="mt-0">
                    <div class="d-flex justify-content-between mb-3 pt-1">
                        <h6 class="font-weight-medium">Subtotal</h6>
                        <h6 class="font-weight-medium"><del>N</del><?php echo $subtotal; ?></h6>
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
                </div>
            </div>
            <!-- Payment Options -->
            <!-- Your payment options code goes here -->

         <!-- Place Order Button -->
<!-- Place Order Button -->
<div class="card border-secondary mb-5">
    <div class="card-footer border-secondary bg-transparent">
        <div class="container">
            <form id="paymentForm">
                <div class="form-group">
                    
                <input type="hidden" id="amount" name="amount" value="<?php echo isset($totalPrice) ? ($totalPrice + 1000) * 100 : 0; ?>" readonly>


                </div>
                <div class="form-group">
                    <input type="hidden" class="form-control" id="email-address" name="email" value="<?php echo isset($billingEmail) ? $billingEmail : ''; ?>" readonly>
                </div>
                <div class="form-group">
                    <input type="hidden" class="form-control" id="full-name" name="full_name" value="<?php echo isset($_SESSION['name']) ? $_SESSION['name'] : ''; ?>" readonly>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-lg btn-block btn-primary font-weight-bold my-3 py-3">Place Order</button>
                </div>
            </form>
        </div>
    </div>
</div>
                    </div>
<!-- Checkout End -->

<!-- JavaScript scripts -->
<!-- JavaScript scripts -->
<script src="https://js.paystack.co/v1/inline.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const paymentForm = document.getElementById('paymentForm');
        paymentForm.addEventListener("submit", function (e) {
            e.preventDefault();
            payWithPaystack();
        });
    });

    function payWithPaystack() {
        let handler = PaystackPop.setup({
            key: 'pk_test_4a6d8385363cc819e8a0beed80acd88434d1d1d8', // Replace with your public key
            email: document.getElementById("email-address").value,
            full_name: document.getElementById("full-name").value,
            amount: parseFloat(document.getElementById("amount").value),  // Multiply by 100 for kobo
            ref: 'AlbabIslamic' + Math.floor((Math.random() * 1000000000) + 1),
            onClose: function () {
                alert('Transaction cancelled.');
                window.location.href = "https://www.albabislamiccenter.com.ng/checkout.php?transaction=cancel";
            },
            callback: function (response) {
                let message = 'Payment complete! Reference: ' + response.reference;
                alert(message);

                // Get the full name from the form field
                let full_name = document.getElementById("full-name").value;

                // Redirect to the verification page with the reference and full name
                window.location.href = "https://www.albabislamiccenter.com.ng/verify_transaction.php?reference=" + response.reference + "&full_name=" + encodeURIComponent(full_name);
            }
        });

        handler.openIframe();
    }
</script>
<!-- Footer -->
<?php include('albab_footer.php') ?>
