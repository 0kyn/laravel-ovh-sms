# OVH SMS (tiny) wrapper for Laravel 5+

## Introduction

This package is an unofficial wrapper for OVH SMS Service intended for Laravel 5+.

This project used php-ovh api (https://github.com/ovh/php-ovh) - v2.0.1.

## Installation
1. Require package with composer  
```sh
composer require okn/laravel-ovh-sms
```

2. **Only for Laravel version < 5.5**  
Add the service provider and class alias for facade support in `config/app.php`
```php
'providers' => [
	// ...
	Okn\OvhSms\OvhSmsServiceProvider::class
];

'aliases' => [
   	// ...
   	'OvhSms' => Okn\OvhSms\Facades\OvhSms::class
];
```

3. Run artisan command to install the service
```sh
php artisan ovhsms:install
```
This command will create a default config file `config/ovhsms.php`.

## Configuration
Application keys must be defined in the `.env` file as follow:
```env
OVHSMS_APP_KEY=
OVHSMS_APP_SECRET=
OVHSMS_CONSUMER_KEY=
OVHSMS_ENDPOINT=
OVHSMS_SERVICE_NAME=
```

## Usage

### Default use
1. Create a message
```php
$sms = OneSignal::createMessage('This my sms. Can you read it ?');
```

2. Send message
```php
$smsStatus = $sms->send(['+xxxxxxxxxxx']);
```

### Limit parts of sms to be sent
```php
$sms->limitParts(1)->send(['+xxxxxxxxxxx']);
```
This will throw an exception if sms parts estimated number is greater than the limit you defined.

# Exception(s)

`cURL error 60: SSL certificate problem...`  
cURL need an SSL certificate to communicate through **https** protocol.

## Solution 1 (recommended)

### Install an SSL certificate on your local machine
Assuming you are using WAMP on Windows:

* download an SSL certificate for your local server
https://curl.haxx.se/ca/cacert.pem  
* put it in your prefered directory (mine is `C:\Users\[MY-USERNAME]\cacert.pem`)
* edit this variable in your `php.ini` to add the path to the certificate
```ini
curl.cainfo = "C:\Users\[MY-USERNAME]\cacert.pem"
```
* restart your webserver

Now it should works, if it doesn't you might try the next solution.

## Solution 2

### Disable SSL validation (not recommended)
In `.env` file you can add the following line:
```env
OVHSMS_VERIFY_SSL=false
```