<?php include("admin_navbar.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Category</title>
    <!-- Bootstrap CSS -->
   
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2>Add Category</h2>
            <form action="add_category_validate.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="categoryName">Category Name</label>
                    <input type="text" class="form-control" id="categoryName" name="category_name" required>
                </div>
                <div class="form-group">
                    <label for="categoryImage">Image</label>
                    <input type="file" class="form-control-file" id="categoryImage" name="category_image" required>
                </div>
                <div class="form-group">
                    <label for="categoryName">Quantity</label>
                    <input type="number" class="form-control" id="categoryStock" name="category_stock" required>
                </div>
                <button type="submit" class="btn btn-primary">Add Category</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>
<?php include("albab_footer.php"); ?>
