<?php
namespace CViniciusSDias\GoogleCrawler;

use PHPUnit\Framework\TestCase;

class SearchTermTest extends TestCase
{
    public function testSearchTermShouldNotHaveSpaces()
    {
        $searchTerm = new SearchTerm('Search Term');
        static::assertEquals('Search+Term', $searchTerm);
    }
}
