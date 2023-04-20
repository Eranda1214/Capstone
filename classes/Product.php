<?php
$filepath = realpath(dirname(__FILE__));
include_once($filepath.'/../database/Database.php');
include_once($filepath.'/../classes/Validation.php');
 ?>
<?php 

class Product
{
    private $db;
    private $val;

    public function __construct()
    {
        $this->db = new Database();
        $this->val = new Validation();
    }

    public function getAllProduct($filter)
    {
        $query = "SELECT p.*, c.categoryName, b.brandName
            FROM products AS p
            LEFT JOIN categories AS c ON p.productCategory = c.idCategories
            LEFT JOIN brands AS b ON p.productBrand = b.idBrand";

        if (isset($filter['brand']) && count($filter['brand']) > 0) {
            $brandIds = []; // [1,2,3] array of ids
            foreach ($filter['brand'] as $key => $value) {
                array_push($brandIds, $filter['brand'][$key]);
            }
            $brandStrFilter = implode(',', $brandIds);
            $query = $query . " WHERE p.productBrand IN ($brandStrFilter)";
        }

        if (isset($filter['category']) && count($filter['category']) > 0) {
            $categoryIds = []; // [1,2,3] array of ids
            foreach ($filter['category'] as $key => $value) {
                array_push($categoryIds, $filter['category'][$key]);
            }
            $categoryStrFilter = implode(',', $categoryIds);

            if (!isset($filter['brand'])) {
                $query = $query . " WHERE p.productCategory IN ($categoryStrFilter)";
            } else {
                $query = $query . " AND p.productCategory IN ($categoryStrFilter)";
            }
        }

        $query = $query . " ORDER BY p.idProducts DESC";

        $result = $this->db->select($query);

        return $result;
    }

    public function getProById($idProducts)
    {
        $query = "SELECT * FROM products WHERE idProducts = '$idProducts'";
        $result = $this->db->select($query);
        return $result;
    }

    public function getSingleProduct($idProducts)
    {
        $query = "SELECT p.*, c.categoryName, b.brandName
                    FROM products AS p, categories AS c, brands AS b
                    WHERE p.productCategory = c.idCategories AND p.productBrand = b.idBrand AND p.idProducts = '$idProducts'";
        
        $result = $this->db->select($query);
        return $result;
    }

    public function getAllCat()
    {
        $query = "SELECT * FROM categories ORDER BY idCategories ASC";
        $result = $this->db->select($query);
        return $result;
    }

    public function getAllBrands()
    {
        $query = "SELECT * FROM brands ORDER BY idBrand ASC";
        $result = $this->db->select($query);
        return $result;
    }

}