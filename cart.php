<?php include 'header.php'; ?>
<?php
Session::init();
$login = Session::get("userlogin");
$username = Session::get("userName");
if (!$login) {
    header("Location:login.php"); 
}
?>
<?php 
if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])){
    if (isset($_POST['proceed'])) {
    
    $orderItems = json_decode($_POST['proceed'], true);

    Session::set('orderItems', $orderItems);
    header("Location:checkout.php"); 
    }
}
 ?>
<!DOCTYPE html>
<html lang="en">
<body>
    <?php
        require_once ('classes/component.php'); 
        require_once ("database/Database.php");
    ?>
<main>
    <div class="main mt-5 mb-5">
        <div class="content">
            <div class="section">
                <div class="container col-md-5">
                    <div class="shopping-cart">
                        <h1 class="fw-bold mb-5">My Cart</h1>
                        <?php

                            if (isset($_POST['remove'])){
                                if ($_GET['action'] == 'remove'){
                                    foreach ($_SESSION['cart'] as $key => $value){
                                        if($value["product_id"] == $_GET['id']){
                                            unset($_SESSION['cart'][$key]);
                                            echo "<div class='alert alert-danger' role='alert'> Product removed from your cart.</div>";
                                            header( "refresh:3; url=cart.php" ); 
                                        }
                                    }
                                }
                            }

                        ?>

                        <?php
                        
                        $total = 0;
                        if (isset($_SESSION['cart'])){

                            if($_SESSION['cart'] == null || !isset($_SESSION['cart'])) {
                                ?>
                                <h4 class="text-danger mt-5 fw-bold">Cart is Empty</h4>
                                <?php
                            }

                            $productid = array_column($_SESSION['cart'], 'product_id');

                            $result = $db->getData();
                            while ($row = mysqli_fetch_assoc($result)){
                                foreach ($productid as $id){
                                    if ($row['idProducts'] == $id){
                                        cartElement($row['productImage'], $row['productName'],$row['productPrice'], $row['idProducts']);
                                        $total = $total + (float)$row['productPrice'];
                                    }
                                }
                            }
                        } else {
                            echo "<h4 class=\"text-danger mt-5 fw-bold\">Cart is Empty</h4>";
                        }
                        ?>

                        <div class="border rounded mt-5 w-100">

                            <div class="m-5">
                                <h5 class="fw-bold">ORDER DETAILS</h5>
                                <hr>
                                <div class="row price-details">
                                    <div class="col-md-6">
                                        <?php
                                            if (isset($_SESSION['cart'])){
                                                $count  = count($_SESSION['cart']);
                                                echo "<h6 class=\"fw-bold\">Price ($count items)</h6>";
                                            }else{
                                                echo "<h6>Price (0 items)</h6>";
                                            }
                                        ?>
                                        <h6 class="fw-bold">Delivery Charges</h6>
                                        <hr>
                                        <h5 class="fw-bold">Amount Payable</h5>
                                    </div>
                                    <div class="col-md-6">
                                        <h6>$<?php echo $total; ?></h6>
                                        <h6 class="text-success">FREE</h6>
                                        <hr>
                                        <h5 class="fw-bold">$<?php echo $total;?></h5>
                                    </div>
                                    <button id="proceedBtn" class="btn btn-primary col-md-4 mt-4">Proceed to Checkout</button>
                                    <form action="" method="post" id="proceedForm">
                                        <input type="hidden" name="proceed" id="proceedInput" />
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>                                
        </div>
    </div>
</main>
<script>
    const btn = document.getElementById('proceedBtn');
    btn.addEventListener('click', submitHandler);
    function submitHandler() {
        const quantities = document.getElementsByClassName('product-price');
        const mapping = [];
        for (quantity of quantities) {
            const input = document.getElementById('productId' + quantity.dataset.productId)
            mapping.push({
                productId: quantity.dataset.productId,
                productPrice: quantity.dataset.productPrice,
                quantity: input.value
            });
        }

        document.getElementById('proceedInput').value = JSON.stringify(mapping);
        const form = document.getElementById('proceedForm');
        form.submit();
    }
</script>
</body>
</html>