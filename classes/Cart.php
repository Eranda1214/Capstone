<?php
$filepath = realpath(dirname(__FILE__));
include_once($filepath.'/../database/Database.php');
include_once($filepath.'/../classes/Validation.php');
include_once($filepath.'/../classes/Session.php');
 ?>
<?php 


class Cart
{
    private $db;
    private $val;

    public function __construct()
    {
        $this->db = new Database();
        $this->val = new Validation();
    }

    public function addOrderItem($orderId, $userId, $productId, $quantity)
    {
        $query = "INSERT INTO order_item(orders_idOrders, orders_users_idUsers, products_idProducts, product_quantity) VALUES(? , ? , ? , ?)";
        $stmt = mysqli_prepare($this->db->link, $query);
        mysqli_stmt_bind_param($stmt, 'iiii', $orderId, $userId, $productId, $quantity);
        $inserted_row = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    

    public function addOrders($data)
    {
        $idUsers = $data['idUsers'];
        $orderAddress = $this->val->validate($data['orderAddress']);
        $orderCity = $this->val->validate($data['orderCity']);
        $orderProvince = $this->val->validate($data['orderProvince']);
        $orderCountry = $this->val->validate($data['orderCountry']);
        $orderPostalCode = $this->val->validate($data['orderPostalCode']);
        $orderPhone = $this->val->validate($data['orderPhone']);

        $orderAddress = mysqli_real_escape_string($this->db->link, $orderAddress);
        $orderCity = mysqli_real_escape_string($this->db->link, $orderCity);
        $orderProvince = mysqli_real_escape_string($this->db->link, $orderProvince);
        $orderCountry = mysqli_real_escape_string($this->db->link, $orderCountry);
        $orderPostalCode = mysqli_real_escape_string($this->db->link, $orderPostalCode);
        $orderPhone = mysqli_real_escape_string($this->db->link, $orderPhone);

        $msg = [];
        $msg = $this->val->validateCheckout($orderAddress, $orderCity, $orderProvince, $orderCountry, $orderPostalCode, $orderPhone, $data['card-num'], $data['expire'], $data['security']);

        if (count($msg) != 6) {
            return $msg;
        } else {
            $query = "INSERT INTO orders(orderAddress, orderCity, orderProvince, orderCountry, orderPostalCode, orderPhone, users_idUsers) 
            VALUES(? , ? , ? , ? , ? , ? , ?)";
            $stmt = mysqli_prepare($this->db->link, $query);
            mysqli_stmt_bind_param($stmt, 'sssssss', $orderAddress, $orderCity, $orderProvince, $orderCountry, $orderPostalCode, $orderPhone, $idUsers);
            $inserted_row = mysqli_stmt_execute($stmt);
            //close statement
            mysqli_stmt_close($stmt);

            // get last inserted id
            $lastId = mysqli_insert_id($this->db->link);

            Session::set('createdOrderId', $lastId);
            return $lastId;
        }

    }


}
