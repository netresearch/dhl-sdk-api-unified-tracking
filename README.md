# DPDHL Group unified shipment tracking API SDK

The Shipment Tracking API provides up-to-the-minute shipment status reports. Users of this API can:

- Retrieve tracking information for shipments.
- Identify the Deutsche Post DHL (DPDHL) service provider involved with the shipment.
- Verify DPDHL is using the correct delivery address. This can reduce the number of misdelivered shipments.

## Requirements

### System Requirements

- PHP 7.0+ with JSON extension

### Package Requirements

- `netresearch/jsonmapper`: Mapper for deserialization of JSON response messages into PHP objects
- `php-http/discovery`: Discovery service for HTTP client and message factory implementations
- `php-http/httplug`: Pluggable HTTP client abstraction
- `php-http/logger-plugin`: HTTP client logger plugin for HTTPlug
- `php-http/message`: Message factory implementations & message formatter for logging
- `php-http/message-factory`: HTTP message factory interfaces
- `psr/http-message`: PSR-7 HTTP message interfaces
- `psr/log`: PSR-3 logger interfaces

### Virtual Package Requirements

- `php-http/client-implementation`: Any package that provides a HTTPlug HTTP client
- `php-http/message-factory-implementationn`: Any package that provides HTTP message factories
- `psr/http-message-implementation`: Any package that provides PSR-7 HTTP messages
- `psr/log-implementation`: Any package that provides a PSR-3 logger

### Development Package Requirements

- `guzzlehttp/psr7`: PSR-7 HTTP message implementation
- `phpunit/phpunit`: Testing framework
- `php-http/mock-client`: HTTPlug mock client implementation
- `phpstan/phpstan`: Static analysis tool
- `symfony/finder`: File loader for web service mock responses
- `squizlabs/php_codesniffer`: Static analysis tool

## Installation

```bash
$ composer require dhl/sdk-api-unified-tracking
```

## Uninstallation

```bash
$ composer remove dhl/sdk-api-unified-tracking
```

## Testing

```bash
$ ./vendor/bin/phpunit -c test/phpunit.xml
```

## Static code analysis

```bash
$ ./vendor/bin/phpstan --level=7 analyze ./src/
```

```bash
$ ./vendor/bin/phpcs --standard=PSR12 src/ test/
```

## Features

The DPDHL Group unified shipment tracking API SDK supports the following features:

* Fetch advanced information about a trackable shipment


### Tracking Service

Fetch information about shipment status of a trackable shipment no matter which business unit of DHL is actually processing the shipment.
Additional search parameters can be provided to narrow down possible search results.

#### Public API

The library's components suitable for consumption comprise of

* service:
  * service factory
  * tracking service
* data transfer objects:
  * track information with detailed shipment events

#### Usage

```php
<?php
$consumerKey = 'Your application consumer key';
$logger = new \Psr\Log\NullLogger();
$defaultTimeZone = new \DateTimeZone('Europe/Berlin'); // or date_default_timezone_get()
$trackingNumber = '9876543210';

$serviceFactory = new \Dhl\Sdk\UnifiedTracking\Service\ServiceFactory();
$service = $serviceFactory->createTrackingService($consumerKey, $logger, $defaultTimeZone);

$response = $service->retrieveTrackingInformation($trackingNumber);
```
