<?php
require("includes/functions.php");
session_start();

check_login_redirect($_SESSION, "myproducts.php");

if (has_permissions($_SESSION['user']['permissions'], array(1)) && 
    isset($_SESSION['user']) && isset($_POST['product']) && isset($_FILES['upload'])) {
    print_r($_POST['category']);
    create_product($mysqli, $_SESSION['user'], $_POST, $_FILES['upload']['name'], $_FILES['upload']['tmp_name']);
}

if (has_permissions($_SESSION['user']['permissions'], array(16)) 
    && isset($_GET["availability"]) && isset($_GET["edit_product"])) {
    set_product_availability($mysqli, $_GET["edit_product"], $_GET["availability"]);
}

if (has_permissions($_SESSION['user']['permissions'], array(1, 2, 4)) 
    && isset($_GET['product_id']) && isset($_POST['add_inventory'])) {
    add_inventory($mysqli, $_GET['product_id'], $_POST['inventory']);
}

?>

<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Signin Template for Bootstrap</title>
        <link href="css/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <script src="css/bootstrap/dist/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="product-container">
            <?php 
            if (has_permissions($_SESSION['user']['permissions'], array(1, 2, 4)) && isset($_SESSION['user'])) {
                display_all_products($mysqli);
            } else if (isset($_SESSION['user'])) {
                display_my_products($mysqli, $_SESSION['user']['user_id']);
            }
            ?>
            <a class="add-product-button btn btn-sm btn-outline-secondary"  href="#" data-toggle="modal" data-target="#exampleModal">Add Product</a>
        </div>
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <form id="productform" action="myproducts.php" method="post" enctype="multipart/form-data">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">New Product</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                Product name: <input class="form-control" type="text" name="name"><br>
                Description: <input class="form-control" type="text" name="description"><br>
                Price: <input class="form-control" type="decimal" step="0.01" name="price"><br>
                Image : <input class="form-control-file" type="file" name="upload" id="upload"><br>

            <select class="category-select form-control" name="category" form="productform">
                <?php display_category_form($mysqli) ?>
            </select>

                        </div>
                        <div class="modal-footer">
                <button class="btn btn-lg btn-primary btn-block product-btn" type="submit" name="product">Submit</button>
                        </div>
                    </div>
            </form>
            </div>
        </div>
    </body>
</html>