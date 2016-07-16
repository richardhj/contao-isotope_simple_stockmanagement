# Simple Stock Management for Isotope eCommerce

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]]()
[![Dependency Status][ico-dependencies]][link-dependencies]

Just a simple stock management for Isotope eCommerce. The stock per product is not a simple counter – every stock change will be tracked and you will be able to see which order caused a product's stock change (good for troubleshooting).
Provides the possibility to deactivate a product if it runs out of stock. Provides the possibility to send (multiple) messages to the shop admin by configurable stock thresholds.

## Install

Via Composer

``` bash
$ composer require richardhj/contao-isotope_simple_stockmanagement
```

## Usage

* Activate and configure stock management for the product type (Isotope > Shop configuration > …)
* Add the attribute "stock" to the product type
* Create initial stock for the products by editing the product

## To be integrated or fixed

* Messages for "product in stock" etc. in the front end
* Languge files

## License

The  GNU Lesser General Public License (LGPL).

[ico-version]: https://img.shields.io/packagist/v/richardhj/contao-isotope_simple_stockmanagement.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-LGPL-brightgreen.svg?style=flat-square
[ico-dependencies]: https://www.versioneye.com/php/richardhj:contao-isotope_simple_stockmanagement/badge.svg

[link-packagist]: https://packagist.org/packages/richardhj/contao-isotope_simple_stockmanagement
[link-dependencies]: https://www.versioneye.com/php/richardhj:contao-isotope_simple_stockmanagement