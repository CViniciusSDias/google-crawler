# Google Crawler

A simple Crawler for getting Google results.

This component can be used to retrieve the 100 first results for a search term.

Since google detects a crawler and blocks the IP when several requests are made,
this component is prepared to use some online proxy services, such as hide.me.

## Instalation
Install the latest version with
```
$ composer require cviniciussdias/google-crawler
```

## Basic Usage
```php
<?php
use CViniciusSDias\GoogleCrawler\{
    Crawler, SearchTerm
};

$searchTerm = new SearchTerm('Test');
$crawler = new Crawler($searchTerm);

$results = $crawler->getResults();
```

### Using with some proxy
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