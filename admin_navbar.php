
<?php include('all_category.php'); ?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>ALBAB ISLAMIC CENTER</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Islmaic Store" name="keywords">
    <meta content="Islamic Store" name="description">

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
    <!-- Topbar Start -->
    <div class="container-fluid">
        <div class="row bg-secondary py-2 px-xl-5">
            <div class="col-lg-6 d-none d-lg-block">
                <div class="d-inline-flex align-items-center">
                    <a class="text-dark" href="">FAQs</a>
                    <span class="text-muted px-2">|</span>
                    <a class="text-dark" href="">Help</a>
                    <span class="text-muted px-2">|</span>
                    <a class="text-dark" href="">Support</a>
                </div>
            </div>
            <div class="col-lg-6 text-center text-lg-right">
                <div class="d-inline-flex align-items-center">
                    <a class="text-dark px-2" href="https://web.facebook.com/habeebheart.otuyo">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a class="text-dark px-2" href="https://web.facebook.com/habeebheart.otuyo">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a class="text-dark px-2" href="https://web.facebook.com/habeebheart.otuyo">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a class="text-dark px-2" href="https://web.facebook.com/habeebheart.otuyo">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a class="text-dark pl-2" href="https://web.facebook.com/habeebheart.otuyo">
                        <i class="fab fa-youtube"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="row align-items-center py-3 px-xl-5">
            <div class="col-lg-3 d-none d-lg-block">
                <a href="" class="text-decoration-none">
                    <h5 class="m-0 display-5 font-weight-semi-bold"><span class="text-primary font-weight-bold border px-3 mr-1">Al-Bab</span>Islamic Center</h5>
                </a>
            </div>
            <div class="col-lg-6 col-6 text-left">
                <form action="">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search for products">
                        <div class="input-group-append">
                            <span class="input-group-text bg-transparent text-primary">
                                <i class="fa fa-search"></i>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-3 col-6 text-right">
                <a href="" class="btn border">
                    <i class="fas fa-heart text-primary"></i>
                    <span class="badge">0</span>
                </a>
                <a href="" class="btn border">
                    <i class="fas fa-shopping-cart text-primary"></i>
                    <span class="badge">0</span>
                </a>
            </div>
        </div>
    </div>
    <!-- Topbar End -->


    <!-- Navbar Start -->
    <div class="container-fluid mb-5">
        <div class="row border-top px-xl-5">
            <div class="col-lg-3 d-none d-lg-block">
    <a class="btn shadow-none d-flex align-items-center justify-content-between bg-primary text-white w-100" data-toggle="collapse" href="#navbar-vertical" style="height: 65px; margin-top: -1px; padding: 0 30px;">
        <h6 class="m-0">Categories</h6>
        <i class="fa fa-angle-down text-dark"></i>
    </a>
    <nav class="collapse show navbar navbar-vertical navbar-light align-items-start p-0 border border-top-0 border-bottom-0" id="navbar-vertical">
        <div class="navbar-nav w-100 overflow-hidden" style="height: 410px">
            <?php foreach ($categoryInfo as $category): ?>
                <a href="view_category.php?category_id=<?php echo $category['category_id']; ?>" class="nav-item nav-link"><?php echo $category['name']; ?></a>
            <?php endforeach; ?>
        </div>
    </nav>
</div>

            <div class="col-lg-9">
            <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0">
                    <a href="" class="text-decoration-none d-block d-lg-none">
                        <h5 class="m-0 display-5 font-weight-semi-bold"><span class="text-primary font-weight-bold border px-3 mr-1">Al-Bab</span>Islamic Center</h5>
                    </a>
                    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                        <div class="navbar-nav mr-auto py-0">
                            <a href="albab_dashboard.php" class="nav-item nav-link active">Home</a>
                            <a href="shop.php" class="nav-item nav-link">Shop</a>
                            <a href="detail.html" class="nav-item nav-link">News</a>
                            <a href="sales.php" class="nav-item nav-link">Sales</a>
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Admins</a>
                                <div class="dropdown-menu rounded-0 m-0">
                                    <a href="add_admin.php" class="dropdown-item">Add Admins</a>
                                    <a href="edit_admin.php" class="dropdown-item">Edit Admins</a>
                                    <a href="edit_admin.php" class="dropdown-item">Delete Admins</a>
                                    
                                </div>
                            </div>
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Products</a>
                                <div class="dropdown-menu rounded-0 m-0">
                                    <a href="albab_add_product.php" class="dropdown-item">Add product</a>
                                    <a href="edit_product.php" class="dropdown-item">Edit product</a>
                                    <a href="edit_product.php" class="dropdown-item">Delete product</a>
                                    
                                </div>
                            </div>
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Categories</a>
                                <div class="dropdown-menu rounded-0 m-0">
                                    <a href="add_category_form.php" class="dropdown-item">Add category</a>
                                    <a href="edit_category.php" class="dropdown-item">Edit Category</a>
                                    <a href="edit_category.php" class="dropdown-item">Delete Category</a>
                                    
                                </div>
                            </div>
                            <a href="contact_list.php" class="nav-item nav-link">Contact</a>
                        </div>
                        <div class="navbar-nav ml-auto py-0">
                            <a href="log_out.php" class="nav-item nav-link">Logout</a>
                            
                        </div>
                   
                </nav>
            </div>
        </div>
    </div>
    
    <!-- Navbar End -->
    