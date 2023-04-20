<?php include 'header.php'; ?>

<?php
if (isset($_GET['idProducts'])) {
    $idProducts = preg_replace('/[^-a-zA-Z0-9_]/', '', $_GET['idProducts']);
} ?>

<div class="main mt-5 mb-5">
	<div class="content">
		<div class="section">
			<div class="container">
				<?php 
                $getPd = $pd->getSingleProduct($idProducts);
                if ($idProducts) {
                    while ($result = $getPd->fetch_assoc()) {
                        ?>
				<div class="products">
					<h1 class="fw-bold mb-4"><?php echo $result['productName']; ?></h1>
					<div class="d-flex">
						<div>
							<img src="images/<?php echo $result['productImage']; ?>" alt="">
						</div>
						<div class="ms-5 mt-5">
							<h3 class="fw-bold mt-4">Product Details</h3>
							<p><?php echo $result['productDesc']; ?></p>
							<h4 class="fw-bold text-success mt-4">$<?php echo $result['productPrice']; ?></h4>
							<div class="d-flex  mt-4">
								<p class="fw-bold me-2">Category: </p>
								<p><?php echo $result['categoryName']; ?></p>
							</div>
							<div class="d-flex">
								<p class="fw-bold me-2">Brand: </p>
								<p><?php echo $result['brandName']; ?></p>
							</div>
							<?php
		
							require_once ("classes/component.php");

							
							//Add to cart
							if (isset($_POST['add'])){

								$login = Session::get("userlogin");
								$idUsers = Session::get("userID");
								if ($login === false) {
									echo "<p class='text-danger fw-bold'>Please login to add this product to your cart. Go to <a href='login.php'>Login Page</a></p>";
									break;
								} 

								/// print_r($_POST['product_id']);
								if(isset($_SESSION['cart'])){

									$item_array_id = array_column($_SESSION['cart'], "product_id");

									if(in_array($_POST['product_id'], $item_array_id)){
										echo "<div class='alert alert-danger' role='alert'> This product is already in your <a href='cart.php'>cart</a>.</div>";
									}else{

										$count = count($_SESSION['cart']);
										$item_array = array(
											'product_id' => $_POST['product_id']
										);
										$_SESSION['cart'][$count] = $item_array;
										echo "<div class='alert alert-primary' role='alert'> Successfully added to your cart! </div>";
									}

								}else {

									$item_array = array(
										'product_id' => $_POST['product_id']
									);
									// Create new session variable
									$_SESSION['cart'][0] = $item_array;
									echo "<div class='alert alert-success' role='alert'> Successfully added to your cart! </div>";
								}
							
							}	
							?>

							<div class="add-cart">
								<form action="" method="post">
									<input type="hidden" name="product_id" value="<?php echo $_GET['idProducts'] ?>" />
									<input class="btn btn-danger mt-4" type="submit" name="add" value="Add To Cart"/>
								</form>
							</div>	
						</div>
					</div>
					
				</div>
				<?php
                    }
                } ?>
			</div>
		</div>
	</div>