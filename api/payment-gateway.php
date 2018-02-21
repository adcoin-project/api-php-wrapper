<?php
namespace AdCoin;

/**
 * Wrapper class for the payment gateway.
 */
class PaymentGateway {
	private $curl = null; // cURL object
	
	
	
	/**
	 * Creates a new PaymentGateway object:
	 * Prepares for a cURL request to the payment gateway.
	 *
	 * @param string $apiKey The wallet API key used to authenticate payment
	 *                       gateway requests.
	 *
	 * @throws Exception If the provided API key is not a valid string.
	 */
	public function __construct($apiKey) {
		// validate whether the given API key is a string
		if (!is_string($apiKey) && !empty($apiKey)) {
			throw new \Exception('Constructor of PaymentGateway should be given an API key as string.');
			return;
		}
		
		// initialize cURL request
		$this->curl = curl_init();
		curl_setopt_array(
			$this->curl,
			[
				CURLOPT_URL => "https://wallet.getadcoin.com/api/payments",
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "POST",
				CURLOPT_HTTPHEADER => [
					'content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW',
					'X-AUTH-TOKEN: ' . $apiKey
				]
			]
		);
	}
	
	
	
	/**
	 * Destructor of the PaymentGateway object.
	 * Closes the cURL session if it was initialized.
	 */
	public function __destruct() {
		// cleanup the cURL object
		if (null != $this->curl)
			curl_close($this->curl);
	}
	
	
	/**
	 * Requests for a new payment to be opened on the payment gateway.
	 *
	 * @param string redirectUrl URL to redirect the browser to once the payment
	 *                           has been completed.
	 *
	 * @param string webhookUrl  The webhook URL that the the payment gateway
	 *                           will call once the payment is complete and the
	 *                           transaction is complete.
	 *
	 * @param int amount         The amount of ACC to be payed.
	 *
	 * @param string description Text to be shown on the payment page.
	 *
	 * @param Array metadata     JSON compatible array of metadata to send to
	 *                           the webhook. e.g:
	 *                           [ 'name' => 'TestUser' ]
	 *
	 * @throws Exception If an error occurred while executing this method.
	 *
	 * @return false if an error occured.
	 *         Otherwise return the response of the wallet API as a decoded JSON
	 *         object. See the Wallet API documentation for the contents of this
	 *         response.
	 *         For example, the value of ->links->paymentUrl contains the URL
	 *         to the payment page.
	 */
	public function openPayment($redirectUrl, $webhookUrl, $amount, $description, $metadata) {
		// validate parameters
		if (!is_int($amount)) {
			throw new \Exception('openPayment() requires $amount to be an integer.');
			return false;
		}
		if (!filter_var($redirectUrl, FILTER_VALIDATE_URL)) {
			throw new \Exception('openPayment() requires $redirectUrl to be a valid URL string.');
			return false;
		}
		if (!filter_var($webhookUrl, FILTER_VALIDATE_URL)) {
			throw new \Exception('openPayment() requires $webhookUrl to be a valid URL string.');
			return false;
		}
		if (!is_string($description)) {
			throw new \Exception('openPayment() requires $description to be of type string.');
			return false;
		}
		if (!is_array($metadata)) {
			throw new \Exception('openPayment() requires $metadata to be a JSON compatible array.');
			return false;
		}
		
		// set POST fields
		$fields = $this->makePostField('amount',      $amount);
		$fields .= $this->makePostField('redirectUrl', $redirectUrl);
		$fields .= $this->makePostField('webhookUrl',  $webhookUrl);
		$fields .= $this->makePostField('description', $description);
		$fields .= $this->makePostField('metadata', json_encode($metadata, JSON_FORCE_OBJECT));
		$fields .= "------WebKitFormBoundary7MA4YWxkTrZu0gW--";
		curl_setopt($this->curl, CURLOPT_POSTFIELDS, $fields);
		
		// send request to the wallet API
		$response = curl_exec($this->curl);
		
		// check if an error occurred while sending the request
		if ($err = curl_error($this->curl)) {
			throw new \Exception("openPayment() failed to send a request to the wallet API. cURL returned \"{$err}\"");
			return false;
		}
		
		// success: Return response array
		return json_decode($response);
	}
	
	
	
	/**
	 * Helper function for the creation of the CURLOPT_POSTFIELDS string.
	 */
	private function makePostField($name, $value) {
		$o = "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\n";
		$o .= "Content-Disposition: form-data; name=\"{$name}\"\r\n\r\n";
		$o .= "{$value}\r\n";
		return $o;
	}
}
?>