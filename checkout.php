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

<?php
Session::init();
$login = Session::get("userlogin");
$username = Session::get("userName");
$idUsers = Session::get("userID");
if (!$login) {
    header("Location:login.php"); 
}

?>

<?php 
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['addOrders'])) {

    $orderId = $crt->addOrders($_POST);

    // if orderId is not an array, it is a number
    if(!is_array($orderId)) {

        foreach ($_SESSION['orderItems'] as $value) {
            var_dump($value);
            $crt->addOrderItem($orderId, $_SESSION['userID'], $value['productId'], $value['quantity']);
        }
    
        unset($_SESSION['orderItems']);
        unset($_SESSION['cart']);
    
        header("Location:success.php");
    }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/png" href="images/favicon.png">
    <title>Checkout</title>
</head>
<body>
<main class="mb-5"> 
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-md-10 col-lg-8 col-xl-7">
                    <h1 class="fw-bold mb-5 mt-5">Checkout</h1>
                    <form action="" method="POST">
                        <h2 class="mb-4">Shipping Details </h2>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="name" class="form-label">Address</label>
                                    <input type="text" class="form-control"  placeholder="Enter Address" name="orderAddress" value="<?php if (isset($orderId["orderAddressValue"])) echo $orderId["orderAddressValue"]; ?>">
                                    <?php if (isset($orderId["orderAddress"])) echo $orderId["orderAddress"]; ?>
                                </div>

                                <div class="col-md-4">
                                    <label for="city" class="form-label">City</label>
                                    <input type="text" class="form-control" placeholder="City" name="orderCity" value="<?php if (isset($orderId["orderCityValue"])) echo $orderId["orderCityValue"]; ?>">
                                    <?php if (isset($orderId["orderCity"])) echo $orderId["orderCity"]; ?>
                                </div>

                                <div class="col-md-4">
                                    <label for="Province" class="form-label">Province</label>
                                    <input type="text" class="form-control" placeholder="Province" name="orderProvince" value="<?php if (isset($orderId["orderProvinceValue"])) echo $orderId["orderProvinceValue"]; ?>">
                                    <?php if (isset($orderId["orderProvince"])) echo $orderId["orderProvince"]; ?>
                                </div>
                            </div>
                
                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <label for="zip" class="form-label">Postal Code</label>
                                    <input type="text" class="form-control" placeholder="Postal Code" name="orderPostalCode" value="<?php if (isset($orderId["orderPostalCodeValue"])) echo $orderId["orderPostalCodeValue"]; ?>">
                                    <?php if (isset($orderId["orderPostalCode"])) echo $orderId["orderPostalCode"]; ?>
                                </div>
                    
                                <div class="col-md-4">
                                    <label for="country" class="form-label">Country</label>
                                    <input type="text" class="form-control" placeholder="country" name="orderCountry" value="<?php if (isset($orderId["orderCountryValue"])) echo $orderId["orderCountryValue"]; ?>">
                                    <?php if (isset($orderId["orderCountry"])) echo $orderId["orderCountry"]; ?>
                                </div>
                                <div class="col-md-4">
                                    <label for="country" class="form-label">Phone Number</label>
                                    <input type="text" class="form-control" placeholder="orderPhone" name="orderPhone" value="<?php if (isset($orderId["orderPhoneValue"])) echo $orderId["orderPhoneValue"]; ?>">
                                    <?php if (isset($orderId["orderPhone"])) echo $orderId["orderPhone"]; ?>
                                </div>
                            </div>
                    
                            <h2 class="mb-4 mt-5"> Payment Information</h2>

                            <div class="row mb-5">
                                <div class="col-md-6">
                                    <label for="card-num" class="form-label">Credit Card No.</label>
                                    <input type="text" class="form-control" placeholder="Enter Card Number" name="card-num" >
                                    <?php if (isset($orderId["cardNum"])) echo $orderId["cardNum"]; ?>
                                </div>
                        
                                <div class="col-md-3">
                                    <label for="card-num" class="form-label">Exp</label>
                                    <input type="text" class="form-control"  placeholder="Enter Exp Date" name="expire" >
                                    <?php if (isset($orderId["cardExpiry"])) echo $orderId["cardExpiry"]; ?>
                                </div>
                            
                                <div class="col-md-3">
                                    <label for="card-num" class="form-label">CVV</label>
                                    <input type="text" class="form-control" placeholder="Enter CVV" name="security" >
                                    <?php if (isset($orderId["cardCvv"])) echo $orderId["cardCvv"]; ?>
                                </div>
                            </div>
                            <?php 
                                foreach ($_SESSION['orderItems'] as $value) {
                                    $price[] = ($value['quantity'] * $value['productPrice']); 
                                }
                                echo "<h3 class='fw-bold mb-4'>Total: $".array_sum($price)."</h3>";
                            ?>
                            <input type="hidden"  name="idUsers" value="<?php echo $_SESSION['userID'] ?>">
                            <div class="d-flex">
                                <button type="submit" name="addOrders" class="btn btn-primary me-4">Place Order</button>
                                <a href="cart.php" class="btn btn-danger">Cancel</a>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>