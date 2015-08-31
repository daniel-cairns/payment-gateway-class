<?php 

session_start();
// Get the config file
require '../config.php';

// Require the PxPay library
require 'app/PxPay_Curl.inc.php';

// Create an instance of the library
$pxpay = new PxPay_Curl('https://sec.paymentexpress.com/pxpay/pxaccess.aspx', $PxPay_Userid, $PxPay_Key);

// Create a new requeat object
$request = new PxPayRequest();

// Prepare a URL to come back to once payment has been completed
$http_host = getenv('HTTP_HOST'); // "localhost"
$folders = getenv('SCRIPT_NAME');

$urlToComeBackTo = 'http://'.$http_host.$folders;

// Loop through the cart and calculate the grand total
$grandTotal = 0;
foreach ($_SESSION['cart'] as $cartItem ) {
	$grandTotal += $cartItem['quantity'] * $cartItem['price'];
}

// Preppare data for PxPay
$request->setAmountInput( $grandTotal );
$request->setTxnType('Purchase'); // Transaction type
$request->setCurrencyInput('NZD');
$request->setUrlFail(PROJECT_ROOT.'payment-response.php');
$request->setUrlSuccess(PROJECT_ROOT.'payment-response.php');
$request->setTxnData1('Dan Cairns');
$request->setTxnData2('17 Freyberg st, Lyall Bay, Wellington, NZ');
$request->setTxnData3('info about the purchase');

// Prepare the request string out of the request data
$requestString = $pxpay->makeRequest($request);

// Send the request to be processed
$response = new MifMessage($requestString);

// Extract the URL so we can redirect the user 
$urlToGoTo = $response->get_element_text('URI');

// Redirect the user
header('Location: '.$urlToGoTo);











