# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## 2.3.0

## Added

- Support for `psr/http-message` v2
- Allow newer versions of `psr/log` (2.0 and 3.0)

## Removed

- No longer support PHP versions older than 8.1

## 2.2.1

### Fixed

- Prevent application crash when API returns empty response.

## 2.2.0

### Added

- Support for PHP 8

### Removed

- Support for PHP 7.1

### 2.1.0

### Added

- Add tracking capabilities for Deutsche Post shipments.

## 2.0.0

### Changed

- HTTPlug package is upgraded to version 2.
- PHP-HTTP packages are replaced by their PSR successors. SDK now requires a `psr/http-client-implementation`.

### Removed

- PHP 7.0 is no longer supported.

## 1.0.0

- Initial release
