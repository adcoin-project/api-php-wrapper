# AdCoin API client for PHP

Accept payments in AdCoin on your website or inside your platform in minutes with the official AdCoin Payment Gateway. No fixed costs or punishing registration procedures. Receive payments anonymous and without transaction or registration costs for both the receiver and sender. 

This project serves as an easy-to-use PHP wrapper for the functionalities provided by the AdCoin Wallet API.
Furthermore, this repository contains a handful of example implementations utilizing the wrapper.

## Requirements
* Get yourself a free AdCoin Web Wallet account at [wallet.getadcoin.com](https://wallet.getadcoin.com). No sign up costs.
* Click on your username in the right upper corner and go to ‘API Key’ and generate your key. 
* Now you’re ready to use the AdCoin API Client. 
* PHP >= 5.3
* PHP cURL extension


## Testing the payment gateway
The `examples/gateway` directory contains the example implementation of the payment gateway.
In order to run the example, you should first configure the `examples/gateway/index.php` file to refer to your own webhook URL and Wallet API key.

## Receiving payments 
To successfully receive a payment, these steps should be implemented:
1.	Use the AdCoin Payment Gateway client to start a new payment request. 
2.	The gateway redirects the user directly after the unconfirmed ACC amount is received within the Web wallet
3.	The customer returns and after 5 minutes the webhook is called to check if the amount of AdCoin is already getting confirmed by the blockchain network. 

## Getting started
Requiring the included api client.

```require '/api/payment-gateway.php';```

Create a new payment

```
try {
	// Send a payment request
	$gateway = new \AdCoin\PaymentGateway($myApiKey);
	$response = $gateway->openPayment($myRedirectPage, $myWebhookUrl, $myAmount, $myDescription, $myMetadata);
}
```
### Catching initial succesfull payment
The redirectUrl only get’s called when a payment is succesfull. Otherwise the user is getting returned to the previous page. After the payment is confirmed by the blockchain network, the webhookUrl is called to update the database.  

## API documentation ##
If you wish to learn more about our API, please visit the [Official API Documentation](https://www.getadcoin.com/api). API Documentation is available in English.

## Want to help us make our API client even better? ##

Want to help us make our API client even better? We take [pull requests](https://github.com/adcoin-project/api-php-wrapper/pulls), sure.  AdCoin Click BV is hiring developers and system engineers. Interested? [Join us for a coffee](mailto:info@getadcoin.com).

## License ##
[BSD (Berkeley Software Distribution) License](https://opensource.org/licenses/bsd-license.php).
Copyright (c) 2013-2018, AdCoin Click B.V.

## Support ##
Contact: [www.getadcoin.com](https://www.getadcoin.com) — support@getadcoin.com
