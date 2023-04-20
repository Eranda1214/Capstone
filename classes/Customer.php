<?php
$filepath = realpath(dirname(__FILE__));
include_once($filepath.'/../database/Database.php');
include_once($filepath.'/../classes/Validation.php');
include_once($filepath.'/../classes/Session.php');
 ?>
<?php 


class Customer
{
    private $db;
    private $val;

    public function __construct()
    {
        $this->db = new Database();
        $this->val = new Validation();
    }

    public function userRegistration($data)
    {
        $firstName = $this->val->validate($data['firstName']);
        $lastName = $this->val->validate($data['lastName']);
        $userEmail = $this->val->validate($data['userEmail']);
        $passwordClean = $this->val->validate($data['password']);
        $confirm_password = $this->val->validate($data['confirm_password']);
        
        $firstName = mysqli_real_escape_string($this->db->link, $firstName);
        $lastName = mysqli_real_escape_string($this->db->link, $lastName);
        $userEmail = mysqli_real_escape_string($this->db->link, $userEmail);
        $password = mysqli_real_escape_string($this->db->link, md5($passwordClean));

        $msg = [];
        $msg = $this->val->validateRegistration($firstName, $lastName, $userEmail, $passwordClean, $confirm_password);

        // if msg has a length of 3, then there are no errors
        if ( count($msg) != 3 ) {
            return $msg;
        } else {
            $query = "INSERT INTO users (firstName, lastName, userEmail, password) VALUES(? , ? , ? , ?)";
            $stmt = mysqli_prepare($this->db->link, $query);
            mysqli_stmt_bind_param($stmt, 'ssss', $firstName, $lastName, $userEmail, $password);
            $inserted_row = $this->db->insert($stmt);

            if ($inserted_row) {
                $msg['submit'] = "<div class='alert alert-success mt-4' role='alert'>Registered Successfully. <a href='login.php'>Back to Login</a></div>";
                return $msg;
            } else {
                $msg['submit'] = "<div class='alert alert-danger mt-4' role='alert'>Registration Failed</div>";
                return $msg;
            }
        }
    }

    public function userLogin($data)
    {
        $userEmail 	= $this->val->validate($data['userEmail']);
        $passwordClean  	= $this->val->validate($data['password']);

        $userEmail 	= mysqli_real_escape_string($this->db->link, $userEmail);
        $password 	= mysqli_real_escape_string($this->db->link, md5($passwordClean));

        $msg = [];
        $msg = $this->val->validateAuth($userEmail, $passwordClean);

        if (count($msg) != 1 ) {
            $msg['test'] = "test";
            return $msg;
        } else {
            $query = "SELECT * FROM users WHERE userEmail = '$userEmail' AND password = '$password'";
            $result = $this->db->select($query);
            if ($result == false) {
                $msg['submit'] = "<span class='text-danger'>Email or Password do not match databse</span>";
                return $msg;
            } else {
                $value = $result->fetch_assoc();
                Session::init();
                Session::set("userlogin", true);
                Session::set("userID", $value['idUsers']);
                Session::set("userName", $value['firstName']);
                header("Location:products.php");
            }
        }
    }
    
}
