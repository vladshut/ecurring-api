eCurring Api
===============
This package provides a simple integration of the [Official eCurring][ecurring-api-documentation] for your PHP project.

Installation
------------
With [composer](http://packagist.org), add:

```bash
$ composer require vladshut/ecurring-api
```
This package has been created with flexability in mind, you can simply create your own http adapter by implementing the `VladShut\eCurring\Http\ClientInterface`

Don't wanna do the hassle? make use of the provided Guzzle adapter: require guzzlehttp in your composer:

```bash
$ composer require guzzlehttp/guzzle
```

Get Access Token
-----
[Sign up](https://app.ecurring.com/merchants/signup) at eCurring and get yourself an api key

Usage
-----

#### Create new Customer
```php
use VladShut\eCurring\eCurringClientFactory;
use VladShut\eCurring\Resource\Customer;
use VladShut\eCurring\Resource\Transaction\PaymentMethod;

$client = eCurringClientFactory::create('<ApiKey>');

$customer = Customer::new(
    'Luke',
    'Skywalker',
    PaymentMethod::directDebit(),
    'L Skywalker',
    'NL17ABNA1171403585'
);

$customer = $client->createCustomer($customer);
```

#### Add Customer to subscription
```php
use VladShut\eCurring\eCurringClientFactory;
use VladShut\eCurring\Resource\Subscription;
use VladShut\eCurring\Resource\Subscription\Mandate;

$client = eCurringClientFactory::create('<ApiKey>');

$customer = $client->getCustomer(1);
$subscriptionPlan = $client->getSubscriptionPlan(2);


/**
 * Mandate is Optional, if you dont provide it eCurring wil create a
 * mandate for you and the customer can accept the mandate via eCurring
 * see https://docs.ecurring.com/subscriptions/create
 */
$mandate = new Mandate(
    'MDT-000001',
    true,
    new DateTimeImmutable('2018-10-16')
);

$subscription = Subscription::new(
    $customer,
    $subscriptionPlan,
    $mandate
);

$subscription = $client->createSubscription($subscription);
```

#### Create Payment for subscription
```php
use VladShut\eCurring\eCurringClientFactory;
use VladShut\eCurring\Resource\Transaction;
use Money\Money;

$client = eCurringClientFactory::create('<ApiKey>');

$subscription = $client->getSubscription(1);

$transaction = Transaction::new(
    $subscription,
    Money::EUR(1000),
    new DateTimeImmutable('2018-11-20')
);

$transaction = $client->createTransaction($transaction);
```

#### List Customers and iterate over them
```php
use VladShut\eCurring\eCurringClientFactory;
use VladShut\eCurring\Resource\Curser\Pagination;

$client = eCurringClientFactory::create('<ApiKey>');

$pagination =  new Pagination(2); //-- [optional] Lets start pagination on page 2
$customers = $client->getCustomers($pagination);

$customers->disableAutoload(); //-- just iterate over one page

foreach ($customers as $customer) {
    // Do something with the customer
}

```

Tests
-----

This package comes with 2 types of tests: Unit and Integration.
To run them you can use the make commands in the projects root.

```bash
$ make tests-unit
$ make tests-integration
```

Author
-------

eCurring API has been developed by [LauLaman] and improved by [vladshut]

[ecurring-api-documentation]: https://developers.nest.com/documentation
[LauLaman]: https://github.com/LauLaman
