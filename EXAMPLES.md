# Example usage

## Initiating the PaymentGateway class

```php
<?php

require __DIR__.'/vendor/autoload.php';

use AdCoin\API\PaymentGateway;

$paymentGateway = new PaymentGateway('myApiKey');
```

## Creating a payment

```php
<?php

require __DIR__.'/vendor/autoload.php';

use AdCoin\API\PaymentGateway;

$paymentGateway = new PaymentGateway('myApiKey');

$payment = $paymentGateway->openPayment(
    200,
    'My payment description',
    'https://www.myapp.com/checkout/status',
    'https://www.myapp.com/checkout/webhook',
    ['name' => 'TestUser']
);

header('Location: '.$payment['links']['paymentUrl']);
```

## Getting all payments

```php
<?php

require __DIR__.'/vendor/autoload.php';

use AdCoin\API\PaymentGateway;

$paymentGateway = new PaymentGateway('myApiKey');

$payments = $paymentGateway->getPayments();

print_r($payments);
```

## Getting single payment

```php
<?php

require __DIR__.'/vendor/autoload.php';

use AdCoin\API\PaymentGateway;

$paymentGateway = new PaymentGateway('myApiKey');

$payment = $paymentGateway->getPayment('ID');

print_r($payment);
```
