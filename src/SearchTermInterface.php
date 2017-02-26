<?php
namespace CViniciusSDias\GoogleCrawler;

/**
 * This interface defines that every class that implements it must be able to represent itself as a string.
 * A class that implements this interface represents a search term, containing any validation and normalization
 * rules that it requires to be sent to the search engine.
 *
 * @package CViniciusSDias\GoogleCrawler
 * @author Vinicius Dias
 */
interface SearchTermInterface
{
    public function __toString(): string;
}
