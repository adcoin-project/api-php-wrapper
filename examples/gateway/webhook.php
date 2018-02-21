<?php
/*
 * This file serves as an example webhook page to provide the payment gateway
 * with.
 * Once a payment has been successful and the transaction has been confirmed
 * a POST request will be sent to this webhook.
 * This webhook logs all the given POST data to a new file.
 */

// Aquire all POST data into a formatted string
$postFields = print_r($_POST, true);

// Open a new file for writing
$filename = (string)time() . '.txt'; // {Unix timestamp}.txt
$file = fopen($filename, 'w');
if (!$file) {
	error_log('An error occurred while opening file of name "' . $filename . '".');
	die();
}

// Write POST fields to file
fwrite($file, $postFields);

// Close the file
fclose($file);

?>