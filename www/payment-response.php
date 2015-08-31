<?php
session_start();
require '../config.php';

// Opbtain the result from the address bar
$result = $_GET['result'];

// Require the PxPay Library
require 'app/PxPay_Curl.inc.php';

// Create instance of the library
$pxpay = new PxPay_Curl('https://sec.paymentexpress.com/pxpay/pxaccess.aspx', $PxPay_Userid, $PxPay_Key);

// Get the response from payment express
$response = $pxpay->getResponse($result);

echo '<pre>';
print_r($response);

// connect to the database
$dbc = new mysqli('localhost', 'root', '', 'payment_gateway');

// If the transaction was a success -- We would store the information into the database
if($response->getSuccess()){
	// Success
	$customerName 		= $response->getTxnData1();
	$customerAddress 	= $response->getTxnData2();
	
	// Mix the customer data
	$contact = $customerName."\n\n".$customerAddress;
	
	// Filter the conatct info
	$contact = $dbc->real_escape_string($contact);
	
	// Create new order in the database
	$sql = "INSERT INTO orders VALUES(NULL, 'approved', 'pending', '$contact', CURRENT_TIMESTAMP, NULL)";
	
	// Run the sql
	$dbc->query($sql);
	
	// Get the Id of the new order
	$orderID = $dbc->insert_id;
	
	// Loop through the cart contents and add them to the ordered products table
	foreach ($_SESSION['cart'] as $cartItem) {
		$productID = $cartItem['id'];
		$quantity = $cartItem['quantity'];
		$price = $cartItem['price'];
	
		// Prepare the SQL
		$sql = "INSERT INTO ordered_products
		VALUES (NULL, $orderID, $productID, $quantity, $price)";
		
		// Run the SQL
		$dbc->query($sql);
	}

	// Clear the cart
	$_SESSION['cart'] = [];

}else{
	// Fail
}