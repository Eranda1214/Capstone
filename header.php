<?php 
include 'database/Database.php';
include 'classes/Session.php';
include 'classes/Cart.php';

spl_autoload_register(function ($class) {
    include_once "classes/".$class.".php";
});
$db = new Database();
$pd = new Product();
$cmr = new Customer();
$val = new Validation();
$crt = new Cart();
Session::init();
 ?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/png" href="images/favicon.png">
    <title>TheForge</title>
</head>


<nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark px-4 px-lg-5 shadow-lg">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="index.php">TheForge</a>
        <!-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button> -->
        <div class="collapse navbar-collapse ms-5" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-link text-light" href="index.php">Home</a>
                <a class="nav-link text-light mx-3" href="products.php">Products</a>
                <a class="nav-link text-light me-3" href="cart.php">Cart</a>
                <?php if(Session::get('userlogin')){ ?>
                    <a class="nav-link text-light" href="logout.php">Logout</a>
                <?php }else { ?>
                    <a class="nav-link text-light" href="login.php">Login</a>
                <?php } ?>
            </div>
        </div>
    </div>
</nav>
