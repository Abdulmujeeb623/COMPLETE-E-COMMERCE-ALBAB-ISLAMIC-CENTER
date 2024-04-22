<?php 


// Check if the user is logged in
if (isset($_SESSION['user_id']) && $_SESSION['user_id'] === true) {
    include('albab_navbar2.php'); // If logged in, use navbar2
} else {
    include('albab_navbar.php'); // If not logged in, use navbar
}
?>