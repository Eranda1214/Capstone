<?php
//include connection file 
//include "config/config.php";
include_once "database/db_conn.php";
include_once "classes/Session.php";
include_once('fpdf184/fpdf.php');

Session::init();
$orderId = Session::get('createdOrderId');

class PDF extends FPDF
{
// Page header
function Header()
{
    // Logo
    
	//$this->Image('logo/conestogalogo.png',90,30,20);
	//$this->Ln(50);
    $this->SetFont('Arial','B',19);
    // Move to the right
    //$this->Cell(50);
    // Title
    $this->Cell(0,0,'INVOICE',0,0,'C');
     //Line break
     $this->Ln(20);
}

// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',10);
    // Title
    $this->Cell(0,0,'Thank You To Order Here...',0,0,'L');
   
    // Page number
    //$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}


// select all data from database with order id join with order items, products and customers
$result = mysqli_query($dbc, "SELECT * FROM orders JOIN order_item ON orders.idOrders = order_item.orders_idOrders JOIN products ON order_item.products_idProducts = products.idProducts JOIN users ON orders.users_idUsers = users.idUsers WHERE orders.idOrders = $orderId");                                                                                                                                             
// $header = mysqli_query($dbc, "SHOW columns FROM employees WHERE field != 'created_on'");

$pdf = new PDF();


foreach($result as $row) {
//header
$pdf->AddPage();
//foter page
$pdf->AliasNbPages();
$pdf->SetFont('Arial','',12);
$pdf->SetY(60);
$pdf->Cell(20,10,'Date:',0,0,'L',false); 
$date =  date("F j, Y");
$pdf->Cell(20,10,$date,0,0,'L',false); 
$pdf->SetY(70);
$pdf->Cell(20,10,'Name:',0,0,'L',false);  
$pdf->Cell(20,10,$row["firstName"],0,1,'L',false); 
$pdf->SetFont('Arial','B',12);
$pdf->Cell(20,10,'Contact Details',0,0,'L',false);
$pdf->SetY(90);
$pdf->SetFont('Arial','',12);
$pdf->Cell(20,10,'Address:',0,0,'L',false);
$pdf->Cell(20,10,$row["orderAddress"],0,1,'L',false); 
$pdf->Cell(20,10,'City:',0,0,'L',false);
$pdf->Cell(20,10,$row["orderCity"],0,1,'L',false);
$pdf->Cell(20,10,'Country:',0,0,'L',false);  
$pdf->Cell(20,10,$row["orderCountry"],0,1,'L',false); 
$pdf->Cell(30,10,'PostalCode:',0,0,'L',false);  
$pdf->Cell(20,10,$row["orderPostalCode"],0,1,'L',false); 
$pdf->Cell(30,10,'ContactNo:',0,0,'L',false);  
$pdf->Cell(20,10,$row["orderPhone"],0,1,'L',false); 
$pdf->SetFont('Arial','B',12);
$pdf->Cell(20,10,'Product Details',0,0,'L',false);
$pdf->SetY(150);
$pdf->SetFont('Arial','',12);
$pdf->Cell(30,10,'ProductName:',0,0,'L',false); 
$pdf->Cell(10,10,$row["productName"],0,1,'L',false); 


$pdf->Cell(30,10,'ProductPrice:',0,0,'L',false); 
$pdf->Cell(10,10,$row["productPrice"],0,1,'L',false);
$pdf->Cell(30,10,'Quantity:',0,0,'L',false);
$pdf->Cell(10,10,$row["product_quantity"],0,1,'L',false);







}
//ob_end_clean();
//ob_start();
$pdf->Output();

?>
