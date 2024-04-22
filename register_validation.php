<?php
function test_input($data) {
    $data = trim($data);          
    $data = stripslashes($data);    
    $data = htmlspecialchars($data); 
    return $data;
}

// Connect to the MySQL database
$servername = "localhost";
$username = "ibdqwzul_albab";
$password = "Abdulmujeeb_623";
$dbname = "ibdqwzul_albab";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_name = test_input($_POST['user_name']);
    $email = test_input($_POST['email']);
    $pass1 = test_input($_POST['pass1']);
    $role = test_input($_POST['role']);

    //  hash the password before storing it in the database for security.
    

    $sql = "INSERT INTO users (username, email, password, role) VALUES ('$user_name', '$email', '$pass1', '$role')";

    if ($conn->query($sql) === true) {
        echo "<script>alert('Account successfully created!'); window.location='login.php'</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
