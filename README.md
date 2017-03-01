# Google Crawler
[![Latest Stable Version](https://poser.pugx.org/cviniciussdias/google-crawler/v/stable)](https://packagist.org/packages/cviniciussdias/google-crawler)
[![Build Status](https://travis-ci.org/CViniciusSDias/google-crawler.svg?branch=master)](https://travis-ci.org/CViniciusSDias/google-crawler)
[![Code Coverage](https://scrutinizer-ci.com/g/CViniciusSDias/google-crawler/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/CViniciusSDias/google-crawler/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/CViniciusSDias/google-crawler/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/CViniciusSDias/google-crawler/?branch=master)
[![License](https://poser.pugx.org/cviniciussdias/google-crawler/license)](https://packagist.org/packages/cviniciussdias/google-crawler)

A simple Crawler for getting Google results.

This component can be used to retrieve the 100 first results for a search term.

Since google detects a crawler and blocks the IP when several requests are made,
this component is prepared to use some online proxy services, such as hide.me.

## Instalation
Install the latest version with
```
$ composer require cviniciussdias/google-crawler
```

## Usage

### Without proxy
```php
<?php
use CViniciusSDias\GoogleCrawler\{
    Crawler, SearchTerm
};

$searchTerm = new SearchTerm('Test');
$crawler = new Crawler($searchTerm); // or new Crawler($searchTerm, new NoProxy());

$results = $crawler->getResults();
```

### With some proxy
```php
<?php
use CViniciusSDias\GoogleCrawler\{
    Crawler, SearchTerm, Proxy\CommonProxy
};

$searchTerm = new SearchTerm('Test');
$commonProxy = new CommonProxy('https://proxy-us.hideproxy.me/includes/process.php?action=update');
$crawler = new Crawler($searchTerm, $commonProxy);

$results = $crawler->getResults();
```

## About

### Requirements

- This component works with PHP 7.1 or above
- This component requires the extension [php-ds](http://php.net/manual/pt_BR/book.ds.php) to be installed

### Author
Vinicius Dias - carlosv775@gmail.com - https://github.com/CViniciusSDias/

### License
This component is licensed under the GPL License - see the `LICENSE` file for details