<?php include 'header.php'; ?>
<?php
Session::init();
$login = Session::get("userlogin");
$username = Session::get("userName");
$orderId = Session::get("createdOrderId");
if (!$login) {
    header("Location:login.php"); 
}
?>

<main class="mb-5"> 
        <div class="container px-4 px-lg-5">
		<div class="row gx-4 gx-lg-5 justify-content-center">
			<div class="col-md-10 col-lg-8 col-xl-7">
				<div class="section group">
				<div class="psuccess">
					<h2 class="fw-bold mt-5">Success</h2>
					<h3>Order Id: <?php echo $orderId; ?></h3>	
					<p>Thank you for your purchase! Your order will be processed.</p>		
					<a class="btn btn-primary" target="_blank" href="invoice_pdf.php" class="details">Order invoice</a>	
				</div>
			</div>
		</div>
	</div>
</main>
