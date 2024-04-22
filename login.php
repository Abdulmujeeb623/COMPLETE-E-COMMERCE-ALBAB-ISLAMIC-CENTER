<?php session_start(); ?>
<?php

error_reporting(0);

class Database {
    private $conn;

    public function __construct($host, $username, $password, $database) {
        $this->conn = new mysqli($host, $username, $password, $database);
    }

    public function getConnection() {
        return $this->conn;
    }

    public function closeConnection() {
        $this->conn->close();
    }
}

class Authentication {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    private function testInput($x) {
        $x = trim($x);
        $x = stripslashes($x);
        $x = htmlspecialchars($x);
        return $x;
    }

    public function authenticate($name, $password) {
        $conn = $this->db->getConnection();
        $name = $this->testInput($name);
        $password = $this->testInput($password);

        $sql = "SELECT user_id FROM users WHERE username=? AND password=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $name, $password);
        
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows) {
                // Retrieve the user_id and set it as a session variable
                $user = $result->fetch_assoc();
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['name'] = $name;
                header('Location: albab_dashboard.php');
                exit();
            } else {
                return "Wrong username and/or password";
            }
        }
        
        $stmt->close();
        return null;
    }
}


$database = new Database("localhost", "ibdqwzul_albab", "Abdulmujeeb_623", "ibdqwzul_albab");
$auth = new Authentication($database);

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $name = $_POST['name'];
    $password = $_POST['password'];
    
    if (!empty($name) && !empty($password)) {
        $err = $auth->authenticate($name, $password);
    }

    $database->closeConnection();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>ALBAB ISLAMIC CENTER - Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="Al-Bab Islamic Center, Login, Islamic Center, Membership">
    <meta name="description" content="Welcome to the login page of Al-Bab Islamic Center. Login to access exclusive member features, update your profile, and explore our offerings.">
    

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet"> 

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    <style>
        .whatsapp-button {
          display: inline-block;
          background-color: #25d366;
          color: #fff;
          padding: 10px 20px;
          border-radius: 5px;
          text-decoration: none;
          font-weight: bold;
        }
        
        .whatsapp-button img {
          width: 20px;
          margin-right: 10px;
        }
    </style>
</head>

<body>           
<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="sign-in-form p-4">
          <img src="img/albab.jpg" style="height: 200px; width: 300px; padding: 10px;  margin-top: -10px;" alt="Logo" class="img-fluid">
    </a>
        <h1 class="text-center">Welcome to AIC</h1>
        <h2 class="text-center">Log in</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                <input type="text" id="name" name="name" placeholder="Please enter your name" class="form-control" title="Enter your name" required />
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                <input type="password" id="password" name="password" class="password form-control" placeholder="~~~~~~~~~~" title="Enter your password" required />
                <span class="show-password">Show Password</span>
             </div>
            <div class="mb-3 text-center">
                <input type="submit" name="submit" value="Log in" class="btn btn-primary" title="Log in" />
                <input type="reset" name="cancel" value="Cancel" class="btn btn-danger" title="Cancel" />
            </div>
            <div class="mb-3 text-center">
                <a href="#" style="background-color: black; color: white; padding: 5px; text-decoration: none;">Forgotten password</a>
            </div>
        </form>
        <?php
        echo "<div class=\"red\">";
        if (isset($err))
            echo $err;
        echo "</div>";
        ?>
    </div>
</div>

<!-- jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        $('.show-password').on('click', function() {
            var passwordInput = $('input[name="password"]');
            if (passwordInput.attr('type') === 'password') {
                passwordInput.attr('type', 'text');
            } else {
                passwordInput.attr('type', 'password');
            }
        });
    });
</script>

</body>
</html>
