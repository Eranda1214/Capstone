<?php

function cartElement($productimg, $productname, $productprice, $productid){
    $element = "
    
    <form action=\"cart.php?action=remove&id=$productid\" method=\"post\" class=\"cart-items\">
        <div class=\"shadow rounded m-3 p-5\">
            <div class=\"row\">
                <div class=\"col-md-3\">
                    <img src=images/$productimg alt=\"Image1\" class=\"img-fluid\">
                </div>
                <div class=\"col-md-5 ms-5\">
                    <h4 class=\"pt-2 fw-bold\">$productname</h4>
                    <h5 class=\"pt-2 text-success product-price\" data-product-id=\"$productid\" data-product-price=\"$productprice\">$$productprice</h5>
                    <div class=\"d-flex pt-2\">
                        <h5 class=\"me-3\">Quantity:</h5>
                        <input id=\"productId$productid\"type=\"number\" min=\"1\" value=\"1\" class=\"form-control d-inline quantityInput\">
                    </div>
                    <p class=\"text-secondary\">Seller: Techstore</p>
                    <button type=\"submit\" class=\"btn btn-danger\" name=\"remove\">Remove</button>
                </div>
                <div class=\"col-md-3 py-5\">

                </div>
            </div>
        </div>
    </form>
    
    ";
    echo  $element;
}

?>















