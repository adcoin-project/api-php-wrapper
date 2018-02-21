<?php
/*
 * This example script utilizes the PaymentGateway class to redirect the user
 * to the payment gateway.
 */

// Your wallet API key.
//$myApiKey = '';

// URL to redirect the user to once the payment has been completed.
//$myRedirectPage = 'http://localhost/wallet-api-wrapper/examples/gateway/thankyou.php';

// URL of your webhook that receives a POST request from the payment gateway
// once the transaction has been confirmed.
//$myWebhookUrl   = '';

// Payment description to be shown on the payment page.
$myDescription  = 'Buy me a beer.';

// Amount of AdCoins to be payed.
$myAmount      = 1;

// Array of metadata to send to your webhook once the transaction is confirmed.
$myMetadata    = [ 'TestData' => 'My metadata' ];



// Enable PHP error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include the PaymentGateway class
require '../../api/payment-gateway.php';

try {
	// Send a payment request
	$gateway = new \AdCoin\PaymentGateway($myApiKey);
	$response = $gateway->openPayment($myRedirectPage, $myWebhookUrl, $myAmount, $myDescription, $myMetadata);
	
} catch (Exception $e) {
	// Print exception error message
	echo $e->getMessage();
	die();
	
} finally {
	
	// Check if the payment request was successful
	if (isset($response->message)) {
		// Print returned message
		echo 'Payment gateway returned: "'.$response->message.'".';
	} else {
		// Redirect the user to the payment page
		header('Location: ' . $response->links->paymentUrl);
	}
}
?>