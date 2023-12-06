# DPDHL Group unified shipment tracking API SDK

The Shipment Tracking API provides up-to-the-minute shipment status reports. Users of this API can:

- Retrieve tracking information for shipments.
- Identify the Deutsche Post DHL (DPDHL) service provider involved with the shipment.
- Verify DPDHL is using the correct delivery address. This can reduce the number of misdelivered shipments.

## Requirements

### System Requirements

- PHP 8.1+ with JSON extension

### Package Requirements

- `netresearch/jsonmapper`: Mapper for deserialization of JSON response messages into PHP objects
- `php-http/discovery`: Discovery service for HTTP client and message factory implementations
- `php-http/httplug`: Pluggable HTTP client abstraction
- `php-http/logger-plugin`: HTTP client logger plugin for HTTPlug
- `psr/http-client`: PSR-18 HTTP client interfaces
- `psr/http-factory`: PSR-7 HTTP message factory interfaces
- `psr/http-message`: PSR-7 HTTP message interfaces
- `psr/log`: PSR-3 logger interfaces

### Virtual Package Requirements

- `psr/http-client-implementation`: Any package that provides a PSR-18 compatible HTTP client
- `psr/http-factory-implementation`: Any package that provides PSR-7 compatible HTTP message factories
- `psr/http-message-implementation`: Any package that provides PSR-7 HTTP messages

### Development Package Requirements

- `fig/log-test`: PSR-3 logger implementation for testing purposes
- `nyholm/psr7`: PSR-7 HTTP message factory & message implementation
- `phpunit/phpunit`: Testing framework
- `php-http/mock-client`: HTTPlug mock client implementation
- `phpstan/phpstan`: Static analysis tool
- `rector/rector`: Automatic refactoring tool to help with PHP upgrades
- `squizlabs/php_codesniffer`: Static analysis tool
- `symfony/finder`: file utility for loading pre-recorded web service responses

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

The library's components suitable for consumption comprise

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
