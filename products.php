<?php include 'header.php'; ?>

<?php
session::init();
$login = Session::get("userlogin");
$idUsers = Session::get("userID");?>

<div class="main mb-5 mt-5">
    <div class="content">
		<div class="section">
			<div class="container">
                <div class="content">
                    <div class="heading mb-4">
                        <h1 class="fw-bold mb-5">Products</h1>
                    </div>
                    <h4 class="fw-bold mb-3 text-secondary">Filter Products</h4>
                    <div>
                        <form id="filter" method="post">
                            <div class="d-flex">
                                <div>
                                    <h5 class="fw-bold">Brands</h5>
                                    <div class="d-flex flex-wrap">
                                        <?php 
                                        $getBrand = $pd->getAllBrands();
                                        if ($getBrand) {
                                            while ($result = $getBrand->fetch_assoc()) {
                                                ?>
                                                <div class="me-4 mb-2">
                                                    <input type="checkbox" name="brand[]" value="<?php echo $result['idBrand']; ?>" class="form-check-input"/>
                                                    <label for="brand"><?php echo $result['brandName']; ?></label><br>
                                                </div>
                                                <?php
                                            }
                                        }?>
                                    </div>
                                </div>

                                <div class="ms-4">
                                    <h5 class="fw-bold">Categories</h5>
                                    <div class="d-flex flex-wrap">
                                        <?php 
                                        $getCat = $pd->getAllCat();
                                        if ($getCat) {
                                            while ($result = $getCat->fetch_assoc()) {
                                                ?>
                                                <div class="me-4 mb-2">
                                                    <input type="checkbox" name="category[]" value="<?php echo $result['idCategories']; ?>" class="form-check-input"/>
                                                    <label for="cat"><?php echo $result['categoryName']; ?></label><br>
                                                </div>
                                                <?php
                                            }
                                        }?>
                                    </div>
                                </div>
                            </div>
                            <input class="btn btn-outline-success mt-3" type="submit" value="Apply Filter">
                        </form>
                    </div>
                </div>

                <div class="d-flex flex-wrap">
                    <?php
                    $getProductList = $pd->getAllProduct($_POST);
                    if ($getProductList) {
                        while ($result = $getProductList->fetch_assoc()) {
                            ?>
                        <div class="flex-item shadow rounded m-3 p-5 card">
                            <a class="mb-4" href="details.php?idProducts=<?php echo $result['idProducts']; ?>"><img class="w-50" src="images/<?php echo $result['productImage']; ?>" alt="" /></a>
                            <h4 class="mb-3"><?php echo $result['productName']; ?></h4>
                            <p class="h5 mb-4 text-success"><span class="productPrice">$<?php echo $result['productPrice']; ?></span></p>
                            <div class="button"><span><a class="btn btn-danger" href="details.php?idProducts=<?php echo $result['idProducts']; ?>" class="details">View Product</a></span></div>
                        </div>
                        <?php
                        }
                    } else {
                        ?>
                        <h2 class="text-danger"> No Products Found. </h2>
                        <?php
                    } ?>
                </div>
            </div>
        </div>
    </div>			
 </div>